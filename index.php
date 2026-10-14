<?php
require_once 'includes/init.php';

$page_title = 'Kompostárna ECOWOOD Unhošť — kompost a substráty';
$page_description = 'Z bioodpadu vyrábíme humus. Kompost, zahradnické substráty a zeminy, příjem bioodpadu a pronájem kontejnerů. Unhošť u Kladna, rozvoz do Prahy a okolí.';
$page_keywords = 'kompostárna Unhošť, kompost Kladno, kompost Praha, substráty Unhošť, bioodpad, ECOWOOD, humus, svoz odpadu, údržba zeleně, Středočeský kraj';
$page_faq_tags = ['faq'];
$page_canonical = 'https://www.ecowood.cz/';
$page_og_image = 'https://www.ecowood.cz/images/hero.jpg';
$page_og_image_alt = 'Kompostárna ECOWOOD Unhošť u Kladna — výroba kompostu a humusu';

require 'includes/head.php';
require 'includes/header.php';
?>

<main>
	<div class="hero">
		<?php ew_picture('images/hero.jpg', 'Kompostárna ECOWOOD Unhošť u Kladna — výroba kompostu z bioodpadu', ['lazy' => false, 'sizes' => '100vw']); ?>
		<div class="hero-in">
			<div class="container-fluid">
				<h1>Kompostárna ECOWOOD Unhošť —<br>z vašeho bioodpadu vyrábíme humus</h1>
				<div class="hero-actions">
					<a href="/kompost" class="btn btn-primary">Naše komposty</a>
					<a href="/kontakt" class="btn btn-secondary">Kontaktujte nás</a>
				</div>
			</div>
		</div>
	</div>

	<div class="hero-items">
		<div class="container-fluid">
			<a href="/kompost" class="hero-item">Kompostujeme</a>
			<a href="/sluzby#svoz" class="hero-item">Odvezeme</a>
			<a href="/substraty" class="hero-item">Realizujeme</a>
			<a href="/sluzby#udrzba" class="hero-item">Uklízíme</a>
		</div>
	</div>

	<section class="intro-teaser">
		<div class="container-fluid">
			<span class="section-label">O nás</span>
			<h2 class="green">Co děláme</h2>
			<p class="lead">Kompostárna <b>ECOWOOD</b> leží u Unhoště v okrese Kladno a od biologicky rozložitelného odpadu ho vede až k hotovému humusu. Kompostováním za kontrolovaných podmínek z něj vyrábíme kompost, zahradnické substráty a zeminy. Odpad od vás převezmeme nebo přivezeme kontejner a hotový materiál rozvezeme po Kladensku, Praze i celém Středočeském kraji.</p>
			<p class="lead">Jsme dobrý tým a není nám lhostejná naše planeta. Máme dostatek techniky pro malé zahrady i velké projekty — rádi poradíme, nebo vše uděláme za vás.</p>
		</div>
	</section>

	<section class="offer">
		<div class="container-fluid">
			<span class="section-label">Nabídka</span>
			<h2 class="green">Co u nás pořídíte</h2>
			<p class="lead">Kompost a substráty z vlastní výroby, svoz bioodpadu i údržba zeleně — pro zahrádkáře, zahradnické firmy, stavby i obce v okolí Unhoště, Kladna a Prahy.</p>

			<div class="offer-grid">
				<article class="offer-card">
					<a class="offer-card-media" href="/kompost" tabindex="-1">
						<?php ew_picture('images/hero1.jpg', 'Hotový kompost z kompostárny ECOWOOD Unhošť', ['sizes' => '(min-width: 768px) 33vw, 100vw']); ?>
					</a>
					<div class="offer-card-body">
						<h3><a href="/kompost">Kompost a humus</a></h3>
						<p>Kvalitní humus vyrobený kompostováním biologicky rozložitelného odpadu za kontrolovaných podmínek.</p>
						<ul class="offer-list">
							<li>kompost pro zahrady, parky i zemědělství</li>
							<li>stabilní kvalita z ověřené technologie</li>
							<li>osobní odběr i rozvoz kontejnerem</li>
						</ul>
						<a href="/kompost" class="btn btn-secondary">Více o kompostu</a>
					</div>
				</article>

				<article class="offer-card">
					<a class="offer-card-media" href="/substraty" tabindex="-1">
						<?php ew_picture('images/ilustrace1.jpg', 'Výroba zahradnických substrátů v kompostárně ECOWOOD', ['sizes' => '(min-width: 768px) 33vw, 100vw']); ?>
					</a>
					<div class="offer-card-body">
						<h3><a href="/substraty">Zahradnické substráty</a></h3>
						<p>Substráty z vlastního kompostu pro zakládání i renovaci zahrad, trávníků a zelených střech.</p>
						<ul class="offer-list">
							<li>zahradnický a trávníkový substrát</li>
							<li>střešní substrát extenzivní i intenzivní</li>
							<li>projekty od malé zahrady po park</li>
						</ul>
						<a href="/substraty" class="btn btn-secondary">Více o substrátech</a>
					</div>
				</article>

				<article class="offer-card">
					<a class="offer-card-media" href="/sluzby" tabindex="-1">
						<?php ew_picture('images/ilustrace2.jpg', 'Svoz bioodpadu kontejnerem a údržba zeleně', ['sizes' => '(min-width: 768px) 33vw, 100vw']); ?>
					</a>
					<div class="offer-card-body">
						<h3><a href="/sluzby">Svoz a údržba zeleně</a></h3>
						<p>Přivezeme kontejner, odvezeme bioodpad a postaráme se o zeleň po celý rok.</p>
						<ul class="offer-list">
							<li>svoz bioodpadu kontejnerem 14 cbm</li>
							<li>pronájem kontejnerů 7 cbm a doprava</li>
							<li>sekání, prořezy, vertikutace, zimní údržba</li>
						</ul>
						<a href="/sluzby" class="btn btn-secondary">Naše služby</a>
					</div>
				</article>
			</div>
		</div>
	</section>

	<?php require 'includes/geo-areas.php'; ?>

	<section class="faq-section faq-section--home">
		<div class="container-fluid">
			<span class="section-label">FAQ</span>
			<h2 class="green">Máte dotaz?</h2>
			<p class="lead">Nejčastější otázky o kompostu, dopravě a službách kompostárny <b>ECOWOOD</b>.</p>
			<?php
			$faq_tags = ['faq'];
			$faq_heading = '';
			$faq_standalone = false;
			$faq_limit = 4;
			$faq_show_label = false;
			require 'includes/faq-section.php';
			?>
		</div>
	</section>

	<?php if (!empty($documents)) { ?>
	<section class="news">
		<div class="container-fluid">
			<h2>Co je u nás nového?</h2>
			<ul class="news-items">
			<?php for ($d = 0; $d < count($documents); $d++) { ?>
				<li class="news-item"<?php echo $d > 3 ? ' style="display:none"' : ''; ?>>
					<div class="news-item-content">
						<?php
						$images = NewsImage::get_all($documents[$d]->id);
						if (!empty($images)) { ?>
						<div class="news-item-left">
						<?php foreach ($images as $image) {
							echo '<img src="data/images/m/' . htmlspecialchars($image->urlname) . '" alt="">';
						} ?>
						</div>
						<?php } ?>
						<div class="news-item-right">
							<h3><?php echo htmlspecialchars($documents[$d]->title_cz); ?></h3>
							<?php echo html_entity_decode($documents[$d]->text_cz); ?>
						</div>
					</div>
				</li>
			<?php } ?>
			</ul>
			<?php if (count($documents) > 4) { ?>
			<div class="news-next">
				<button type="button" class="btn btn-secondary" id="next-news">Další novinky</button>
				<button type="button" class="btn btn-secondary" id="actual-news" style="display: none;">Aktuální novinky</button>
			</div>
			<?php } ?>
		</div>
	</section>
	<?php } ?>

	<section class="cta-band">
		<div class="container-fluid">
			<h2>Potřebujete ceník nebo konzultaci?</h2>
			<p>Stáhněte si aktuální ceník nebo nám napište — ozveme se co nejdříve.</p>
			<div class="hero-actions">
				<a href="/cenik" class="btn btn-secondary">Zobrazit ceník</a>
				<a href="/kontakt" class="btn btn-primary">Napsat zprávu</a>
			</div>
		</div>
	</section>

	<?php require 'includes/footer.php'; ?>
</main>

<?php require 'includes/scripts.php'; ?>
