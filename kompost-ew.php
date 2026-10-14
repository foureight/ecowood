<?php
require_once 'includes/init.php';

$page_title = 'Kompost EW — organické hnojivo | ECOWOOD Unhošť';
$page_description = 'Kompost EW je registrované organické hnojivo z kompostárny ECOWOOD Unhošť. Složení, obsah živin, dávkování na zahradu i pole, skladování a bezpečnost práce.';
$page_keywords = 'kompost EW, organické hnojivo, dávkování kompostu, složení kompostu, hnojení zeleniny, registrované hnojivo, ECOWOOD Unhošť';
$page_og_image = 'https://www.ecowood.cz/images/hero1.jpg';
$page_og_image_alt = 'Kompost EW — organické hnojivo z kompostárny ECOWOOD';
$page_faq_tags = ['kompost'];
$breadcrumbs = [
	['name' => 'Úvod', 'url' => 'index.php'],
	['name' => 'Kompost', 'url' => 'kompost.php'],
	['name' => 'Kompost EW', 'url' => 'kompost-ew.php'],
];

$vlastnosti = [
	['Vlhkost', '40,0–65,0 %'],
	['Spalitelné látky ve vysušeném vzorku', 'min. 25,0 %'],
	['Celkový dusík jako N ve vysušeném vzorku', 'min. 2,0 %'],
	['Hodnota pH', '6,0–8,5'],
	['Nerozložitelné příměsi', 'max. 2,0 %'],
	['Poměr C : N', 'max. 30'],
];

$rizikove = [
	['kadmium', '2,0'], ['olovo', '100'], ['rtuť', '1,0'], ['arsen', '10'],
	['chrom', '100'], ['molybden', '5'], ['nikl', '50'], ['měď', '100'], ['zinek', '300'],
];

require 'includes/head.php';
require 'includes/header.php';
require 'includes/breadcrumbs.php';
?>

<main>
	<div class="page-hero">
		<div class="container-fluid">
			<h1>Kompost EW</h1>
			<p class="lead">Registrované organické hnojivo z kompostárny <b>ECOWOOD</b> Unhošť — složení, dávkování a skladování.</p>
		</div>
	</div>

	<section class="main-content main-content--subpage">
		<div class="container-fluid">
			<span class="section-label">Produkt</span>
			<h2 class="green">Popis výrobku</h2>
			<p class="lead">Kompost EW je organické hnojivo vyrobené homogenizací a kompostováním biologicky rozložitelného odpadu a dalších surovin rostlinné povahy. Kromě celkového obsahu dusíku má vysoké celkové obsahy fosforu a draslíku.</p>
			<p>Obsahuje živiny v příznivém poměru. Jsou v něm v přirozených množstvích přítomny stopové prvky a růstové stimulátory. Uvolňování živin je pozvolné a rovnoměrné v průběhu celého vegetačního období. Organické látky obsažené v kompostu zvyšují obsah humusu v půdě, poskytují energii a živiny půdním mikroorganismům, zlepšují strukturu a pozitivně působí na další biologické a fyzikálně chemické vlastnosti půd.</p>

			<p><strong>Výrobce:</strong> <b>ECOWOOD</b> s.r.o., Ječná 550/1, 120 00 Praha 2 — kompostárna <b>ECOWOOD</b> Unhošť.<br>
			<strong>Číslo rozhodnutí o registraci:</strong> 3540.</p>

			<h2 class="green">Chemické a fyzikální vlastnosti</h2>
			<div class="cenik-table-wrap">
				<table class="cenik-table">
					<tbody>
						<?php foreach ($vlastnosti as [$nazev, $hodnota]) { ?>
						<tr>
							<td data-label="Vlastnost"><?php echo htmlspecialchars($nazev); ?></td>
							<td data-label="Hodnota" class="cenik-cena"><?php echo htmlspecialchars($hodnota); ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<p class="cenik-note">Obsah rizikových prvků splňuje zákonem stanovené limity v mg/kg sušiny:
				<?php echo implode(', ', array_map(fn($r) => $r[0] . ' ' . $r[1], $rizikove)); ?>.</p>

			<h2 class="green">Rozsah a způsob použití</h2>
			<p>Kompost EW se používá na hnojení zemědělských plodin, zeleniny, ovoce a květin.</p>

			<h3>Zemědělské plodiny</h3>
			<p>Doporučená dávka je <strong>do 15 t/ha</strong>. Dávkování se upravuje podle druhů a nároků pěstovaných plodin, případně podle rozboru půdy. Aplikuje se zpravidla na podzim a bezprostředně po aplikaci je nutné kompost zapravit do půdy.</p>

			<h3>Zelenina a ovoce</h3>
			<p>Hnojivo se dávkuje podle nároků jednotlivých druhů k rostlinám a mělce se zapraví do půdy. Při mísení s původní zeminou se volí poměr <strong>maximálně 3 až 4 : 1</strong> — tedy 3 až 4 díly původní zeminy a nejvýše 1 díl hnojiva — před sázením.</p>

			<h3>Květiny</h3>
			<p>Při přesazování se hnojivo smíchá s původní zeminou v poměru <strong>maximálně 3 až 4 : 1</strong> podle nároků druhu rostliny.</p>

			<p class="cenik-warning">Hnojivo není vhodné pro rostliny vyžadující kyselou půdní reakci.</p>

			<h2 class="green">Skladování</h2>
			<p>Výrobek se dodává volně ložený nebo balený. Doba použitelnosti je <strong>12 měsíců</strong> při dodržení podmínek skladování.</p>
			<p>Volně ložený výrobek musí být skladován na chráněném místě tak, aby nedošlo ke zhoršení jeho vlastností. Skladujte jej odděleně od potravin a krmiv a uchovávejte mimo dosah dětí.</p>
			<p>Balený výrobek skladujte na suchých místech v neporušených obalech odděleně od hnojiv, potravin, krmiv a dezinfekčních prostředků i obalů od zmíněných přípravků. Uchovávejte mimo dosah dětí.</p>

			<h2 class="green">Bezpečnost a ochrana zdraví při práci</h2>
			<p>Při práci dodržujte základní hygienická pravidla a používejte ochranné rukavice. Nejezte, nepijte a nekuřte. Po práci si omyjte ruce vodou a mýdlem a ošetřete reparačním krémem.</p>

			<h3>První pomoc</h3>
			<ul>
				<li><strong>Zasažení očí:</strong> rychle a důkladně vypláchnout oči proudem čisté vody, při rozsáhlejším postižení vyhledat lékaře.</li>
				<li><strong>Zasažení pokožky:</strong> opláchnout dostatečným množstvím vody a následně omýt vodou a mýdlem.</li>
				<li><strong>Náhodné požití:</strong> bezprostředně vypít 0,5 l vody.</li>
			</ul>

			<p class="page-actions">
				<a href="/cenik" class="btn btn-primary">Cena kompostu</a>
				<a href="/kontakt" class="btn btn-secondary">Objednat</a>
			</p>
		</div>
	</section>

	<?php
	$faq_tags = ['kompost'];
	$faq_heading = 'Dotazy ke kompostu';
	$faq_limit = 6;
	require 'includes/faq-section.php';
	?>
	<?php require 'includes/related-pages.php'; ?>
	<?php require 'includes/footer.php'; ?>
</main>

<?php require 'includes/scripts.php'; ?>
