<?php
/**
 * FAQ sekce — $faq_tags = ['kompost', 'faq'] nebo prázdné pro vše
 * $faq_heading = volitelný nadpis
 * $faq_standalone = true (default) — obalí do <section>, false uvnitř faq.php
 */
$faq_items = seo_get_faq_items($faq_tags ?? ['faq']);
if (empty($faq_items)) {
    return;
}
$heading = $faq_heading ?? 'Časté dotazy';
$standalone = $faq_standalone ?? true;
$limit = $faq_limit ?? 0;
$show_label = $faq_show_label ?? $standalone;
if ($limit > 0) {
	$faq_items = array_slice($faq_items, 0, $limit);
}
if ($standalone) {
    echo '<section class="faq-section" id="faq"><div class="container-fluid">';
}
?>
		<?php if ($show_label) { ?><span class="section-label">FAQ</span><?php } ?>
		<?php if ($heading !== '') { ?>
		<h2 class="green"><?php echo htmlspecialchars($heading); ?></h2>
		<?php } ?>
		<div class="faq-list">
			<?php foreach ($faq_items as $item) { ?>
			<details class="faq-item">
				<summary><?php echo htmlspecialchars($item['question']); ?></summary>
				<div class="faq-answer">
					<p><?php echo htmlspecialchars($item['answer']); ?></p>
				</div>
			</details>
			<?php } ?>
		</div>
		<?php if (($current_page ?? '') !== 'faq') { ?>
		<p class="faq-more"><a href="/faq">Všechny časté dotazy →</a></p>
		<?php } ?>
<?php
if ($standalone) {
    echo '</div></section>';
}
?>
