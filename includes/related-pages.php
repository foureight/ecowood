<?php
$related = $related_pages ?? [
	['title' => 'Kompost', 'url' => '/kompost', 'desc' => 'Humus a kompost pro Kladno, Prahu a okolí'],
	['title' => 'Substráty', 'url' => '/substraty', 'desc' => 'Zahradnické a trávníkové substráty'],
	['title' => 'Služby', 'url' => '/sluzby', 'desc' => 'Svoz odpadu, kontejnery, údržba zeleně'],
	['title' => 'Ceník', 'url' => '/cenik', 'desc' => 'Ceny kompostu, substrátů, kontejnerů i dopravy'],
	['title' => 'Časté dotazy', 'url' => '/faq', 'desc' => 'Odpovědi ke kompostu, substrátům i dopravě'],
	['title' => 'Kontakt', 'url' => '/kontakt', 'desc' => 'Mapa, GPS a kontaktní formulář'],
];
$current = basename($_SERVER['PHP_SELF'] ?? '', '.php');
$related = array_values(array_filter($related, function ($p) use ($current) {
    return trim($p['url'], '/') !== $current;
}));
if (empty($related)) {
    return;
}
?>
<section class="related-pages">
	<div class="container-fluid">
		<h2 class="green">Další na webu</h2>
		<div class="related-pages-grid">
			<?php foreach (array_slice($related, 0, 3) as $page) { ?>
			<a href="<?php echo htmlspecialchars($page['url']); ?>" class="related-page-card">
				<strong><?php echo htmlspecialchars($page['title']); ?></strong>
				<span><?php echo htmlspecialchars($page['desc']); ?></span>
			</a>
			<?php } ?>
		</div>
	</div>
</section>
