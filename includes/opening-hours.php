<?php
require_once __DIR__ . '/seo-config.php';

$is_open = seo_is_open_now();
$schedule = seo_hours_bar_schedule();
$status_word = $is_open ? 'otevřená' : 'zavřená';
$status_word_short = $is_open ? 'otevřeno' : 'zavřeno';

// Upozornění na svátek se ukáže týden dopředu
$holiday = seo_upcoming_holiday(7);
$holiday_note = '';
if ($holiday !== null) {
	$days = ['1' => 'v pondělí', '2' => 'v úterý', '3' => 've středu', '4' => 've čtvrtek',
		'5' => 'v pátek', '6' => 'v sobotu', '7' => 'v neděli'];
	$date = date('j. n.', $holiday['date']);

	if ($holiday['days'] === 0) {
		$holiday_note = 'Dnes je státní svátek, máme zavřeno.';
		$is_open = false;
		$status_word = 'zavřená';
		$status_word_short = 'zavřeno';
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
			<span class="hours-bar-now">
				<span class="hours-bar-label hours-bar-label--desktop" aria-hidden="true">Teď je</span>
				<span class="hours-bar-label hours-bar-label--mobile" aria-hidden="true">Dnes</span>
				<span class="hours-bar-brand"> kompostárna <b>ECOWOOD</b></span>
				<span class="hours-bar-status<?php echo $is_open ? ' is-open' : ''; ?>">
					<span class="hours-bar-status-word hours-bar-status-word--desktop"><?php echo $status_word; ?></span>
					<span class="hours-bar-status-word hours-bar-status-word--mobile"><?php echo $status_word_short; ?></span>
				</span>
			</span>
			<?php if ($holiday_note !== '') { ?>
			<span class="hours-bar-holiday"><?php echo htmlspecialchars($holiday_note); ?></span>
			<?php } ?>
		</p>
		<button type="button" class="hours-bar-close" id="hours-bar-close" title="Zavřít" aria-label="Zavřít pruh s otevírací dobou">
			<span aria-hidden="true"></span>
		</button>
	</div>
</div>
