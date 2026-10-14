<?php
require_once 'includes/init.php';

$page_title = 'Kompost Unhošť a Kladno — prodej i rozvoz | Kompostárna ECOWOOD';
$page_description = 'Kvalitní kompost a humus z kompostárny ECOWOOD u Unhoště. Osobní odběr i rozvoz kontejnerem do Kladna, Prahy a Středočeského kraje. Ceník a příjem bioodpadu.';
$page_keywords = 'kompost Unhošť, kompost Kladno, kompost Hostivice, kompost Praha, cena kompostu, humus, tříděný kompost, uložení bioodpadu, kompostárna ECOWOOD, Středočeský kraj';
$page_og_image = 'https://www.ecowood.cz/images/hero1.jpg';
$page_og_image_alt = 'Hotový kompost z kompostárny ECOWOOD Unhošť';
$page_faq_tags = ['kompost', 'faq'];
$breadcrumbs = [
	['name' => 'Úvod', 'url' => 'index.php'],
	['name' => 'Kompost', 'url' => 'kompost.php'],
];

require 'includes/head.php';
require 'includes/header.php';
require 'includes/breadcrumbs.php';
?>

<main>
	<div class="page-hero">
		<div class="container-fluid">
			<h1>Kompost</h1>
			<p class="lead">Z biologicky rozložitelného odpadu vyrábíme kvalitní humus pro zahrady, parky i zemědělské využití.</p>
		</div>
	</div>

	<section class="main-content main-content--subpage">
		<div class="container-fluid">
			<span class="section-label">Produkt</span>
			<figure class="content-figure">
				<?php ew_picture('images/hero1.jpg', 'Hotový kompost z kompostárny ECOWOOD Unhošť', ['lazy' => false, 'sizes' => '(min-width: 1225px) 1195px, 100vw']); ?>
			</figure>
			<p class="lead">Kompostováním biologicky rozložitelných odpadů vytváříme kvalitní humus, který vracíme zpět přírodě. Náš kompost vzniká za kontrolovaných podmínek a ověřených technologických postupů, díky čemuž má stabilní kvalitu vhodnou pro zahrady, parky i&nbsp;zemědělské využití.</p>

			<h2>Co je kompostování</h2>
			<p>Kompostování je biologická metoda využívání biologicky rozložitelného odpadu (BRO), kterou se za kontrolovaných podmínek aerobních procesů (za přístupu vzduchu) a činností mikroorganismů přeměňuje BRO na kompost. Kompost je organické hnojivo, které se získá aerobním rozkladem směsi organického materiálu. Je jedinečným zdrojem humusu a má vysokou výměnnou kapacitu pro živiny (dusík, vápník, hořčík, draslík), které rostlinám postupně uvolňuje – navázané živiny se tak nevyplavují do spodních a povrchových vod.</p>

			<h3>Přínosy kompostu pro půdu</h3>
			<ul>
				<li>zvyšuje biologickou aktivitu půdy a její samočistící schopnost</li>
				<li>rozpouští živiny z půdních minerálů pro rostliny</li>
				<li>zlepšuje výživu rostlin stopovými prvky</li>
				<li>zlepšuje strukturu a jímavost půdy pro vodu (snižuje riziko povodní)</li>
				<li>dodává půdě tmavou barvu, která zvyšuje její záhřevnost</li>
				<li>zvyšuje odolnost půdy proti okyselení</li>
				<li>váže těžké kovy, a tím omezuje jejich příjem rostlinami</li>
			</ul>

			<h3>Seznam odpadů přijímaných do zařízení</h3>
			<p>Kompostováním biologicky rozložitelných odpadů vytváříme humus, který je posléze možno vrátit přírodě v podobě nejrůznějších zahradních substrátů a zemin.</p>
			<?php require 'includes/waste-table.php'; ?>

			<h2 class="green">Kompost pro Kladno, Prahu a Středočeský kraj</h2>
			<p>Kompostárna <b>ECOWOOD</b> v Unhošti zásobuje zahradníky, firmy i obce v okolí <strong>Kladna</strong>, na <strong>Praze-západě</strong> a v celém <strong>Středočeském kraji</strong>. Nabízíme osobní odběr na místě i rozvoz vlastní dopravou.</p>

			<h2 class="green">Kde kompost dodáváme</h2>
			<p>Kompostárna <b>ECOWOOD</b> sídlí v Unhošti u&nbsp;silnice č. III/0067 mezi Unhoští a Pavlovem, proto je naší přirozenou spádovou oblastí <b>Unhošť a Kladno</b> a okolní obce. Kompost ale pravidelně vozíme i do vzdálenějších lokalit, včetně <b>Prahy</b> — díky poloze u výjezdu z R6 je odtud kompostárna dobře dostupná.</p>

			<h3>Kompost do Hostivice, Chýně a Jenče</h3>
			<p>Po silnici 201 to k nám z <strong>Hostivice</strong> trvá pár minut, takže sem kompost i substráty vozíme běžně. Sběrné dvory bioodpad pouze přijímají — u nás si navíc <b>koupíte hotový kompost</b>, zeminu nebo mulčovací kůru a přivezeme je až na zahradu či stavbu. Stejně obsluhujeme <strong>Chýni</strong>, <strong>Jeneč</strong> i <strong>Červený Újezd</strong>.</p>

			<p>O dovoz nebo odvoz kompostu si můžete napsat přes <a href="/kontakt">kontaktní formulář</a>, nebo nás rovnou kontaktovat telefonicky.</p>

			<p class="page-actions">
				<a href="/kompost-ew" class="btn btn-primary">Složení a dávkování</a>
				<a href="/cenik" class="btn btn-secondary">Zobrazit ceník</a>
				<a href="/substraty" class="btn btn-secondary">Substráty</a>
			</p>
		</div>
	</section>

	<?php
	$faq_tags = ['kompost', 'geo'];
	$faq_heading = 'Dotazy o kompostu a dopravě';
	require 'includes/faq-section.php';
	?>
	<?php require 'includes/related-pages.php'; ?>
	<?php require 'includes/footer.php'; ?>
</main>

<?php require 'includes/scripts.php'; ?>
