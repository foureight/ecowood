<?php
require_once __DIR__ . '/captcha.php';
$captcha = ew_captcha_new();
?>
<form action="mail_sender.php" method="post" class="contact-form">
	<div class="form">
		<div class="cols">
			<div class="form-group">
				<input type="text" name="jmeno" id="jmeno" placeholder="Jméno" required>
				<div class="form-error">Zadejte prosím své jméno</div>
			</div>
			<div class="form-group">
				<input type="email" name="email" id="email" placeholder="E-mail" required>
				<div class="form-error">Zadejte prosím svůj e-mail</div>
			</div>
			<div class="form-group">
				<input type="text" name="telefon" id="telefon" placeholder="Telefon">
			</div>
			<div class="form-group" style="display:none;">
				<label for="url">Nevyplňujte</label>
				<input type="text" name="url" id="url">
			</div>
			<div class="form-group">
				<input type="text" name="predmet" id="predmet" placeholder="Předmět" required>
				<div class="form-error">Zadejte prosím předmět zprávy</div>
			</div>
			<div class="form-group">
				<textarea name="zprava" id="zprava" placeholder="Vaše zpráva" required></textarea>
				<div class="form-error">Napište prosím zprávu</div>
			</div>
			<div class="form-group captcha">
				<label class="captcha-label" for="captcha">
					<span class="captcha-icon" aria-hidden="true"></span>
					<span class="captcha-question">Kolik je <strong><?php echo htmlspecialchars($captcha['question']); ?></strong>?</span>
				</label>
				<input type="text" name="captcha" id="captcha" class="captcha-input" inputmode="numeric" autocomplete="off" placeholder="?" required>
				<input type="hidden" name="captcha_token" value="<?php echo htmlspecialchars($captcha['token']); ?>">
				<input type="hidden" name="captcha_time" value="<?php echo (int) $captcha['time']; ?>">
				<div class="form-error captcha-error">Odpověď nesouhlasí, zkuste to prosím znovu</div>
			</div>
		</div>
		<input type="submit" class="btn btn-primary" id="form_submit" value="Odeslat">
	</div>
	<div class="sent-block">
		<b>Děkujeme vám za odeslání zprávy.</b>
		Co nejdříve ji přečteme a brzy vám odpovíme.
	</div>
	<div class="unsent-block">
		<b>Vaši zprávu se nepodařilo odeslat</b>
		Pošlete nám prosím e-mail na <a href="mailto:ecowood@ecowood.cz">ecowood@ecowood.cz</a>.
		<div class="your-msg-wrapper">
			<div class="your-msg-head">Vaše zpráva:</div>
			<div class="your-msg"></div>
		</div>
	</div>
</form>
