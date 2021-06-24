<?php $auth1 = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User')); ?>
<div id="header">
	<div class="visible-xs-block">
		<div class="login-mobile">
			<?php if (!$auth1->hasIdentity()) : ?>
				<a href="/account/login/" title="Вход">Вход</a>
				<a href="/account/signup/" title="Регистрация">Регистрация</a>
			<?php else : ?>
				<a href="/control/"><?php if ($this->layout()->userInfo['name'] != '') echo $this->layout()->userInfo['name']; ?></a>
                <a href="/account/logout/" title="Выйти с сайта">Выйти</a>
			<?php endif; ?>
		</div>
		<div class="row-fluid top-mobile">
			<div class="col-xs-2 padding-l-0">
				<button id="show-menu-m">
					<img src="/themes/default/responsiveDesign/images/logo-menu-m.webp" />
				</button>				
				<?php include 'topMenuMobile.php'; ?>
			</div>
			<div class="col-xs-8 padding-lr-0 logo-mobile">
				<a href="/" title="Главная"><img src="/themes/default/responsiveDesign/images/logo.webp" /></a>
				<h3>Официальный дистрибьютор<br>TOTAL Lubricants, MANN-HUMMEL</h3>
			</div>
			<div class="col-xs-2">
				<a href="/control/viewbasket/">
					<img src="/themes/default/responsiveDesign/images/basket.webp" />
					<span id="in-basket-count-mobile"><?php echo $_SESSION['basketcount']; ?></span>
				</a>
			</div>
		</div>
		<div class="row-fluid contacts-mobile">
			<p><b>Оптовый отдел:</b> <a href="tel:83822266933">(3822) 266-933</a>, <a href="tel:83822266866">(3822) 266-866</a></p>
            <p><b>Розница:</b> <a href="tel:83822266687">(3822) 266-687</a></p>
		</div>
		<div class="row-fluid search-box">
			<form id="top-search-form-mobile" method="get" action="/catalog/search/">
                <div class="input-append">
                    <input type="text" value="<?php echo (isset($_GET['catalog-search-text']) ? $_GET['catalog-search-text'] : ""); ?>" name="catalog-search-text" id="catalog-search-text-mobile" class="span2 form-control search-query-ajax search-query" autocomplete="off">
                    <button type="submit" class="btn" id="catalog-search-submit-mobile"></button>
                </div>				
				<ul class="search-box search-result-ajax"></ul>				
            </form>
		</div>
		<div class="row-fluid five-blocks">
			<div class="btn-group btn-group-justified">
				<div class="btn-group border-right one-of-five">
					<div class="col-sm-12 map">
						<img src="/themes/default/responsiveDesign/images/top-map.webp" alt="Иконка карты" />
						<a class="info-link" href="/contacts/">Как нас найти</a>								
					</div>
				</div>
				<div class="btn-group border-right one-of-five">
					<div class="col-sm-12 email">
						<img src="/themes/default/responsiveDesign/images/top-email.webp" alt="Иконка письма" />
						<a class="info-link" data-toggle="modal" data-target="#writeusModal" href="#">Написать нам</a>
					</div>
				</div>
				<div class="btn-group border-right one-of-five">
					<div class="col-sm-12 phone">
						<img src="/themes/default/responsiveDesign/images/top-phone.webp" alt="Иконка телефона" />
						<a class="info-link" data-toggle="modal" data-target="#callmeModal" href="#">Заказать звонок</a>
					</div>
				</div>
				<div class="btn-group border-right one-of-five">
					<div class="col-sm-12 clock">
						<img src="/themes/default/responsiveDesign/images/top-clock.webp" alt="Иконка часов" />
						<a class="info-link" href="/contacts/">График работы</a>								
					</div>
				</div>
				<div class="btn-group one-of-five">
					<div class="col-sm-12 vacancy">
						<img src="/themes/default/responsiveDesign/images/top-vacancy.webp" alt="Иконка портфеля" />
						<a class="info-link" href="/terms/">Условия работы</a>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div id="top-gray-block" class="hidden-xs">
        <div class="container">
            <div id="top-links-block" class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                <div class="row-fluid">
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group border-right">
                            <div class="col-sm-12 map">								
                                <a class="info-link" href="/contacts/">Как нас найти</a>								
                            </div>
                        </div>
                        <div class="btn-group border-right">
                            <div class="col-sm-12 email">
                                <a class="info-link" data-toggle="modal" data-target="#writeusModal" href="#">Написать нам</a>
                            </div>
                        </div>
                        <div class="btn-group border-right">
                            <div class="col-sm-12 phone">
                                <a class="info-link" data-toggle="modal" data-target="#callmeModal" href="#">Заказать звонок</a>
                            </div>
                        </div>
                        <div class="btn-group border-right">
                            <div class="col-sm-12 clock">
                                <a class="info-link" href="/contacts/">График работы</a>								
                            </div>
                        </div>
                        <div class="btn-group border-right">
                            <div class="col-sm-12 vacancy">
                                <a class="info-link" href="/terms/">Условия работы</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="top-phone-block" class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                <p><b>Оптовый отдел:</b> <a href="tel:83822266933">(3822) 266-933</a>, <a href="tel:83822266866">(3822) 266-866</a></p>
                <p><b>Розница:</b> <a href="tel:83822266687">(3822) 266-687</a></p>
            </div>
        </div>
    </div>
    <div id="logo-search-block" class="container hidden-xs">
        <div id="top-logo-block" class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <a href="/" title="Главная"><img src="/themes/default/responsiveDesign/images/logo.webp" /></a>
            <h3>Официальный дистрибьютор<br>TOTAL Lubricants, MANN-HUMMEL</h3>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12 search-box">
            <form id="top-search-form" method="get" action="/catalog/search/">
                <div class="input-append">
                    <input type="text" value="<?php echo (isset($_GET['catalog-search-text']) ? $_GET['catalog-search-text'] : ""); ?>" name="catalog-search-text" id="catalog-search-text" class="span2 form-control search-query-ajax search-query" autocomplete="off">
                    <button type="submit" class="btn" id="catalog-search-submit"></button>
                </div>				
				<ul class="search-box search-result-ajax"></ul>				
            </form>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" id="top-basket-img">
				<a href="/control/viewbasket/">
					<img src="/themes/default/responsiveDesign/images/basket.webp" />
					<span id="in-basket-count"><?php echo $_SESSION['basketcount']; ?></span>
				</a>
            </div>
            <?php if (!$auth1->hasIdentity()) : ?>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 top-reg-links">
                    <a id="login-link" href="#" title="Войти на сайт">Вход</a>
                    <div id="login-block">
                        <form action="/account/login/" method="post">
                            <div class="form-group login-input">
                                <input type="text" placeholder="Логин" value="" required="true" name="login" id="login-in" class="span3 form-control ">
                            </div>
                            <div class="form-group login-input">
                                <input type="password" placeholder="Пароль" value="" required="true" name="password" id="password-in" class="span3 form-control">
                            </div>
                            <div class="link-forget">
                                <a href="/account/restore/">Забыли пароль?</a>
                            </div>
                            <div class="form-group login-input-sub">
                                <input type="submit" value="Войти" class="login-submit" />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 top-reg-links">
                    <a href="/account/signup/" title="Зарегистрироваться на сайте">Регистрация</a>
                </div>
            <?php else : ?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-4 top-reg-links">
                    <a href="/control/"><?php if ($this->layout()->userInfo['name'] != '') echo $this->layout()->userInfo['name']; ?></a>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4 top-reg-links">
                    <a href="/account/logout/" title="Выйти с сайта">Выйти</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>