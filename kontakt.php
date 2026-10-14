<?php
require_once 'includes/init.php';

$page_title = 'Kontakt | Kompostárna ECOWOOD Unhošť u Kladna';
$page_description = 'Kontakt na kompostárnu ECOWOOD — Unhošť p.p.č. 442/2, okres Kladno. GPS 50.0896°N, 14.1562°E. Telefon +420 602 525 903, e-mail ecowood@ecowood.cz.';
$page_keywords = 'kontakt kompostárna Unhošť, ECOWOOD adresa, kompostárna Kladno mapa, GPS Unhošť, telefon kompostárna';
$page_og_image = 'https://www.ecowood.cz/images/mapa.jpg';
$page_og_image_alt = 'Mapa — kompostárna ECOWOOD Unhošť u silnice mezi Unhoští a Pavlovem';
$page_faq_tags = ['geo', 'kontakt', 'faq'];
$breadcrumbs = [
	['name' => 'Úvod', 'url' => 'index.php'],
	['name' => 'Kontakt', 'url' => 'kontakt.php'],
];

require 'includes/head.php';
require 'includes/header.php';
require 'includes/breadcrumbs.php';
?>

<main>
	<div class="page-hero">
		<div class="container-fluid">
			<h1>Kontakt</h1>
			<p class="lead">Kompostárna <b>ECOWOOD</b> Unhošť — u silnice mezi Unhoští a Pavlovem, snadno dostupná z Prahy i Kladna.</p>
		</div>
	</div>

	<section class="map" id="kde-nas-najdete">
		<div class="container-fluid">
			<h2 class="green">Kde nás najdete?</h2>
			<div class="map-wrapper">
				<div class="map-left">
					<a href="https://goo.gl/maps/CStPXoByYE3w289X9" target="_blank" rel="noopener" title="Zobrazit Google mapu"><?php ew_picture('images/mapa.jpg', 'Mapa — poloha kompostárny ECOWOOD u silnice III/0067 mezi Unhoští a Pavlovem', ['sizes' => '(min-width: 768px) 48vw, 100vw']); ?></a>
				</div>
				<div class="map-right">
					<h3 class="map-head">Kompostárna ECOWOOD Unhošť leží u silnice č. III/0067 mezi Unhoští a Pavlovem</h3>
					<p><span class="green">Příjezd od Prahy</span> R6 směr Karlovy Vary → exit 12 směr Unhošť → silnice 201 směr Jeneč → směr Pavlov</p>
					<p><span class="green">Příjezd od Kladna</span> silnice 61 směr Unhošť → silnice 201 směr Jeneč → směr Pavlov</p>
					<div class="gps green">GPS poloha: 50°5'22.629"N, 14°9'22.31"E</div>
				</div>
			</div>
		</div>
	</section>

	<section class="contact contact-page" id="kontakt">
		<div class="container-fluid">
			<div class="contact-left" itemscope itemtype="https://schema.org/LocalBusiness">
				<meta itemprop="name" content="Kompostárna ECOWOOD">
				<meta itemprop="telephone" content="+420602525903">
				<meta itemprop="email" content="ecowood@ecowood.cz">
				<div itemprop="geo" itemscope itemtype="https://schema.org/GeoCoordinates">
					<meta itemprop="latitude" content="50.0896194">
					<meta itemprop="longitude" content="14.1561972">
				</div>
				<h2 class="green">Kontaktní údaje</h2>
				<b itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
					<span itemprop="streetAddress">Unhošt p.p.č 442/2</span>,
					<span itemprop="addressLocality">Unhošť</span>,
					okres <span itemprop="addressRegion">Kladno</span>,
					<span itemprop="postalCode">273 51</span>
				</b>

				<h3>Vlastník a provozovatel kompostárny:</h3>
				<p><b>ECOWOOD</b> s.r.o., Praha&nbsp;2, Ječná 550/1, PSČ 120&nbsp;00<br>
				zápis u&nbsp;Městského soudu v&nbsp;Praze, oddíl&nbsp;C, vložka 125227<br>
				IČ: 279 00 797</p>

				<h3>Kontakt</h3>
				<p><a href="mailto:ecowood@ecowood.cz">ecowood@ecowood.cz</a><br>
				+420 602 525 903, +420 777 737 756</p>
			</div>
			<div class="contact-right">
				<h2 class="green">Napište nám</h2>
				<?php require 'includes/contact-form.php'; ?>
			</div>
		</div>
	</section>

	<?php
	$faq_tags = ['geo', 'kontakt'];
	$faq_heading = 'Dotazy k dopravě a kontaktu';
	require 'includes/faq-section.php';
	?>
	<?php require 'includes/geo-areas.php'; ?>
	<?php require 'includes/related-pages.php'; ?>
	<?php require 'includes/footer.php'; ?>
</main>

<?php require 'includes/scripts.php'; ?>
