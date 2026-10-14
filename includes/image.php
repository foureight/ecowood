<?php
/**
 * Vykreslí obrázek ve WebP se dvěma velikostmi.
 *
 * WebP podporují všechny dnes používané prohlížeče, proto se servíruje
 * přímo a JPG zůstává jen jako zdrojový soubor v repozitáři.
 *
 * Rozměry se čtou ze souboru, takže si prohlížeč rezervuje místo
 * a obsah při načítání neposkakuje (CLS).
 *
 * @param string $jpg   cesta ke zdrojovému JPG, např. 'images/hero.jpg'
 * @param string $alt   popis obrázku
 * @param array  $opts  class, lazy, sizes
 */
function ew_picture($jpg, $alt, array $opts = [])
{
    $root = __DIR__ . '/../';
    if (!file_exists($root . $jpg)) {
        return;
    }

    [$width, $height] = getimagesize($root . $jpg);
    $base = preg_replace('/\.jpe?g$/i', '', $jpg);
    $webp = $base . '.webp';
    $small = $base . '-900.webp';

    $lazy = $opts['lazy'] ?? true;
    $sizes = $opts['sizes'] ?? null;

    // WebP se použije, pokud existuje; jinak zůstane původní soubor
    $src = file_exists($root . $webp) ? $webp : $jpg;

    $srcset = [];
    if (file_exists($root . $small)) {
        $srcset[] = $small . ' 900w';
    }
    $srcset[] = $src . ' ' . $width . 'w';

    $attrs = [
        'src="' . htmlspecialchars($src) . '"',
        'srcset="' . htmlspecialchars(implode(', ', $srcset)) . '"',
        'alt="' . htmlspecialchars($alt) . '"',
        'width="' . $width . '"',
        'height="' . $height . '"',
    ];
    if ($sizes) {
        $attrs[] = 'sizes="' . htmlspecialchars($sizes) . '"';
    }
    if (!empty($opts['class'])) {
        $attrs[] = 'class="' . htmlspecialchars($opts['class']) . '"';
    }
    if ($lazy) {
        $attrs[] = 'loading="lazy"';
        $attrs[] = 'decoding="async"';
    } else {
        $attrs[] = 'fetchpriority="high"';
    }

    echo '<img ' . implode(' ', $attrs) . '>';
}
