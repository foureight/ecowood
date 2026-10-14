<?php
require_once 'includes/init.php';

$page_title = 'Svoz bioodpadu a údržba zeleně | ECOWOOD Unhošť';
$page_description = 'Svoz bioodpadu, pronájem kontejnerů 7 a 14 cbm, odvoz sutě a zeminy, údržba zeleně, vertikutace a zimní údržba. Kompostárna ECOWOOD u Unhoště, okres Kladno.';
$page_keywords = 'svoz bioodpadu Unhošť, pronájem kontejneru Kladno, kontejner na bioodpad, odvoz sutě a zeminy, údržba zeleně, vertikutace, zimní údržba, ECOWOOD, Praha-západ';
$page_og_image = 'https://www.ecowood.cz/images/ilustrace2.jpg';
$page_og_image_alt = 'Služby kompostárny ECOWOOD — svoz odpadu a údržba zeleně';
$page_faq_tags = ['sluzby', 'faq'];
$page_services = [
	['name' => 'Svoz kompostovatelného odpadu', 'description' => 'Doprava 14 cbm kontejneru, odvoz a ekologické zpracování biologicky rozložitelného odpadu v kompostárně ECOWOOD Unhošť.'],
	['name' => 'Pronájem kontejnerů a doprava', 'description' => 'Kontejnery 7 cbm a 14 cbm pro rozvoz substrátů, suť, zeminu a stavební materiály v okolí Kladna a Prahy.'],
	['name' => 'Údržba zeleně', 'description' => 'Sekání trávy, prořezy stromů a keřů, vertikutace trávníků a zimní údržba areálů ve Středočeském kraji.'],
];
$breadcrumbs = [
	['name' => 'Úvod', 'url' => 'index.php'],
	['name' => 'Služby', 'url' => 'sluzby.php'],
];

require 'includes/head.php';
require 'includes/header.php';
require 'includes/breadcrumbs.php';
?>

<main>
	<div class="page-hero">
		<div class="container-fluid">
			<h1>Služby</h1>
			<p class="lead">Komplexní služby kolem kompostování, dopravy a údržby zeleně — pro firmy i soukromníky.</p>
		</div>
	</div>

	<section class="main-content main-content--subpage">
		<div class="container-fluid">
			<span class="section-label">Nabídka služeb</span>
			<h2 class="green">Co umíme</h2>
			<p class="lead">Kromě kompostování a výroby substrátů nabízíme široké spektrum služeb. Držíme se technologických postupů ověřených v praxi a máme dostatek techniky pro projekty všech velikostí.</p>

			<div class="umime-items">
				<div class="umime-item service-block" id="svoz">
					<h3>Svoz kompostovatelného odpadu</h3>
					<p>Rádi k Vám dopravíme velkoobjemový 14&nbsp;cbm kontejner vhodný pro sběr biologicky rozložitelného odpadu. Kontejner po domluvě přivezeme, odvezeme a odpad správným způsobem zpracujeme.</p>
				</div>
				<div class="umime-item service-block" id="kontejnery">
					<h3>Doprava a pronájem kontejnerů</h3>
					<p>Nabízíme 7&nbsp;cbm kontejner, určený zejména na rozvoz našich substrátů. Kontejnery můžeme vyvážet i suť a zeminu ze zemních prací. Kontejnery mohou sloužit i k návozu sypkých stavebních hmot (písek, štěrk).</p>
				</div>
				<div class="umime-item service-block" id="udrzba">
					<h3>Údržba zeleně</h3>
					<p>Zákazníkům nabízíme profesionální služby údržby zeleně, od sekání trávy až po prořezy stromů a keřů. Naše nabídka je komplexní a pokrývá všechny služby, kterých je při údržbě zeleně třeba.</p>
				</div>
				<div class="umime-item service-block">
					<h3>Provzdušňování trávníků a přihnojení</h3>
					<p>Vertikutace (provzdušnění) trávníku umožní lepší přístup vzduchu, vláhy a živin ke kořenům trávy. Doporučuje se aplikovat zejména před přihnojováním trávníku v jarním období.</p>
				</div>
				<div class="umime-item service-block">
					<h3>Prořezy stromů a keřů</h3>
					<p>Pravidelný prořez a tvarování stromů a keřů na začátku a na konci vegetačního období je běžnou službou v rámci komplexní údržby zeleně.</p>
				</div>
				<div class="umime-item service-block">
					<h3>Zimní údržba</h3>
					<p>V zimě používáme naší mechanizaci k zimní údržbě areálů a komunikací posypem, nebo při větším množství sněhu je možno zajistit i odvoz.</p>
				</div>
			</div>

			<h2 class="green">Služby pro Kladno, Unhošť a Prahu</h2>
			<p>Služby kompostárny <b>ECOWOOD</b> využívají zahradnické firmy, stavební společnosti i obce v okolí <strong>Unhoště</strong>, <strong>Kladna</strong> a na <strong>Praze-západě</strong>. Vlastní technika nám umožňuje reagovat flexibilně na zakázky různých velikostí.</p>

			<h2 class="green">Jak objednat službu</h2>
			<p>Napište nám přes <a href="/kontakt">kontaktní formulář</a>, nebo volejte na +420&nbsp;602&nbsp;525&nbsp;903 / +420&nbsp;777&nbsp;737&nbsp;756. Rádi vám poradíme s výběrem služby i s plánováním termínu.</p>

			<p class="page-actions">
				<a href="/kontakt" class="btn btn-primary">Kontaktovat</a>
				<a href="/cenik" class="btn btn-secondary">Ceník</a>
			</p>
		</div>
	</section>

	<?php
	$faq_tags = ['sluzby'];
	$faq_heading = 'Dotazy ke službám';
	require 'includes/faq-section.php';
	?>
	<?php require 'includes/related-pages.php'; ?>
	<?php require 'includes/footer.php'; ?>
</main>

<?php require 'includes/scripts.php'; ?>
