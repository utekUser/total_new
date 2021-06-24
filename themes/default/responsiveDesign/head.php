<?php /*
echo $this->headTitle();
echo $this->headDescription();
echo $this->headKeywords(); */ ?>
<title>Официальный дистрибьютор TOTAL Lubricants, MANN-HUMMEL - Томавтотрейд</title>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<meta charset="utf-8">
<meta name="robots" content="index,follow" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="application-name" content="Томавтотрейд" />
<meta name="description" content="Большой ассортимент автомобильных масел и смазок, фильтров и автозапчастей, известных марок в интернет-магазине Томавтотрейд по отличным ценам. Гарантия. Доставка.">
<meta property="og:image" content="/themes/default/responsiveDesign/images/logo.png" />
<meta name='yandex-verification' content='60045f3dff84f9a9' />

<script src='https://www.google.com/recaptcha/api.js'></script>

<link rel="stylesheet/less" type="text/css" href="/themes/default/responsiveDesign/css/main.less?<?php echo filemtime(SITE_ROOT . "/themes/default/responsiveDesign/css/main.less"); ?>" />
<link rel="stylesheet" href="/themes/default/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/themes/default/bootstrap/css/bootstrap-responsive.min.css" />
<?php if (Engine_Auth::getAuth()) : ?>
	<link href="/application/themes/admin/css/admin-bar.css" rel="stylesheet" type="text/css" media="all" />
<?php endif; ?>

<script type="text/javascript" src="/themes/default/responsiveDesign/js/jquery-3.3.1.min.js"></script>
<script src="/themes/default/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/themes/default/responsiveDesign/js/jquery-migrate-1.4.1.min.js"></script>
<script type="text/javascript" src="/themes/default/responsiveDesign/js/jquery.cookie.js" ></script> 
<script type="text/javascript" src="/themes/default/responsiveDesign/js/main.js?<?php echo filemtime(SITE_ROOT . "/themes/default/responsiveDesign/js/main.js"); ?>"></script>
<script type="text/javascript" src="/themes/default/responsiveDesign/js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="/themes/default/responsiveDesign/js/inputmask.js"></script>
<script type="text/javascript" src="/themes/default/responsiveDesign/js/less.min.js"></script>
<script type="text/javascript" src="/themes/default/js/jquery.arcticmodal-0.3.min.js"></script>

<script type="text/javascript" src="/themes/default/js/jquery.colorbox-min.js"></script>
<link href="/themes/default/css/colorbox.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="/themes/default/responsiveDesign/widgets/owl/assets/owl.carousel.min.css">
<link rel="stylesheet" href="/themes/default/responsiveDesign/widgets/owl/assets/owl.theme.default.css">
<script src="/themes/default/responsiveDesign/widgets/owl/owl.carousel.js"></script>

<?php /* <link rel="stylesheet/less" type="text/css" href="/themes/default/responsiveDesign/css/main.less?<?php echo filemtime(SITE_ROOT . "/themes/default/responsiveDesign/css/main.less"); ?>" /> */ ?>
<?php /*

<link rel="stylesheet" type="text/css" media="all" href="/themes/default/css/styles.css"  />
<link rel="stylesheet" type="text/css" media="all" href="/themes/default/css/newdesign2015.css"  />
<script type="text/javascript" src="/externals/jquery/jquery.js"></script>
<script type="text/javascript" src="/externals/scrollto/jquery.scrollTo-1.4.2-min.js"></script>



<script type="text/javascript" src="/themes/default/js/common.js?v=2014102002"></script>

<script type="text/javascript" src="/externals/slimbox/js/slimbox2.js"></script>
<link rel="stylesheet" type="text/css" href="/externals/slimbox/css/slimbox2.css" />
<script type="text/javascript">
	$(function () {
		$('a.gallery').slimbox();
	});
</script>
<script type="text/javascript" src="/themes/default/js/jquery.colorbox-min.js"></script>
<link href="/themes/default/css/colorbox.css" rel="stylesheet" type="text/css">
<script>
	function hideAlert() {
		$("#dim").fadeOut();
		return false;
	}

	function showAlert(callback, timeout) {
		$("#dim").fadeIn("fast", function () {
			if (typeof callback == "function")
				setTimeout(callback, parseInt(timeout) > 0 ? timeout : 5000); //По умолчанию скрываем через 5 сек.
		});
		return false;
	}

	$(document).ready(function () {
		$(".inlineCallmeForm").colorbox({inline: true, width: "460px"});
<?php if (isset($_GET['callme'])) { ?>
			showAlert(hideAlert, 3000);
<?php } ?>
	});
</script>

<script type="text/javascript" src="/externals/jcarousel/jquery.jcarousel.min.js"></script>
<link rel="stylesheet" type="text/css" href="/externals/jcarousel/jcarouselskin.css" />
<script type="text/javascript">
	function mycarousel_initCallback(carousel) {
		jQuery('.jcarousel-control a').bind('click', function () {
			carousel.scroll(jQuery.jcarousel.intval(jQuery(this).text()));
			return false;
		});
	}
	function mycarouselDesign_initCallback(carousel) {
		jQuery('.jcarousel-control a').bind('click', function () {
			carousel.scroll(jQuery.jcarousel.intval(jQuery(this).text()));
			return false;
		});
	}
	jQuery(document).ready(function () {
		jQuery("#mycarousel").jcarousel({
			scroll: 1,
			wrap: 'circular',
			auto: 7,
			initCallback: mycarousel_initCallback,
			itemVisibleInCallback: {
				onAfterAnimation: function (c, o, i, s) {
					var size = c.options.size;
					i = (((i - 1) % size) + size) % size;
					jQuery('.jcarousel-control a').removeClass('control-active');
					jQuery('.jcarousel-control a:eq(' + i + ')').addClass('control-active');
				}
			}
		});
		jQuery("#mycarouselDesign").jcarousel({
			scroll: 1,
			wrap: 'circular',
			auto: 7,
			initCallback: mycarouselDesign_initCallback,
			itemVisibleInCallback: {
				onAfterAnimation: function (c, o, i, s) {
					var size = c.options.size;
					i = (((i - 1) % size) + size) % size;
					jQuery('.jcarousel-control a').removeClass('control-active');
					jQuery('.jcarousel-control a:eq(' + i + ')').addClass('control-active');
				}
			}
		});
	});
</script>

<!-- Всплывающее окно -->
<script type="text/javascript" src="/themes/default/js/jquery.arcticmodal-0.3.min.js" ></script>
<link type="text/css" rel="stylesheet" href="/themes/default/css/jquery.arcticmodal-0.3.css"/>


*/ ?>