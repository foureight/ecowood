<?php

require_once __DIR__ . '/../classes/alert.php';
require_once __DIR__ . '/../classes/document.php';
require_once __DIR__ . '/../classes/newsimage.php';
require_once __DIR__ . '/image.php';

$alert_tyden = new Alert();
$alert_tyden->id = 1;
$alert_sobota = new Alert();
$alert_sobota->id = 2;
$alert_special = new Alert();
$alert_special->id = 3;
$alert_nedele = new Alert();
$alert_nedele->id = 4;

$alert = null;

$alert_tyden = $alert_tyden->get();
$alert_sobota = $alert_sobota->get();
$alert_nedele = $alert_nedele->get();
$alert_special = $alert_special->get();
$ted = date('Y-m-d');

$tyden = date('N') >= 1 && date('N') <= 5;

if ($ted >= $alert_special->od && $ted <= $alert_special->do) {
    $alert = $alert_special;
} elseif ($tyden) {
    $alert = $alert_tyden;
} elseif (date('N') == 6) {
    $alert = $alert_sobota;
} else {
    $alert = $alert_nedele;
}

$documents = Document::get_all();

$current_page = basename($_SERVER['PHP_SELF'], '.php');
