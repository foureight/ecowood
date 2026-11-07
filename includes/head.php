<!DOCTYPE html>
<html lang="cs">
<head>
	<meta charset="UTF-8">
	<?php
	require_once __DIR__ . '/seo-config.php';

	$seo_title = $page_title ?? SEO_SITE_NAME;
	$seo_description = $page_description ?? 'Kompostárna ECOWOOD Unhošť — kompost, zahradnické substráty a zeminy z vlastní výroby, příjem bioodpadu, pronájem kontejnerů a údržba zeleně. Kladno, Praha a Středočeský kraj.';
	$seo_keywords = $page_keywords ?? 'kompostárna Unhošť, kompost Kladno, zahradní zemina, substráty, uložení bioodpadu, pronájem kontejneru, ECOWOOD, humus, svoz odpadu, údržba zeleně, Praha-západ';
	$seo_url = seo_page_url();
	$seo_image = $page_og_image ?? SEO_DEFAULT_OG_IMAGE;
	$seo_robots = $page_robots ?? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
	?>
	<title><?php echo htmlspecialchars($seo_title); ?></title>
	<meta name="description" content="<?php echo htmlspecialchars($seo_description); ?>">
	<meta name="keywords" content="<?php echo htmlspecialchars($seo_keywords); ?>">
	<meta name="robots" content="<?php echo htmlspecialchars($seo_robots); ?>">
	<meta name="author" content="ECOWOOD s.r.o.">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,shrink-to-fit=no">
	<meta name="theme-color" content="#01be4a">
	<meta name="format-detection" content="telephone=yes">

	<link rel="icon" href="/favicon.ico" sizes="any">
	<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32.png">
	<link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
	<link rel="manifest" href="/site.webmanifest">

	<link rel="canonical" href="<?php echo htmlspecialchars($seo_url); ?>">
	<link rel="alternate" hreflang="cs-CZ" href="<?php echo htmlspecialchars($seo_url); ?>">
	<link rel="alternate" hreflang="x-default" href="<?php echo htmlspecialchars($seo_url); ?>">
	<link rel="sitemap" type="application/xml" title="Sitemap" href="<?php echo SEO_SITE_URL; ?>/sitemap.xml">

	<meta name="geo.region" content="CZ-ST">
	<meta name="geo.placename" content="<?php echo SEO_LOCALITY; ?>, <?php echo SEO_REGION; ?>">
	<meta name="geo.position" content="<?php echo SEO_LAT; ?>;<?php echo SEO_LNG; ?>">
	<meta name="ICBM" content="<?php echo SEO_LAT; ?>, <?php echo SEO_LNG; ?>">

	<meta property="og:type" content="website">
	<meta property="og:locale" content="cs_CZ">
	<meta property="og:site_name" content="<?php echo SEO_SITE_NAME; ?>">
	<meta property="og:title" content="<?php echo htmlspecialchars($seo_title); ?>">
	<meta property="og:description" content="<?php echo htmlspecialchars($seo_description); ?>">
	<meta property="og:url" content="<?php echo htmlspecialchars($seo_url); ?>">
	<meta property="og:image" content="<?php echo htmlspecialchars($seo_image); ?>">
	<meta property="og:image:alt" content="<?php echo htmlspecialchars($page_og_image_alt ?? SEO_SITE_NAME . ' — ' . SEO_LOCALITY); ?>">
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="630">

	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?php echo htmlspecialchars($seo_title); ?>">
	<meta name="twitter:description" content="<?php echo htmlspecialchars($seo_description); ?>">
	<meta name="twitter:image" content="<?php echo htmlspecialchars($seo_image); ?>">

	<?php if (($current_page ?? '') === 'index') { ?>
	<link rel="preload" as="image" href="images/hero.webp" imagesrcset="images/hero-900.webp 900w, images/hero.webp 1820w" imagesizes="100vw">
	<?php } ?>

	<link rel="preconnect" href="https://use.typekit.net" crossorigin>
	<link rel="preconnect" href="https://p.typekit.net" crossorigin>
	<link rel="dns-prefetch" href="https://use.typekit.net">

	<link rel="stylesheet" href="https://use.typekit.net/mde4qbr.css">
	<link href="css/style.min.css?v=07062020" rel="stylesheet" media="all" type="text/css">
	<link href="css/pages.css?v=6" rel="stylesheet" media="all" type="text/css">
	<link href="css/theme.css?v=62" rel="stylesheet" media="all" type="text/css">

	<?php
	$schemas = [
		seo_local_business_schema(),
		seo_organization_schema(),
		seo_website_schema(),
		seo_webpage_schema($seo_title, $seo_description, $seo_url),
	];
	if (!empty($breadcrumbs)) {
		$schemas[] = seo_breadcrumb_schema($breadcrumbs);
	}
	if (!empty($page_faq_tags)) {
		$faq_for_schema = seo_get_faq_items($page_faq_tags);
		if (!empty($faq_for_schema)) {
			$schemas[] = seo_faq_schema($faq_for_schema);
		}
	}
	$service_schemas = seo_service_schemas();
	if (!empty($service_schemas)) {
		$schemas[] = $service_schemas;
	}
	// Produkty s cenami jen na stránce ceníku
	if (!empty($page_products)) {
		$product_schemas = seo_product_schemas();
		if (!empty($product_schemas)) {
			$schemas[] = $product_schemas;
		}
	}
	seo_json_ld($schemas);
	?>
</head>
<body>
