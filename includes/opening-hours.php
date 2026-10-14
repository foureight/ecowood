<?php
require_once __DIR__ . '/seo-config.php';

$hours = seo_opening_hours();
$today_hours = $hours[(int) date('N')] ?? null;
$now = date('H:i');

$is_open = $today_hours !== null && $now >= $today_hours[0] && $now < $today_hours[1];

// Rozvrh se vypisuje jen na širších displejích, na mobilu by zabral moc místa
if (seo_is_winter_season()) {
	$schedule = 'Kompostárna je otevřena ve středu 8:00–16:00 hod.';
} else {
	$schedule = 'Kompostárna je otevřena v Po–Pá 8:00–16:00 hod a v sobotu 8:00–11:30 hod.';
}

// Upozornění na svátek se ukáže týden dopředu
$holiday = seo_upcoming_holiday(7);
$holiday_note = '';
if ($holiday !== null) {
	$days = ['1' => 'v pondělí', '2' => 'v úterý', '3' => 've středu', '4' => 've čtvrtek',
		'5' => 'v pátek', '6' => 'v sobotu', '7' => 'v neděli'];
	$date = date('j. n.', $holiday['date']);

	if ($holiday['days'] === 0) {
		$holiday_note = 'Dnes je státní svátek, máme zavřeno.';
	} elseif ($holiday['days'] === 1) {
		$holiday_note = 'Zítra ' . $date . ' je státní svátek, máme zavřeno.';
	} else {
		$holiday_note = 'Pozor: ' . $days[date('N', $holiday['date'])] . ' ' . $date
			. ' je státní svátek, máme zavřeno.';
	}
}
?>
<?php /* data-nosnippet brání Googlu použít provozní hlášku jako popisek
         stránky ve výsledcích vyhledávání */ ?>
<div class="hours-bar" id="hours-bar" role="status" data-nosnippet>
	<div class="container-fluid hours-bar-in">
		<p class="hours-bar-text">
			<span class="hours-bar-schedule"><?php echo htmlspecialchars($schedule); ?></span>
			Teď je<span class="hours-bar-brand"> kompostárna ECOWOOD</span>
			<span class="hours-bar-status<?php echo $is_open ? ' is-open' : ''; ?>"><?php echo $is_open ? 'otevřená' : 'zavřená'; ?></span>
			<?php if ($holiday_note !== '') { ?>
			<span class="hours-bar-holiday"><?php echo htmlspecialchars($holiday_note); ?></span>
			<?php } ?>
		</p>
		<button type="button" class="hours-bar-close" id="hours-bar-close" title="Zavřít" aria-label="Zavřít pruh s otevírací dobou">
			<span aria-hidden="true"></span>
		</button>
	</div>
</div>
