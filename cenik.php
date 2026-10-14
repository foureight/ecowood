<?php
require_once 'includes/init.php';

$page_title = 'Ceník kompostu, substrátů a kontejnerů | ECOWOOD Unhošť';
$page_description = 'Ceny kompostu, substrátů, mulčovací kůry, uložení bioodpadu, pronájmu kontejnerů i strojů a dopravy. Kompostárna ECOWOOD Unhošť u Kladna.';
$page_keywords = 'ceník kompostu, cena kompostu Kladno, cena substrátu, uložení bioodpadu cena, pronájem kontejneru cena, mulčovací kůra cena, ECOWOOD Unhošť';
$page_og_image = 'https://www.ecowood.cz/images/hero1.jpg';
$page_og_image_alt = 'Ceník kompostárny ECOWOOD Unhošť';
$page_faq_tags = ['kompost', 'substraty'];
$page_products = true;
$breadcrumbs = [
	['name' => 'Úvod', 'url' => 'index.php'],
	['name' => 'Ceník', 'url' => 'cenik.php'],
];

$cenik = json_decode(file_get_contents(__DIR__ . '/data/cenik.json'), true);

require 'includes/head.php';
require 'includes/header.php';
require 'includes/breadcrumbs.php';
?>

<main>
	<div class="page-hero">
		<div class="container-fluid">
			<h1>Ceník</h1>
			<p class="lead">Ceny kompostu, substrátů, uložení bioodpadu, pronájmu kontejnerů i strojů.</p>
		</div>
	</div>

	<section class="main-content main-content--subpage">
		<div class="container-fluid">
			<?php foreach ($cenik['sekce'] as $sekce) { ?>
			<section class="cenik-section" id="<?php echo htmlspecialchars($sekce['id']); ?>">
				<h2 class="green"><?php echo htmlspecialchars($sekce['nazev']); ?></h2>
				<?php if (!empty($sekce['popis'])) { ?>
				<p><?php echo htmlspecialchars($sekce['popis']); ?></p>
				<?php } ?>

				<div class="cenik-table-wrap">
					<table class="cenik-table">
						<thead>
							<tr>
								<?php foreach ($sekce['sloupce'] as $sloupec) { ?>
								<th scope="col"><?php echo htmlspecialchars($sloupec); ?></th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($sekce['radky'] as $radek) { ?>
							<tr>
								<?php foreach ($radek as $i => $bunka) { ?>
								<td data-label="<?php echo htmlspecialchars($sekce['sloupce'][$i]); ?>"<?php echo $i === count($radek) - 1 ? ' class="cenik-cena"' : ''; ?>><?php echo htmlspecialchars($bunka); ?></td>
								<?php } ?>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>

				<?php if (!empty($sekce['poznamka'])) { ?>
				<p class="cenik-note"><?php echo htmlspecialchars($sekce['poznamka']); ?></p>
				<?php } ?>
			</section>
			<?php } ?>

			<?php if (!empty($cenik['stroje'])) { $stroje = $cenik['stroje']; ?>
			<section class="cenik-section" id="<?php echo htmlspecialchars($stroje['id']); ?>">
				<h2 class="green"><?php echo htmlspecialchars($stroje['nazev']); ?></h2>
				<?php if (!empty($stroje['popis'])) { ?>
				<p><?php echo htmlspecialchars($stroje['popis']); ?></p>
				<?php } ?>

				<div class="stroje-grid">
					<?php foreach ($stroje['polozky'] as $stroj) { ?>
					<article class="stroj">
						<h3><?php echo htmlspecialchars($stroj['nazev']); ?></h3>
						<ul class="stroj-params">
							<?php foreach ($stroj['parametry'] as $param) { ?>
							<li><?php echo htmlspecialchars($param); ?></li>
							<?php } ?>
						</ul>
						<table class="cenik-table cenik-table--sazby">
							<tbody>
								<?php foreach ($stroj['sazby'] as $sazba) { ?>
								<tr>
									<td data-label="Doba pronájmu"><?php echo htmlspecialchars($sazba[0]); ?></td>
									<td data-label="Cena bez DPH" class="cenik-cena"><?php echo htmlspecialchars($sazba[1]); ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<p class="cenik-note"><?php echo htmlspecialchars($stroj['doprava']); ?></p>
					</article>
					<?php } ?>
				</div>
			</section>
			<?php } ?>

			<p class="cenik-meta">
				<span class="cenik-platnost">Platnost od <?php echo htmlspecialchars($cenik['platnost']); ?></span>
				<span><?php echo htmlspecialchars($cenik['poznamka_dph']); ?></span>
				<?php if (!empty($cenik['poznamka_platba'])) { ?>
				<span><?php echo htmlspecialchars($cenik['poznamka_platba']); ?></span>
				<?php } ?>
			</p>

			<?php if (!empty($cenik['poznamka_znecisteni'])) { ?>
			<p class="cenik-warning"><?php echo htmlspecialchars($cenik['poznamka_znecisteni']); ?></p>
			<?php } ?>

			<?php if (!empty($cenik['kontakty'])) { ?>
			<section class="cenik-section" id="kontakty-cenik">
				<h2 class="green">Na koho se obrátit</h2>
				<div class="kontakty-grid">
					<?php foreach ($cenik['kontakty'] as [$role, $jmeno, $telefon, $tel_link]) { ?>
					<div class="kontakt-osoba">
						<span class="kontakt-role"><?php echo htmlspecialchars($role); ?></span>
						<strong><?php echo htmlspecialchars($jmeno); ?></strong>
						<a href="tel:<?php echo htmlspecialchars($tel_link); ?>"><?php echo htmlspecialchars($telefon); ?></a>
					</div>
					<?php } ?>
				</div>
			</section>
			<?php } ?>

			<p class="page-actions">
				<a href="/kontakt" class="btn btn-primary">Poptat materiál</a>
				<a href="data/cenik-ecowood-2026-05.pdf" target="_blank" rel="noopener" class="btn btn-secondary">Ceník v PDF</a>
			</p>
		</div>
	</section>

	<?php
	$faq_tags = ['kompost', 'substraty'];
	$faq_heading = 'Dotazy k cenám a odběru';
	$faq_limit = 6;
	require 'includes/faq-section.php';
	?>
	<?php require 'includes/geo-areas.php'; ?>
	<?php require 'includes/related-pages.php'; ?>
	<?php require 'includes/footer.php'; ?>
</main>

<?php require 'includes/scripts.php'; ?>
