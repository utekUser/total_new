<?php include 'modalWindow.php'; ?>
<div class="control-page">
	<div class="row-fluid">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-l0 my-data">
			<div class="block-border">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-image user"></div>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
					<h4>Мои данные</h4>					                   
                    <div class="form-group row-fluid profile-input">
                        <label for="phone" class="col-sm-4 col-form-label col-xs-3 padding-lrm-0">Телефон:</label>
                        <div class="col-sm-8 col-xs-9 padding-lrm-0">
                            <input type="text" class="form-control-plaintext" readonly name="phone" id="phone" value="<?php echo $this->info['phone']; ?>">                            
                        </div>
                    </div>
					<div class="form-group row-fluid profile-input">
                        <label for="email" class="col-sm-4 col-form-label col-xs-3 padding-lrm-0">E-mail:</label>
                        <div class="col-sm-8 col-xs-9 padding-lrm-0">
                            <input type="text" readonly class="form-control-plaintext" name="email" id="email" value="<?php echo $this->user['email']; ?>">                            
                        </div>
                    </div> 
					<div class="bottom-center"><a href="/control/profile/" title="Подробная информация">Подробная информация</a></div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-r0 my-messages">
			<div class="block-border">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-image email"></div>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
					<h4>Сообщения</h4>
					<div class="text-p-center"><p>У Вас нет сообщений</p></div>
					<div class="bottom-center margin-t2 "><a class="a-message" href="/messages/mailbox/" title="Написать">Написать</a></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-l0 my-orders">
			<div class="block-border bg-gray">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-image package"></div>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
					<h4>Заказы к получению</h4>		
					<div class="text-p-center"><p>В настоящий момент<br>заказов к получению нет</p></div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-r0 my-basket">
			<div class="block-border bg-yellow">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-image basket"></div>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
					<h4>Корзина</h4>
					<?php if ($this->basketGoods > 0) : ?>
						<div class="text-p-center-basket">
							<p>В корзине 
								<span class="in-basket-count"><?php echo $this->basketGoods; ?></span> 
								товар<?php echo ($this->basketGoods == 1 ? "" : ($this->basketGoods > 1 && $this->basketGoods < 5 ? "а" : "ов")); ?>
							</p>
							<p>На сумму <span class="in-basket-summ"><?php echo number_format($this->basketSumm, 0, "", " "); ?></span> руб.</p>
						</div>
						<div class="bottom-center margin-t15"><a class="a-tobasket" href="/control/viewbasket/" title="Перейти в корзину">Перейти в корзину</a></div>
					<?php else : ?>
						<div class="text-p-center"><p>Ваша корзина пуста</p></div>
						<div class="bottom-center margin-t2"><a class="a-tobasket" href="/catalog/" title="Добавить товар">Добавить товар</a></div>
					<?php endif; ?>							
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-l0 my-favourites">
			<div class="block-border">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-image star"></div>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
					<h4>Избранные товары</h4>
					<?php if (count($this->favGoods) > 0) : ?>
						<div class="text-p-no-center">
							<?php foreach ($this->favGoods as $key => $good) : ?>
								<p><?php echo iconv_substr($good['name'], 0, 30, "UTF-8") . (strlen($good['name']) > 30 ? "..." : ""); ?></p>
							<?php endforeach; ?>
						</div>	
						<div class="bottom-center margin-t15"><a href="/control/favourites/" title="Смотреть все товары">Смотреть все товары</a></div>
					<?php else : ?>
						<div class="text-p-center"><p>Список товаров пуст</p></div>
						<div class="bottom-center margin-t2"><a href="/control/favourites/" title="Посмотреть избранное">Посмотреть избранное</a></div>
					<?php endif; ?>					
				</div>
			</div>
		</div>
	</div>
</div>
<?php /* <div class="path">
	<a href="/"><img alt="" src="/themes/default/images/house.png" /></a>
	<span>Личный кабинет</span>
</div>
<h1>Личный кабинет</h1>    */ ?>
<?php /*if (Engine_Cms::displayContent(6)) { ?>
    <?php echo Engine_Cms::displayContent(6); ?>
<?php }*/ ?>
<?php /* if (!$this->isManager) { ?>
	<a style="margin:10px 0 0" href="/messages/send/" class="add-message">Написать сообщение</a>
<?php } */ ?>
<?php /* ?>
<div class="mes-admin">
    <div class="page-razd"></div>
    <?php if ($this->success && $_SERVER['REMOTE_ADDR'] = '91.221.60.226') { ?>
    <p>Спасибо! Ваше сообщение отправлено и будет рассмотрено администратором!</p>
    <p>Есть ещё вопросы? Вы можете <a href="/control/" title="Задать еще вопрос">задать другой вопрос</a>.</p>
    <?php } elseif ($_SERVER['REMOTE_ADDR'] = '91.221.60.226') { ?>
    <span class="title">Написать администратору</span>
    <form method="post" action="/control/">
        <div class="grey-corner-tl">
            <div class="grey-corner-tr">
                <div class="grey-corner-tm"></div>
            </div>
        </div>
        <div class="grey-corner-m">
            <div class="form-field">
                <div class="field-data">
                    <span>Ваше сообщение: </span><span class="orandzh">*</span>
                    <div class="field-input">
                        <textarea class="input-long" cols="20" rows="5" name="message"></textarea>
                        <input type="hidden" name="author" value="<?php echo $this->userLogin; ?>" />
                        <input type="hidden" name="email" value="<?php echo $this->userEmail; ?>" />
                    </div>
                </div>
                <div class="field-info"></div>
            </div>
            <?php
            $error = $this->elements['message']->getMessages();
            if (!empty($error)) { ?>
                <div class="error-list"><ul>
                <?php foreach ($error as $keyError => $valueError) { ?> <li><?php echo $valueError; ?></li><?php } ?>
                </ul></div>
            <?php } ?>
            <div class="book-form">
                <div class="book-form-title">&nbsp;</div>
                <div class="book-form-input"><input type="submit" class="book-button" name="button" value=""></div>
                <div class="book-form-remark"></div>
            </div>
        </div> 
        <div class="grey-corner-bl">
            <div class="grey-corner-br">
                <div class="grey-corner-bm"></div>
            </div>
        </div>
    </form> 
    <?php } ?>
</div>
<?php */ ?>
<?php if ($this->priceType == 'base') { /* ?>
<script type="text/javascript">
        $(document).ready(function(){
            function arcticmodal_close() {
                $('#boxFootball').arcticmodal('close');
            }
            if (!$.cookie('wasVisitFootball1')) {
                $('#boxFootball').arcticmodal({
                    closeOnOverlayClick: true,
                    closeOnEsc: true
                });
            }
            $.cookie('wasVisitFootball1', true, {
                expires: 1,
                path: '/control/'
            });
        });
        </script>   
<div style="display: none;">
<div id="boxFootball" class="box-modal">
<div class="box-modal_close arcticmodal-close">закрыть</div>
<img style="display: block;" src="/media/filebrowser/uploads/banners/2016/03/10toplugs.jpg" alt="" width="500" /></div>
</div>
<?php */ } else { /* ?>
<script type="text/javascript">
        $(document).ready(function(){
            function arcticmodal_close() {
                $('#boxFootball').arcticmodal('close');
            }
            if (!$.cookie('wasVisitFootball1')) {
                $('#boxFootball').arcticmodal({
                    closeOnOverlayClick: true,
                    closeOnEsc: true
                });
            }
            $.cookie('wasVisitFootball1', true, {
                expires: 1,
                path: '/control/'
            });
        });
        </script>   
<div style="display: none;">
<div id="boxFootball" class="box-modal">
<div class="box-modal_close arcticmodal-close">закрыть</div>
<img style="display: block;" src="/media/filebrowser/uploads/banners/2018/01/220118.jpg" alt="" width="500" /></div>
</div>
<?php */ } ?>
<?php if ($this->isOrderMessageShow == 1) { ?>
<script type="text/javascript">
    $(document).ready(function(){
        function arcticmodal_close() {
            $('#boxBasketMessage').arcticmodal('close');
        }
        if (!$.cookie('wasBasketMessage')) {
            $('#boxBasketMessage').arcticmodal({
                closeOnOverlayClick: true,
                closeOnEsc: true
            });
        }
        $.cookie('wasBasketMessage', true, {
            expires: 1,
            path: '/control/'
        });
    });
</script> 
<div style="display: none;">
	<div id="boxBasketMessage" class="box-modal" style="padding: 40px;">
		<div class="box-modal_close arcticmodal-close">закрыть</div>
		<h3>Уважаемый клиент!</h3>
		<p>Напоминаем Вам, что у Вас имеются не оформленные заказы!</p>
		<p>Рекомендуем оформить заказ в течении трех дней.</p>
		<p>По истечению данного срока выбранные Вами товары, будут удалены!</p>
	</div>
</div>
<?php } ?>
