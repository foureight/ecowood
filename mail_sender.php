<?php

require_once __DIR__ . '/includes/captcha.php';
require_once __DIR__ . '/includes/mailer.php';

header('Content-Type: application/json; charset=utf-8');

$error = "";
$email = "";
$zprava = "";
$jmeno = "";
$telefon = "";
$predmet = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$vysledek['status'] = false;

	// kontrolní otázka
	if(!ew_captcha_verify($_POST["captcha"] ?? "", $_POST["captcha_token"] ?? "", $_POST["captcha_time"] ?? 0)){
		$vysledek['captcha'] = false;
		echo json_encode($vysledek);
		exit;
	}

	// pokud to není robot
	if(($_POST["url"] ?? "") == ""){
		if(isset($_POST["email"]) && isset($_POST["jmeno"]) && isset($_POST["zprava"]) && isset($_POST["predmet"])){
			$email = strip_tags(trim($_POST["email"]));
            if($email == ""){
                $error .= "<li>E-mail</li>";
            }
            else{
                // kontrola spravneho formatu
                $pattern_email = '/[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/';
                if(!preg_match($pattern_email, $email)){
					$error .= "<li>E-mail</li>";
				}
			}

            if(isset($_POST["zprava"])){
                if($_POST["zprava"] != "")
                $zprava = strip_tags(trim($_POST["zprava"]));
            }

            if(isset($_POST["jmeno"])){
                if($_POST["jmeno"] != "")
                $jmeno = strip_tags(trim($_POST["jmeno"]));
            }

            if(isset($_POST["predmet"])){
                if($_POST["predmet"] != "")
                $predmet = strip_tags(trim($_POST["predmet"]));
            }

            if(isset($_POST["telefon"])){
                if($_POST["telefon"] != ""){
					$telefon = strip_tags(trim($_POST["telefon"]));
				}
            }
			
			// pokud jsou hodnoty korektně vyplněny, pošle se e-mail
			if($error == ""){

				$subject = $predmet;
				$text = '<h1>Zpráva z ecowood.cz</h1>';
				$text .= "Jméno a příjmení: ".htmlspecialchars($jmeno);
				$text .= "<br>E-mail: ".htmlspecialchars($email);
				$text .= "<br>Telefon: ";
				$text .= $telefon != "" ? htmlspecialchars($telefon) : "-";
				$text .= "<br><br>Zpráva:<br>".nl2br(htmlspecialchars($zprava));

				[$sent, $chyba] = ew_send_mail($subject, $text, $email);
				$vysledek['status'] = $sent;
				if(!$sent){
					$vysledek['error'] = $chyba;
				}
			}			
		}
	}
	echo json_encode($vysledek);
}
            
function autoUTF($s)
{
	// detect UTF-8
	if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $s))
		return $s;
	// detect WINDOWS-1250
	if (preg_match('#[\x7F-\x9F\xBC]#', $s))
		return iconv('WINDOWS-1250', 'UTF-8', $s);
	// assume ISO-8859-2
	return iconv('ISO-8859-2', 'UTF-8', $s);
}

function cs_mail ($to, $predmet, $zprava, $head = "")
	   {  $predmet = "=?utf-8?B?".base64_encode(autoUTF ($predmet))."?=";
		  $head .= "MIME-Version: 1.0\r\n";
		  $head .= "Content-Type: text/html; charset=\"utf-8\"\r\n";
		  $head .= "Content-Transfer-Encoding: base64\r\n";
		  $head .= "Reply-To: ".$GLOBALS["email"]."\r\n";
		  $head .= "X-Mailer: PHP/" . phpversion();
		  $zprava = base64_encode (autoUTF ($zprava));
		  $stav = mail ($to, $predmet, $zprava, $head);
		  return $stav ?  TRUE : FALSE;  }

?>