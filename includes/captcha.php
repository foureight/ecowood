<?php
/**
 * Jednoduchá kontrolní otázka pro kontaktní formulář.
 *
 * Nepoužívá session ani externí službu — správná odpověď se podepíše
 * klíčem níže a ověří se až při odeslání.
 *
 * PO NASAZENÍ ZMĚŇTE EW_CAPTCHA_SECRET na vlastní náhodný řetězec.
 */

if (!defined('EW_CAPTCHA_SECRET')) {
    define('EW_CAPTCHA_SECRET', 'ecowood-zmente-tento-klic-na-vlastni-nahodny-retezec');
}

function ew_captcha_sign($answer, $time)
{
    return hash_hmac('sha256', $answer . '|' . $time, EW_CAPTCHA_SECRET);
}

function ew_captcha_new()
{
    $words = [1 => 'jedna', 2 => 'dvě', 3 => 'tři', 4 => 'čtyři', 5 => 'pět', 6 => 'šest', 7 => 'sedm', 8 => 'osm', 9 => 'devět'];

    $a = random_int(1, 9);
    $b = random_int(1, 5);
    $time = time();

    // Jedno číslo slovem, aby otázku nešlo přečíst jednoduchým skriptem
    $question = random_int(0, 1)
        ? $words[$a] . ' + ' . $b
        : $a . ' + ' . $words[$b];

    return [
        'question' => $question,
        'token' => ew_captcha_sign($a + $b, $time),
        'time' => $time,
    ];
}

function ew_captcha_verify($answer, $token, $time)
{
    $time = (int) $time;
    if ($time <= 0 || !is_numeric($answer) || !is_string($token)) {
        return false;
    }

    // Odeslání do dvou sekund od načtení zvládne jen robot, po hodině je otázka prošlá
    $age = time() - $time;
    if ($age < 2 || $age > 3600) {
        return false;
    }

    return hash_equals(ew_captcha_sign((int) $answer, $time), $token);
}
