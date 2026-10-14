<?php
require_once 'includes/init.php';

$page_title = 'Zahradnické substráty a zeminy Unhošť | Kompostárna ECOWOOD';
$page_description = 'Zahradnické, trávníkové a střešní substráty a zeminy z vlastní výroby. Kompostárna ECOWOOD Unhošť, rozvoz Kladno, Praha a Praha-západ. Ceník online.';
$page_keywords = 'substráty Unhošť, zahradní zemina Kladno, zahradnický substrát, trávníkový substrát, střešní substrát, zemina Praha-západ, ECOWOOD, kompostárna';
$page_og_image = 'https://www.ecowood.cz/images/ilustrace1.jpg';
$page_og_image_alt = 'Výroba substrátů v kompostárně ECOWOOD Unhošť';
$page_faq_tags = ['substraty', 'faq'];
$breadcrumbs = [
	['name' => 'Úvod', 'url' => 'index.php'],
	['name' => 'Substráty', 'url' => 'substraty.php'],
];

require 'includes/head.php';
require 'includes/header.php';
require 'includes/breadcrumbs.php';
?>

<main>
	<div class="page-hero">
		<div class="container-fluid">
			<h1>Substráty</h1>
			<p class="lead">Vyrábíme kvalitní substráty pro zahradnictví, zakládání trávníků i zelené střechy.</p>
		</div>
	</div>

	<section class="main-content main-content--subpage">
		<div class="container-fluid">
			<span class="section-label">Výroba</span>
			<h2 class="green">Výroba substrátů</h2>
			<p class="lead">Jednou z našich hlavních činností je výroba substrátu pro použití zejména v oboru zahradnictví při zakládání či renovaci zahrad a parků. Substráty vznikají z našeho kompostu a dalších organických složek podle ověřených technologických postupů.</p>

			<h3>Naše produkty</h3>
			<ul>
				<li>zahradnický substrát</li>
				<li>trávníkový substrát</li>
				<li>střešní substrát extenzivní</li>
				<li>střešní substrát intenzivní</li>
			</ul>

			<div class="vyroba-images">
				<div><?php ew_picture('images/ilustrace1.jpg', 'Výroba substrátů v kompostárně ECOWOOD', ['sizes' => '(min-width: 768px) 50vw, 100vw']); ?></div>
				<div><?php ew_picture('images/ilustrace2.jpg', 'Hotový substrát ECOWOOD', ['sizes' => '(min-width: 768px) 50vw, 100vw']); ?></div>
			</div>

			<h2>Pro koho jsou substráty určeny</h2>
			<p>Substráty dodáváme zahradnickým firmám, stavebním společnostem, obcím i soukromým zákazníkům. Kapacita kompostárny umožňuje realizovat projekty všech velikostí — od menší zahrady po rozsáhlé parkové plochy.</p>
			<p>Rozvoz zajišťujeme vlastními kontejnery (7&nbsp;cbm), případně po domluvě i většími objemy. Více o dopravě a pronájmu kontejnerů najdete na stránce <a href="/sluzby#kontejnery">Služby</a>.</p>

			<h3>Přijímané odpady pro výrobu</h3>
			<p>Kompostováním biologicky rozložitelných odpadů vytváříme humus, který je základem našich substrátů.</p>
			<?php require 'includes/waste-table.php'; ?>

			<p class="page-actions">
				<a href="/cenik" class="btn btn-primary">Zobrazit ceník</a>
			</p>
		</div>
	</section>

	<?php
	$faq_tags = ['substraty'];
	$faq_heading = 'Dotazy o substrátech';
	require 'includes/faq-section.php';
	?>
	<?php require 'includes/related-pages.php'; ?>
	<?php require 'includes/footer.php'; ?>
</main>

<?php require 'includes/scripts.php'; ?>
