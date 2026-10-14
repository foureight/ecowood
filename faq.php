<?php
require_once 'includes/init.php';

$page_title = 'Časté dotazy | Kompostárna ECOWOOD Unhošť';
$page_description = 'Odpovědi na časté dotazy o kompostu, substrátech, cenách, svozu bioodpadu a dopravě. Kompostárna ECOWOOD Unhošť u Kladna, rozvoz do Prahy a okolí.';
$page_keywords = 'FAQ kompostárna, kompost Unhošť dotazy, svoz bioodpadu, substráty Kladno, ECOWOOD kontakt, jak objednat kompost';
$page_faq_tags = ['faq'];
$breadcrumbs = [
	['name' => 'Úvod', 'url' => 'index.php'],
	['name' => 'Časté dotazy', 'url' => 'faq.php'],
];

require 'includes/head.php';
require 'includes/header.php';
require 'includes/breadcrumbs.php';
?>

<main>
	<div class="page-hero">
		<div class="container-fluid">
			<h1>Časté dotazy</h1>
			<p class="lead">Odpovědi na nejčastější otázky o kompostu, substrátech, dopravě a službách kompostárny <b>ECOWOOD</b>.</p>
		</div>
	</div>

	<section class="main-content main-content--subpage faq-page">
		<div class="container-fluid">
			<?php
			$faq_tags = ['faq'];
			$faq_heading = 'Kompost, substráty a služby';
			$faq_standalone = false;
			require 'includes/faq-section.php';
			?>
		</div>
	</section>

	<?php require 'includes/geo-areas.php'; ?>
	<?php require 'includes/related-pages.php'; ?>
	<?php require 'includes/footer.php'; ?>
</main>

<?php require 'includes/scripts.php'; ?>
