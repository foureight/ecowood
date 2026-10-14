<?php
/**
 * Odeslání e-mailu přes SMTP.
 *
 * Hosting bez funkce mail() (např. Zerops) potřebuje SMTP server. Přístupové
 * údaje se čtou z proměnných prostředí, aby heslo nebylo v repozitáři:
 *
 *   EW_SMTP_HOST    např. smtp.seznam.cz
 *   EW_SMTP_PORT    587 pro STARTTLS, 465 pro SSL
 *   EW_SMTP_USER    přihlašovací jméno, obvykle celá e-mailová adresa
 *   EW_SMTP_PASS    heslo
 *   EW_SMTP_SECURE  'tls' (výchozí) nebo 'ssl'
 *   EW_MAIL_FROM    odesílatel, výchozí je EW_SMTP_USER
 *   EW_MAIL_TO      příjemce, výchozí ecowood@ecowood.cz
 *
 * Pokud EW_SMTP_HOST není nastavený, použije se funkce mail().
 */

function ew_mail_config()
{
    $get = function ($key, $default = '') {
        $value = getenv($key);
        return $value === false || $value === '' ? $default : $value;
    };

    $user = $get('EW_SMTP_USER');

    return [
        'host' => $get('EW_SMTP_HOST'),
        'port' => (int) $get('EW_SMTP_PORT', '587'),
        'user' => $user,
        'pass' => $get('EW_SMTP_PASS'),
        'secure' => strtolower($get('EW_SMTP_SECURE', 'tls')),
        'from' => $get('EW_MAIL_FROM', $user),
        'to' => $get('EW_MAIL_TO', 'ecowood@ecowood.cz'),
    ];
}

function ew_smtp_read($socket, &$log)
{
    $data = '';
    while (($line = fgets($socket, 515)) !== false) {
        $data .= $line;
        // Poslední řádek odpovědi má za kódem mezeru, průběžné mají pomlčku
        if (strlen($line) < 4 || $line[3] === ' ') {
            break;
        }
    }
    $log[] = '< ' . trim($data);
    return $data;
}

function ew_smtp_cmd($socket, $command, $expect, &$log, $hide = false)
{
    if ($command !== null) {
        fwrite($socket, $command . "\r\n");
        $log[] = '> ' . ($hide ? '***' : $command);
    }
    $response = ew_smtp_read($socket, $log);
    $code = (int) substr($response, 0, 3);

    if (!in_array($code, (array) $expect, true)) {
        throw new RuntimeException('SMTP odpověď ' . $code . ': ' . trim($response));
    }
    return $response;
}

/**
 * @return array{0: bool, 1: string} úspěch a případná chyba
 */
function ew_send_mail($subject, $html_body, $reply_to = '')
{
    $cfg = ew_mail_config();

    $subject_encoded = '=?utf-8?B?' . base64_encode($subject) . '?=';
    $headers_map = [
        'MIME-Version' => '1.0',
        'Content-Type' => 'text/html; charset="utf-8"',
        'Content-Transfer-Encoding' => 'base64',
    ];
    if ($reply_to !== '' && filter_var($reply_to, FILTER_VALIDATE_EMAIL)) {
        $headers_map['Reply-To'] = $reply_to;
    }
    $body = chunk_split(base64_encode($html_body));

    // Bez SMTP zkusit vestavěnou funkci — na klasickém hostingu stačí
    if ($cfg['host'] === '') {
        if (!function_exists('mail')) {
            return [false, 'Odesílání pošty není na serveru dostupné.'];
        }
        $headers = '';
        foreach ($headers_map as $name => $value) {
            $headers .= $name . ': ' . $value . "\r\n";
        }
        $ok = @mail($cfg['to'], $subject_encoded, $body, $headers);
        return [$ok, $ok ? '' : 'Funkce mail() selhala.'];
    }

    $log = [];
    $socket = null;

    // Na portu 465 se šifruje od začátku, ať je v nastavení cokoli —
    // STARTTLS by tam skončil čekáním na odpověď, která nepřijde.
    if ($cfg['port'] === 465) {
        $cfg['secure'] = 'ssl';
    }

    try {
        $transport = $cfg['secure'] === 'ssl' ? 'ssl://' : '';
        $context = stream_context_create(['ssl' => ['SNI_enabled' => true]]);
        $socket = @stream_socket_client(
            $transport . $cfg['host'] . ':' . $cfg['port'],
            $errno, $errstr, 15, STREAM_CLIENT_CONNECT, $context
        );
        if (!$socket) {
            throw new RuntimeException('Připojení k ' . $cfg['host'] . ' selhalo: ' . $errstr);
        }
        stream_set_timeout($socket, 15);

        ew_smtp_cmd($socket, null, 220, $log);
        $hostname = $_SERVER['SERVER_NAME'] ?? 'ecowood.cz';
        ew_smtp_cmd($socket, 'EHLO ' . $hostname, 250, $log);

        if ($cfg['secure'] === 'tls') {
            ew_smtp_cmd($socket, 'STARTTLS', 220, $log);
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                throw new RuntimeException('Šifrování TLS se nepodařilo navázat.');
            }
            ew_smtp_cmd($socket, 'EHLO ' . $hostname, 250, $log);
        }

        if ($cfg['user'] !== '') {
            ew_smtp_cmd($socket, 'AUTH LOGIN', 334, $log);
            ew_smtp_cmd($socket, base64_encode($cfg['user']), 334, $log);
            ew_smtp_cmd($socket, base64_encode($cfg['pass']), 235, $log, true);
        }

        ew_smtp_cmd($socket, 'MAIL FROM:<' . $cfg['from'] . '>', 250, $log);
        ew_smtp_cmd($socket, 'RCPT TO:<' . $cfg['to'] . '>', [250, 251], $log);
        ew_smtp_cmd($socket, 'DATA', 354, $log);

        $headers_map = array_merge([
            'From' => 'Web ECOWOOD <' . $cfg['from'] . '>',
            'To' => $cfg['to'],
            'Subject' => $subject_encoded,
            'Date' => date('r'),
        ], $headers_map);

        $message = '';
        foreach ($headers_map as $name => $value) {
            $message .= $name . ': ' . $value . "\r\n";
        }
        // Tečka na začátku řádku by ukončila zprávu předčasně
        $message .= "\r\n" . preg_replace('/^\./m', '..', $body);

        fwrite($socket, $message . "\r\n.\r\n");
        ew_smtp_cmd($socket, null, 250, $log);
        ew_smtp_cmd($socket, 'QUIT', [221, 250], $log);
        fclose($socket);

        return [true, ''];
    } catch (Throwable $e) {
        if (is_resource($socket)) {
            fclose($socket);
        }
        error_log('ECOWOOD SMTP: ' . $e->getMessage() . ' | ' . implode(' ', $log));
        return [false, $e->getMessage()];
    }
}
