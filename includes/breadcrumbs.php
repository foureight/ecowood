<?php require_once __DIR__ . "/seo-config.php"; ?>
<?php if (!empty($breadcrumbs)) { ?>
<nav class="breadcrumbs" aria-label="Drobečková navigace">
	<div class="container-fluid">
		<ol itemscope itemtype="https://schema.org/BreadcrumbList">
			<?php foreach ($breadcrumbs as $i => $crumb) {
				$is_last = $i === count($breadcrumbs) - 1;
				?>
			<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<?php if (!$is_last) { ?>
				<a itemprop="item" href="<?php echo htmlspecialchars(seo_clean_path($crumb['url'])); ?>">
					<span itemprop="name"><?php echo htmlspecialchars($crumb['name']); ?></span>
				</a>
				<?php } else { ?>
				<span itemprop="name"><?php echo htmlspecialchars($crumb['name']); ?></span>
				<?php } ?>
				<meta itemprop="position" content="<?php echo $i + 1; ?>">
			</li>
			<?php } ?>
		</ol>
	</div>
</nav>
<?php } ?>
