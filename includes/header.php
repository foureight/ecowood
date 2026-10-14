<?php require __DIR__ . '/opening-hours.php'; ?>
<?php if ($alert != null && strlen($alert->text)) { ?>
<div class="alert alert-warning alert-dismissible" role="alert">
	<?php echo $alert->text; ?>
	<button type="button" class="close" data-dismiss="alert" title="Zavřít">
		<span aria-hidden="true"></span>
	</button>
</div>
<?php } ?>
<header class="header">
	<div class="container-fluid">
		<a href="/" class="logo"><img src="images/logo.svg" alt="Kompostárna ECOWOOD Unhošť" width="209" height="40"></a>

		<nav class="menu" id="menu">
			<ul>
				<li><a href="/kompost"<?php echo $current_page === 'kompost' ? ' class="active"' : ''; ?>>Kompost</a></li>
				<li><a href="/substraty"<?php echo $current_page === 'substraty' ? ' class="active"' : ''; ?>>Substráty</a></li>
				<li><a href="/sluzby"<?php echo $current_page === 'sluzby' ? ' class="active"' : ''; ?>>Služby</a></li>
				<li><a href="/cenik"<?php echo $current_page === 'cenik' ? ' class="active"' : ''; ?>>Ceník</a></li>
				<li><a href="/faq"<?php echo $current_page === 'faq' ? ' class="active"' : ''; ?>>FAQ</a></li>
				<li><a href="/kontakt"<?php echo $current_page === 'kontakt' ? ' class="active"' : ''; ?>>Kontakt</a></li>
			</ul>
		</nav>
		<a href="/cenik" class="btn btn-primary" id="btn-cenik">Ceník</a>
	</div>
	<button type="button" class="menu-link" aria-controls="menu" aria-expanded="false" aria-label="Hamburger menu" data-target="#menu">
		<span class="hamburger">
			<span class="hamburger__bar hamburger__bar--left"></span>
			<span class="hamburger__bar hamburger__bar--right"></span>
		</span>
	</button>
	<button type="button" class="menu-close" title="Zavřít">
		<span aria-hidden="true"></span>
	</button>
</header>
