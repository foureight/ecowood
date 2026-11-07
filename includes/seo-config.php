<?php

// Server může běžet v UTC. Bez tohoto by pruh s otevírací dobou počítal
// s posunem a dvě hodiny po otevření by ještě hlásil zavřeno.
date_default_timezone_set('Europe/Prague');

define('SEO_SITE_NAME', 'Kompostárna ECOWOOD');
define('SEO_SITE_URL', 'https://www.ecowood.cz');
define('SEO_DEFAULT_OG_IMAGE', SEO_SITE_URL . '/images/hero.jpg');
define('SEO_LOCALITY', 'Unhošť');
define('SEO_REGION', 'Středočeský kraj');
define('SEO_POSTAL_CODE', '273 51');
define('SEO_COUNTRY', 'CZ');
define('SEO_LAT', 50.0896194);
define('SEO_LNG', 14.1561972);
define('SEO_PHONE', '+420602525903');
define('SEO_EMAIL', 'ecowood@ecowood.cz');

/**
 * Otevírací doba kompostárny:
 *
 *   Pondělí–pátek  8:00–16:00   mimo zimní provoz (březen–listopad)
 *   Sobota         8:00–11:30   1. 4.–31. 10.; 1. 11.–31. 3. zavřeno
 *   Středa         8:00–16:00   1. 12.–28. 2. (zimní provoz)
 *
 * Klíč je den podle date('N') (1 = pondělí), hodnota [otevřeno, zavřeno]
 * nebo null, když je zavřeno.
 */
define('SEO_LAST_LOADING_NOTE', 'Poslední nakládka 15 minut před koncem otevírací doby.');

// Celoroční rozvrh pro informační tabuli — popis období a jeho doba
function seo_opening_hours_seasons()
{
    return [
        ['dny' => 'Pondělí–pátek', 'doba' => '8:00–16:00', 'obdobi' => '1. 3.–30. 11.'],
        ['dny' => 'Sobota', 'doba' => '8:00–11:30', 'obdobi' => '1. 4.–31. 10.'],
        ['dny' => 'Středa', 'doba' => '8:00–16:00', 'obdobi' => '1. 12.–28. 2. (zimní provoz)'],
    ];
}

/**
 * Státní svátky a ostatní dny pracovního klidu v Česku.
 *
 * Velikonoce se každý rok posouvají, proto se datum počítá. Pokud se
 * v některý z těchto dnů pracuje, stačí řádek smazat.
 *
 * @return array<string,string> klíč 'm-d' => název svátku
 */
function seo_holidays($year)
{
    // Velikonoční neděle podle Gaussova algoritmu, bez rozšíření calendar
    $a = $year % 19;
    $b = intdiv($year, 100);
    $c = $year % 100;
    $d = intdiv($b, 4);
    $e = $b % 4;
    $f = intdiv($b + 8, 25);
    $g = intdiv($b - $f + 1, 3);
    $h = (19 * $a + $b - $d - $g + 15) % 30;
    $i = intdiv($c, 4);
    $k = $c % 4;
    $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
    $m = intdiv($a + 11 * $h + 22 * $l, 451);
    $month = intdiv($h + $l - 7 * $m + 114, 31);
    $day = (($h + $l - 7 * $m + 114) % 31) + 1;
    $easter = mktime(12, 0, 0, $month, $day, $year);

    $holidays = [
        '01-01' => 'Nový rok',
        '05-01' => 'Svátek práce',
        '05-08' => 'Den vítězství',
        '07-05' => 'Den slovanských věrozvěstů Cyrila a Metoděje',
        '07-06' => 'Den upálení mistra Jana Husa',
        '09-28' => 'Den české státnosti',
        '10-28' => 'Den vzniku samostatného československého státu',
        '11-17' => 'Den boje za svobodu a demokracii',
        '12-24' => 'Štědrý den',
        '12-25' => '1. svátek vánoční',
        '12-26' => '2. svátek vánoční',
    ];

    $holidays[date('m-d', strtotime('-2 days', $easter))] = 'Velký pátek';
    $holidays[date('m-d', strtotime('+1 day', $easter))] = 'Velikonoční pondělí';

    return $holidays;
}

// Název svátku, pokud na dané datum připadá, jinak null
function seo_holiday_name($date = null)
{
    $date = $date ?? time();
    return seo_holidays((int) date('Y', $date))[date('m-d', $date)] ?? null;
}

/**
 * Nejbližší svátek v následujících dnech včetně dneška.
 *
 * @return array{name: string, date: int, days: int}|null
 */
function seo_upcoming_holiday($within_days = 7, $date = null)
{
    $today = strtotime('today', $date ?? time());

    for ($offset = 0; $offset <= $within_days; $offset++) {
        $day = strtotime("+$offset days", $today);
        $name = seo_holiday_name($day);
        if ($name !== null) {
            return ['name' => $name, 'date' => $day, 'days' => $offset];
        }
    }
    return null;
}

function seo_is_winter_season($date = null)
{
    $ts = $date ?? time();
    $md = date('m-d', $ts);

    // 1. 12. – 28. 2. (včetně celého února, tedy i 29. 2. v přestupném roce)
    if ($md >= '12-01') {
        return true;
    }
    $month = (int) date('n', $ts);

    return $month === 1 || $month === 2;
}

function seo_has_saturday_season($date = null)
{
    $md = date('m-d', $date ?? time());

    // Sobota jen 1. 4. – 31. 10.; od 1. 11. do 31. 3. zavřeno
    return $md >= '04-01' && $md <= '10-31';
}

function seo_opening_hours($date = null)
{
    $hours = [1 => null, 2 => null, 3 => null, 4 => null, 5 => null, 6 => null, 7 => null];

    // Ve státní svátek se nepracuje
    if (seo_holiday_name($date) !== null) {
        return $hours;
    }

    if (seo_is_winter_season($date)) {
        $hours[3] = ['08:00', '16:00'];
        return $hours;
    }

    for ($day = 1; $day <= 5; $day++) {
        $hours[$day] = ['08:00', '16:00'];
    }
    if (seo_has_saturday_season($date)) {
        $hours[6] = ['08:00', '11:30'];
    }

    return $hours;
}

/** Čas „H:i“ na minuty od půlnoci — spolehlivější než porovnávání řetězců. */
function seo_time_to_minutes($hhmm)
{
    $parts = explode(':', $hhmm, 2);
    return ((int) ($parts[0] ?? 0)) * 60 + ((int) ($parts[1] ?? 0));
}

/** Je kompostárna právě otevřená? (Prague, dle seo_opening_hours.) */
function seo_is_open_now($timestamp = null)
{
    $ts = $timestamp ?? time();
    $hours = seo_opening_hours($ts);
    $day = (int) date('N', $ts);
    $range = $hours[$day] ?? null;
    if ($range === null) {
        return false;
    }
    $now = seo_time_to_minutes(date('H:i', $ts));
    $from = seo_time_to_minutes($range[0]);
    $to = seo_time_to_minutes($range[1]);

    return $now >= $from && $now < $to;
}

/** Text rozvrhu do hnědého pruhu — odpovídá pravidlům pro dané období. */
function seo_hours_bar_schedule($timestamp = null)
{
    $ts = $timestamp ?? time();
    if (seo_is_winter_season($ts)) {
        return 'Zimní provoz 1. 12.–28. 2.: kompostárna je otevřena ve středu 8:00–16:00 hod.';
    }
    $line = 'Kompostárna je otevřena v Po–Pá 8:00–16:00 hod';
    if (seo_has_saturday_season($ts)) {
        return $line . ' a v sobotu 8:00–11:30 hod.';
    }

    return $line . ' (sobota 1. 11.–31. 3. zavřeno).';
}

// 'kompost.php' → '/kompost', 'index.php' → '/'
function seo_clean_path($path)
{
    $path = ltrim($path, '/');
    if ($path === '' || $path === 'index.php' || $path === 'index') {
        return '/';
    }
    return '/' . preg_replace('/\.php$/', '', $path);
}

function seo_canonical_url($path = '')
{
    $path = ltrim($path, '/');
    if ($path === '' || $path === 'index.php' || $path === 'index') {
        return SEO_SITE_URL . '/';
    }
    // Adresy se zobrazují bez přípony .php
    return SEO_SITE_URL . '/' . preg_replace('/\.php$/', '', $path);
}

function seo_page_url()
{
    global $page_canonical;
    if (!empty($page_canonical)) {
        return $page_canonical;
    }
    $script = basename($_SERVER['PHP_SELF'] ?? 'index.php');
    return seo_canonical_url($script);
}

function seo_get_faq_items($tags = [])
{
    static $all = null;
    if ($all === null) {
        $path = __DIR__ . '/../data/faq.json';
        $all = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
    }
    if (empty($tags)) {
        return $all;
    }
    return array_values(array_filter($all, function ($item) use ($tags) {
        foreach ($tags as $tag) {
            if (in_array($tag, $item['tags'] ?? [], true)) {
                return true;
            }
        }
        return false;
    }));
}

function seo_schema_node($type, $data)
{
    return array_merge(['@type' => $type], $data);
}

// Otevírací doba pro schema.org, odvozená ze seo_opening_hours()
function seo_opening_hours_schema()
{
    $days = [1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday'];

    // Dny se stejnou dobou sloučit do jednoho záznamu
    $groups = [];
    foreach (seo_opening_hours() as $day => $range) {
        if ($range === null) {
            continue;
        }
        $groups[$range[0] . '-' . $range[1]][] = $days[$day];
    }

    $spec = [];
    foreach ($groups as $range => $day_names) {
        [$opens, $closes] = explode('-', $range);
        $spec[] = seo_schema_node('OpeningHoursSpecification', [
            'dayOfWeek' => $day_names,
            'opens' => $opens,
            'closes' => $closes,
        ]);
    }
    return $spec;
}

function seo_cenik()
{
    static $data = null;
    if ($data === null) {
        $path = __DIR__ . '/../data/cenik.json';
        $data = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
    }
    return $data;
}

// Cenu z ceníku ("1 080 Kč / t") rozložit na částku a jednotku pro schema.org
function seo_parse_price($text)
{
    if (!preg_match('/^([\d\s\x{00A0}]+)\s*Kč\s*\/\s*(.+)$/u', trim($text), $m)) {
        return null;
    }
    $units = ['t' => 'TNE', 'm³' => 'MTQ', 'kus' => 'C62', 'ks' => 'C62', 'km' => 'KMT', 'den' => 'DAY', 'hod' => 'HUR'];
    $unit = trim($m[2]);

    return [
        'price' => (int) preg_replace('/\D/', '', $m[1]),
        'unitText' => $unit,
        'unitCode' => $units[$unit] ?? null,
    ];
}

/**
 * Produkty z ceníku jako samostatné uzly Product.
 *
 * Cena musí být v `offers` přímo na produktu — Google jinak hlásí, že
 * u produktu chybí offers, review nebo aggregateRating. Dřív visela na
 * nadřazeném Offer, což nestačí.
 *
 * Uvádí se jen na stránce s ceníkem, aby se produkty neopakovaly na
 * každé stránce webu.
 */
function seo_product_schemas()
{
    $cenik = seo_cenik();
    if (empty($cenik['sekce'])) {
        return [];
    }

    $currency = $cenik['mena'] ?? 'CZK';
    $url = SEO_SITE_URL . '/cenik#produkty';
    $products = [];

    foreach ($cenik['sekce'] as $sekce) {
        if ($sekce['id'] !== 'produkty') {
            continue;
        }
        foreach ($sekce['radky'] as $radek) {
            [$code, $name, $usage, $price_text] = $radek;
            $price = seo_parse_price($price_text);
            if ($price === null) {
                continue;
            }

            $offer = [
                'price' => $price['price'],
                'priceCurrency' => $currency,
                'availability' => 'https://schema.org/InStock',
                'itemCondition' => 'https://schema.org/NewCondition',
                'url' => $url,
                'seller' => ['@id' => SEO_SITE_URL . '/#localbusiness'],
                'priceSpecification' => seo_schema_node('UnitPriceSpecification', array_filter([
                    'price' => $price['price'],
                    'priceCurrency' => $currency,
                    'valueAddedTaxIncluded' => false,
                    'unitText' => $price['unitText'],
                    'unitCode' => $price['unitCode'],
                ], fn($v) => $v !== null)),
            ];

            // Fotku uvádět jen tam, kde produkt opravdu zachycuje;
            // u písku nebo PRAuhlu by snímek kompostu mátl.
            $images = [
                'KE024' => 'hero1.jpg',
                'TD024' => 'ilustrace1.jpg',
                'SK024' => 'ilustrace1.jpg',
                'ST024' => 'ilustrace1.jpg',
                'SZ024' => 'ilustrace2.jpg',
            ];

            $products[] = seo_schema_node('Product', array_filter([
                '@id' => SEO_SITE_URL . '/cenik#' . $code,
                'name' => $name,
                'sku' => $code,
                'category' => $usage,
                'image' => isset($images[$code]) ? SEO_SITE_URL . '/images/' . $images[$code] : null,
                'brand' => seo_schema_node('Brand', ['name' => 'ECOWOOD']),
                'offers' => seo_schema_node('Offer', $offer),
            ], fn($v) => $v !== null));
        }
    }

    return $products;
}

function seo_local_business_schema()
{
    // RecyclingCenter je podtyp LocalBusiness a pro kompostárnu vystihuje obor přesněji
    return seo_schema_node('RecyclingCenter', [
        '@id' => SEO_SITE_URL . '/#localbusiness',
        'name' => SEO_SITE_NAME,
        'alternateName' => ['ECOWOOD s.r.o.', 'Kompostárna Unhošť'],
        'legalName' => 'ECOWOOD s.r.o.',
        'description' => 'Kompostárna v Unhošti u Kladna. Kompostování biologicky rozložitelného odpadu, výroba kompostu, substrátů a zemin, svoz bioodpadu, pronájem kontejnerů a údržba zeleně.',
        'url' => SEO_SITE_URL . '/',
        'logo' => SEO_SITE_URL . '/images/logo.svg',
        'image' => [
            SEO_SITE_URL . '/images/hero.jpg',
            SEO_SITE_URL . '/images/hero1.jpg',
        ],
        'telephone' => SEO_PHONE,
        'email' => SEO_EMAIL,
        'priceRange' => '$$',
        'identifier' => seo_schema_node('PropertyValue', [
            'propertyID' => 'IČO',
            'value' => '27900797',
        ]),
        'contactPoint' => [
            seo_schema_node('ContactPoint', [
                'contactType' => 'sales',
                'name' => 'Maloobchodní prodej — Aleš Kohout',
                'telephone' => '+420602611593',
                'email' => SEO_EMAIL,
                'availableLanguage' => 'cs',
                'areaServed' => 'CZ',
            ]),
            seo_schema_node('ContactPoint', [
                'contactType' => 'sales',
                'name' => 'Velkoobchodní prodej — Marek Chmelík',
                'telephone' => '+420602525903',
                'availableLanguage' => 'cs',
                'areaServed' => 'CZ',
            ]),
            seo_schema_node('ContactPoint', [
                'contactType' => 'customer service',
                'name' => 'Vedení kompostárny — Ing. Miloslav Malý',
                'telephone' => '+420777737756',
                'availableLanguage' => 'cs',
                'areaServed' => 'CZ',
            ]),
        ],
        'address' => seo_schema_node('PostalAddress', [
            'streetAddress' => 'Unhošt p.p.č. 442/2',
            'addressLocality' => SEO_LOCALITY,
            'addressRegion' => SEO_REGION,
            'postalCode' => SEO_POSTAL_CODE,
            'addressCountry' => SEO_COUNTRY,
        ]),
        'geo' => seo_schema_node('GeoCoordinates', [
            'latitude' => SEO_LAT,
            'longitude' => SEO_LNG,
        ]),
        'hasMap' => 'https://goo.gl/maps/CStPXoByYE3w289X9',
        'openingHoursSpecification' => seo_opening_hours_schema(),
        'paymentAccepted' => 'Hotovost',
        'currenciesAccepted' => 'CZK',
        'areaServed' => [
            seo_schema_node('City', ['name' => 'Unhošť']),
            seo_schema_node('City', ['name' => 'Kladno']),
            seo_schema_node('City', ['name' => 'Praha']),
            seo_schema_node('City', ['name' => 'Hostivice']),
            seo_schema_node('City', ['name' => 'Chýně']),
            seo_schema_node('City', ['name' => 'Jeneč']),
            seo_schema_node('City', ['name' => 'Rudná']),
            seo_schema_node('AdministrativeArea', ['name' => 'okres Kladno']),
            seo_schema_node('AdministrativeArea', ['name' => 'Praha-západ']),
            seo_schema_node('AdministrativeArea', ['name' => 'Středočeský kraj']),
        ],
        'knowsAbout' => [
            'kompostování',
            'kompost',
            'humus',
            'zahradnické substráty',
            'zahradní zemina',
            'biologicky rozložitelný odpad',
            'uložení bioodpadu',
            'pronájem kontejnerů',
            'údržba zeleně',
            'svoz odpadu',
        ],
        'sameAs' => [
            'https://www.facebook.com/kompostarna',
            'https://www.instagram.com/kompostarna_ecowood/',
        ],
    ]);
}

// Samostatný záznam o firmě — signál důvěryhodnosti (E-E-A-T) pro Google i AI
function seo_organization_schema()
{
    return seo_schema_node('Organization', [
        '@id' => SEO_SITE_URL . '/#organization',
        'name' => 'ECOWOOD s.r.o.',
        'legalName' => 'ECOWOOD s.r.o.',
        'url' => SEO_SITE_URL . '/',
        'logo' => seo_schema_node('ImageObject', [
            'url' => SEO_SITE_URL . '/images/icon-512.png',
            'width' => 512,
            'height' => 512,
        ]),
        'email' => SEO_EMAIL,
        'telephone' => SEO_PHONE,
        'vatID' => 'CZ27900797',
        'taxID' => '27900797',
        'identifier' => seo_schema_node('PropertyValue', [
            'propertyID' => 'IČO',
            'value' => '27900797',
        ]),
        'address' => seo_schema_node('PostalAddress', [
            'streetAddress' => 'Ječná 550/1',
            'addressLocality' => 'Praha 2',
            'postalCode' => '120 00',
            'addressCountry' => SEO_COUNTRY,
        ]),
        'description' => 'Provozovatel kompostárny ECOWOOD v Unhošti. Zapsáno u Městského soudu v Praze, oddíl C, vložka 125227.',
        'owns' => ['@id' => SEO_SITE_URL . '/#localbusiness'],
        'sameAs' => [
            'https://www.facebook.com/kompostarna',
            'https://www.instagram.com/kompostarna_ecowood/',
        ],
    ]);
}

function seo_website_schema()
{
    return seo_schema_node('WebSite', [
        '@id' => SEO_SITE_URL . '/#website',
        'url' => SEO_SITE_URL . '/',
        'name' => SEO_SITE_NAME,
        'inLanguage' => 'cs-CZ',
        'publisher' => ['@id' => SEO_SITE_URL . '/#organization'],
    ]);
}

function seo_webpage_schema($title, $description, $url)
{
    return seo_schema_node('WebPage', [
        '@id' => $url . '#webpage',
        'url' => $url,
        'name' => $title,
        'description' => $description,
        'inLanguage' => 'cs-CZ',
        'isPartOf' => ['@id' => SEO_SITE_URL . '/#website'],
        'about' => ['@id' => SEO_SITE_URL . '/#localbusiness'],
    ]);
}

function seo_breadcrumb_schema($items)
{
    $list = [];
    $position = 1;
    foreach ($items as $item) {
        $list[] = seo_schema_node('ListItem', [
            'position' => $position++,
            'name' => $item['name'],
            'item' => seo_canonical_url($item['url']),
        ]);
    }

    return seo_schema_node('BreadcrumbList', [
        'itemListElement' => $list,
    ]);
}

function seo_faq_schema($items)
{
    $entities = [];
    foreach ($items as $item) {
        $entities[] = seo_schema_node('Question', [
            'name' => $item['question'],
            'acceptedAnswer' => seo_schema_node('Answer', [
                'text' => $item['answer'],
            ]),
        ]);
    }

    return seo_schema_node('FAQPage', [
        'mainEntity' => $entities,
    ]);
}

function seo_service_schemas()
{
    global $page_services;
    if (empty($page_services)) {
        return [];
    }

    $schemas = [];
    foreach ($page_services as $service) {
        $schemas[] = seo_schema_node('Service', [
            'name' => $service['name'],
            'description' => $service['description'],
            'provider' => ['@id' => SEO_SITE_URL . '/#localbusiness'],
            'areaServed' => SEO_LOCALITY . ', Kladno, Praha, Středočeský kraj',
            'url' => seo_page_url(),
        ]);
    }
    return $schemas;
}

function seo_json_ld($schemas)
{
    $flat = [];
    foreach ($schemas as $schema) {
        if (isset($schema[0]) && is_array($schema[0])) {
            $flat = array_merge($flat, $schema);
        } else {
            $flat[] = $schema;
        }
    }

    // Každý typ ve vlastním bloku. Google si je spojí přes @id stejně jako
    // u @graph, ale jednodušší nástroje typ najdou i bez procházení grafu.
    foreach ($flat as $schema) {
        echo '<script type="application/ld+json">' . json_encode(
            array_merge(['@context' => 'https://schema.org'], $schema),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        ) . '</script>';
    }
}
