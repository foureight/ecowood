$(document).ready(function () {

	$('.alert .close').click(function () {
		$(this).closest('.alert').remove();
	});

	// Na mobilu má hero vyplnit zbytek obrazovky pod lištou a hlavičkou.
	// Výška obou se může měnit (zavření lišty, otočení displeje), proto se
	// dopočítává a předává do CSS.
	function nastavHorniOdsazeni() {
		var vyska = 0;
		$('#hours-bar, .header').each(function () {
			vyska += this.offsetHeight || 0;
		});
		document.documentElement.style.setProperty('--ew-top-offset', vyska + 'px');
	}

	nastavHorniOdsazeni();
	$(window).on('resize orientationchange', nastavHorniOdsazeni);

	// Pruh s otevírací dobou — po zavření zůstane skrytý po zbytek návštěvy
	var $hoursBar = $('#hours-bar');
	if ($hoursBar.length) {
		var hoursBarHidden = false;
		try {
			hoursBarHidden = window.sessionStorage.getItem('ew-hours-bar') === 'closed';
		} catch (e) {}

		if (hoursBarHidden) {
			$hoursBar.remove();
			nastavHorniOdsazeni();
		} else {
			$hoursBar.addClass('is-visible');
			$('#hours-bar-close').click(function () {
				$hoursBar.slideUp(200, function () {
					$(this).remove();
					nastavHorniOdsazeni();
				});
				try {
					window.sessionStorage.setItem('ew-hours-bar', 'closed');
				} catch (e) {}
			});
		}
	}

	$('#next-news').click(function () {
		$('.news-item').show();
		$(this).hide();
		$('#actual-news').show();
	});

	$('#actual-news').click(function () {
		$('.news-item').hide();
		$('.news-items > .news-item:nth-of-type(1), .news-items > .news-item:nth-of-type(2), .news-items > .news-item:nth-of-type(3), .news-items > .news-item:nth-of-type(4)').show();
		$(this).hide();
		$('#next-news').show();
		$('html, body').animate({
			scrollTop: $('.news').offset().top - 80
		}, 800);
	});

	$('.menu-link').click(function () {
		$('body').addClass('menu-open');
		$(this).attr('aria-expanded', true);
	});

	$('.menu-close').click(function () {
		$('body').removeClass('menu-open');
		$('.menu-link').attr('aria-expanded', false);
	});

	var mql = window.matchMedia('(max-width: 767px)');
	if (mql.addEventListener) {
		mql.addEventListener('change', presunCenik);
	} else {
		mql.addListener(presunCenik);
	}
	presunCenik(mql);

	function presunCenik(mql) {
		var $btn = $('#btn-cenik');
		var $header = $('.header .container-fluid');
		var $menu = $('#menu');
		if (!$btn.length) {
			return;
		}
		if (mql.matches) {
			if (!$btn.parent().is($menu)) {
				$btn.removeClass('btn-primary').addClass('btn-secondary').appendTo($menu);
			}
		} else if (!$btn.parent().is($header)) {
			$btn.addClass('btn-primary').removeClass('btn-secondary').appendTo($header);
		}
	}

	$('a[href*="#"]').click(function (e) {
		var href = $(this).attr('href');
		var hashIndex = href.indexOf('#');
		if (hashIndex === -1) {
			return;
		}
		var hash = href.slice(hashIndex);
		if (hash.length <= 1) {
			return;
		}
		var $target = $(hash);
		if (!$target.length) {
			return;
		}
		var path = href.slice(0, hashIndex);
		var currentPath = window.location.pathname.split('/').pop() || 'index.php';
		if (path !== '' && path !== currentPath && path.indexOf(currentPath) === -1) {
			return;
		}
		e.preventDefault();
		$('html, body').animate({
			scrollTop: $target.offset().top - 90
		}, 800);
		if ($('body').hasClass('menu-open')) {
			$('body').removeClass('menu-open');
			$('.menu-link').attr('aria-expanded', false);
		}
	});

	$('#captcha').on('input', function () {
		$(this).removeClass('invalid');
		$('.captcha-error').hide();
	});

	$('.contact-form input[type="email"][required],.contact-form input[type="text"][required],.contact-form textarea[required]').focusout(function () {
		if ($(this).val() === '' || $(this).is(':invalid')) {
			$(this).addClass('invalid');
			$(this).next('.form-error').show();
		} else {
			$(this).removeClass('invalid');
			$(this).next('.form-error').hide();
		}
	});

	$('.contact-form').submit(function (event) {
		event.preventDefault();

		$('.contact-form, .contact-form *').css('cursor', 'wait');
		$('#form_submit').prop('disabled', true).val('Odesílám...');

		var formData = {
			jmeno: $('input[name=jmeno]').val(),
			email: $('input[name=email]').val(),
			telefon: $('input[name=telefon]').val(),
			predmet: $('input[name=predmet]').val(),
			zprava: $('textarea[name=zprava]').val(),
			url: $('input[name=url]').val(),
			captcha: $('input[name=captcha]').val(),
			captcha_token: $('input[name=captcha_token]').val(),
			captcha_time: $('input[name=captcha_time]').val()
		};

		$.ajax({
			type: 'POST',
			url: 'mail_sender.php',
			data: formData,
			dataType: 'json'
		}).done(function (result) {
			$('.contact-form, .contact-form *').css('cursor', 'auto');
			$('.contact-form a').css('cursor', 'pointer');

			// Špatná kontrolní otázka — nechat formulář vyplněný a nechat uživatele opravit
			if (result.captcha === false) {
				$('#form_submit').prop('disabled', false).val('Odeslat');
				$('#captcha').addClass('invalid').val('').focus();
				$('.captcha-error').show();
				return;
			}

			$('.form').css('visibility', 'hidden');

			var el = result.status ? $('.sent-block') : $('.unsent-block');
			if (!result.status) {
				$('.your-msg').text($('textarea[name=zprava]').val());
			}
			el.show();

			if (document.documentElement.clientWidth <= 767) {
				var windowHeight = window.innerHeight;
				var elOffset = el.offset().top;
				var elHeight = el.height();
				var offset = elHeight < windowHeight
					? elOffset - ((windowHeight / 2) - (elHeight / 2))
					: elOffset;
				$('html, body').animate({ scrollTop: offset }, 800);
			}
		}).fail(function () {
			$('.contact-form, .contact-form *').css('cursor', 'auto');
			$('#form_submit').prop('disabled', false).val('Odeslat');
			$('.form').css('visibility', 'hidden');
			$('.unsent-block').show();
			$('.your-msg').text($('textarea[name=zprava]').val());
		});
	});

});
