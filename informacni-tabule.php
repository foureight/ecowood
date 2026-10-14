<?php
require_once 'includes/init.php';
require_once 'includes/seo-config.php';

$page_title = 'Informační tabule kompostárny | ECOWOOD Unhošť';
$page_description = 'Informační tabule kompostárny ECOWOOD Unhošť — provozovatel, odpovědní pracovníci, provozní doba a seznam odpadů přijímaných do zařízení.';
$page_keywords = 'informační tabule kompostárny, provozní řád, přijímané odpady, katalogová čísla odpadů, ECOWOOD Unhošť';
$breadcrumbs = [
	['name' => 'Úvod', 'url' => 'index.php'],
	['name' => 'Informační tabule', 'url' => 'informacni-tabule.php'],
];

$hours = seo_opening_hours();
$day_names = [1 => 'Pondělí', 2 => 'Úterý', 3 => 'Středa', 4 => 'Čtvrtek', 5 => 'Pátek', 6 => 'Sobota', 7 => 'Neděle'];

require 'includes/head.php';
require 'includes/header.php';
require 'includes/breadcrumbs.php';
?>

<main>
	<div class="page-hero">
		<div class="container-fluid">
			<h1>Informační tabule kompostárny</h1>
			<p class="lead">Kompostárna <b>ECOWOOD</b> Unhošť — povinné údaje o provozovateli, provozní době a přijímaných odpadech.</p>
		</div>
	</div>

	<section class="main-content main-content--subpage">
		<div class="container-fluid">
			<div class="tabule-grid">
				<section class="tabule-block">
					<h2 class="green">Vlastník a provozovatel</h2>
					<p>
						<strong>ECOWOOD s.r.o.</strong><br>
						Ječná 550/1, 120 00 Praha 2<br>
						zápis u Městského soudu v Praze, oddíl C, vložka 125227<br>
						IČ: 279 00 797
					</p>
					<p>
						<strong>Zařízení</strong><br>
						Kompostárna <b>ECOWOOD</b> Unhošť<br>
						Unhošť p.p.č. 442/2, 273 51 Unhošť, okres Kladno<br>
						u silnice č. III/0067 mezi Unhoští a Pavlovem
					</p>
				</section>

				<section class="tabule-block">
					<h2 class="green">Odpovědní pracovníci</h2>
					<p>
						<strong>Vedoucí pracovník kompostárny</strong><br>
						Ing. Miloslav Malý<br>
						<a href="tel:+420777737756">777 737 756</a>
					</p>
					<p>
						<strong>Maloobchodní prodej</strong><br>
						Aleš Kohout<br>
						<a href="tel:+420602611593">602 611 593</a>
					</p>
					<p>
						<strong>Velkoobchodní prodej</strong><br>
						Marek Chmelík<br>
						<a href="tel:+420602525903">602 525 903</a>
					</p>
				</section>

				<section class="tabule-block">
					<h2 class="green">Provozní doba</h2>
					<ul class="tabule-seasons">
						<?php foreach (seo_opening_hours_seasons() as $season) { ?>
						<li>
							<span class="tabule-season-days"><?php echo htmlspecialchars($season['dny']); ?></span>
							<span class="tabule-season-hours"><?php echo htmlspecialchars($season['doba']); ?></span>
							<span class="tabule-season-period"><?php echo htmlspecialchars($season['obdobi']); ?></span>
						</li>
						<?php } ?>
					</ul>
					<p class="cenik-note">
						Ve státní svátky a dny pracovního klidu je zavřeno.
						<?php echo SEO_LAST_LOADING_NOTE; ?>
						Po dohodě s odpovědnými pracovníky je možný i jiný termín.
					</p>
				</section>
			</div>

			<section class="tabule-block tabule-block--wide">
				<h2 class="green">Seznam odpadů přijímaných do zařízení</h2>
				<?php require 'includes/waste-table.php'; ?>
			</section>

			<p class="page-actions">
				<a href="/kontakt" class="btn btn-primary">Kontakt</a>
				<a href="/cenik" class="btn btn-secondary">Ceník</a>
			</p>
		</div>
	</section>

	<?php require 'includes/related-pages.php'; ?>
	<?php require 'includes/footer.php'; ?>
</main>

<?php require 'includes/scripts.php'; ?>
