<nav class="bottom-menu">
	<div class="container-fluid">
		<div class="bottom-menu-col">
			<h3 class="green">Menu</h3>
			<ul>
				<li><a href="/">Úvod</a></li>
				<li><a href="/kompost">Kompost</a></li>
				<li><a href="/substraty">Substráty</a></li>
				<li><a href="/sluzby">Služby</a></li>
				<li><a href="/cenik">Ceník</a></li>
				<li><a href="/faq">Časté dotazy</a></li>
				<li><a href="/kontakt">Kontakt</a></li>
			</ul>
		</div>
		<div class="bottom-menu-col">
			<h3 class="green">Kontakt</h3>
			<address class="footer-nap">
				<strong>Kompostárna ECOWOOD</strong>
				Unhošť p.p.č. 442/2<br>
				273 51 Unhošť, okres Kladno<br>
				<a href="tel:+420602525903">+420 602 525 903</a><br>
				<a href="mailto:ecowood@ecowood.cz">ecowood@ecowood.cz</a>
			</address>
			<p class="footer-hours"><?php
				require_once __DIR__ . '/seo-config.php';
				$fh = seo_opening_hours();
				echo $fh[(int) date('N')] === null
					? 'Dnes zavřeno'
					: 'Dnes otevřeno ' . $fh[(int) date('N')][0] . '–' . $fh[(int) date('N')][1];
			?></p>
			<p><a href="/kontakt#kde-nas-najdete">Mapa a GPS →</a></p>
		</div>
		<div class="bottom-menu-col">
			<h3 class="green">Stahování</h3>
			<ul>
				<li><a href="/informacni-tabule">informační tabule kompostárny</a></li>
				<li><a href="/kompost-ew">příbalový leták kompostu EW</a></li>
				<li><a href="/cenik">ceník EW</a></li>
			</ul>
		</div>
		<div class="bottom-menu-col">
			<h3 class="green">Sleduj nás</h3>
			<a href="https://www.facebook.com/kompostarna" target="_blank" rel="noopener" title="Facebook" class="fb-link"><span class="sr-only">Facebook</span></a><a href="https://www.instagram.com/kompostarna_ecowood/" target="_blank" rel="noopener" title="Instagram" class="in-link"><span class="sr-only">Instagram</span></a>
		</div>
	</div>
</nav>
<footer class="footer">
	<div class="container-fluid">
		<div class="footer-left">&copy; ecowood <?php echo date('Y'); ?></div>
		<div class="footer-right"><a href="https://forejt.net/" target="_blank" rel="noopener">forejt.net</a></div>
	</div>
</footer>
