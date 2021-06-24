<div class="view-basket">
	<p>
		В корзине 
		<span id="in-basket-count-account" class="in-basket-count-account"><?php echo count($this->itemsInBasket); ?></span> 
		товар<?php echo (count($this->itemsInBasket) == 1 ? "" : (count($this->itemsInBasket) > 1 && count($this->itemsInBasket) < 5 ? "а" : "ов")); ?>
	</p>
	<div class="view-basket-table">
		<?php if (sizeof($this->itemsInBasket)) : ?>
			<table class="hidden-xs">
				<thead>
					<tr>
						<td width="32%" colspan="2">Наименование товара</td>
						<td>Наличие на складах</td>
						<td>Цена, руб.</td>
						<td>Количество</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($this->itemsInBasket as $item) : ?>
						<tr id="item-row-<?php echo $item['id']; ?>">
							<td class="item-image">
								<?php
								$imgLink = "/themes/default/responsiveDesign/images/no_photo.webp";
								if ($item['image'] != "") {
									$imgLink = "/public/catalog/" . $item['image'];
								}
								?>
								<img class="logo-img" height="70" alt="<?php echo $item['name']; ?>" src="<?php echo $imgLink; ?>" />
							</td>
							<td class="item-name">
								<a target="_blank" href="/catalog/good/<?php echo translit($item['name']) . "-" . $item['id']; ?>">
									<?php echo $item['name']; ?>
								</a>
							</td>
							<td class="item-stock" id="goodstock-----<?php echo $item['id']; ?>">
								<?php /*foreach ($this->warehouses[$item['id']] as $warh) : ?>
									<p><?php echo $warh; ?></p>
								<?php endforeach;*/ ?>								                    
							</td>
							<td class="item-price">
								<p>
									<span><?php echo number_format($item['price'], 0, "", " "); ?></span>
									руб.
								</p>
							</td>
							<td class="item-amount">
								<img id="one-minus-<?php echo $item['id']; ?>" class="one-minus" src="/themes/default/responsiveDesign/images/basket-minus.webp" />
								<input id="id-basket-order-<?php echo $item['id']; ?>" class="basket-count" type="text" value="<?php echo $item['basket_count']; ?>" readonly="true" name="basket-order-<?php echo $item['id']; ?>"/>
								<img id="one-plus-<?php echo $item['id']; ?>" class="one-plus" src="/themes/default/responsiveDesign/images/basket-plus.webp" />								
							</td>
							<td class="item-action" style="padding: 10px 0;">
								<img id="one-delete-<?php echo $item['id']; ?>" class="one-delete" src="/themes/default/responsiveDesign/images/basket-delete.webp" />								
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<table class="visible-xs-block basket-m">
					<tbody>
					<?php foreach ($this->itemsInBasket as $item) : ?>
						<tr class="border-top-m item-row-m-<?php echo $item['id']; ?>">
							<td class="td-bg-m">Наименование товара</td>
							<td class="item-name">
								<a target="_blank" href="/catalog/good/<?php echo translit($item['name']) . "-" . $item['id']; ?>">
									<?php echo $item['name']; ?>
								</a>
							</td>
						</tr>
						<tr class="item-row-m-<?php echo $item['id']; ?>">
							<td class="td-bg-m">Цена</td>
							<td class="item-price">
								<p>
									<span><?php echo number_format($item['price'], 0, "", " "); ?></span>
									руб.
								</p>
							</td>
						</tr>
						<tr class="item-row-m-<?php echo $item['id']; ?>">
							<td class="td-bg-m">Количество</td>
							<td class="item-amount">
								<img id="one-minus-m-<?php echo $item['id']; ?>" class="one-minus" src="/themes/default/responsiveDesign/images/basket-minus.webp" />
								<input id="id-basket-order-m-<?php echo $item['id']; ?>" class="basket-count" type="text" value="<?php echo $item['basket_count']; ?>" name="basket-order-<?php echo $item['id']; ?>"/>
								<img id="one-plus-m-<?php echo $item['id']; ?>" class="one-plus" src="/themes/default/responsiveDesign/images/basket-plus.webp" />								
							</td>
						</tr>
						<tr class="item-row-m-<?php echo $item['id']; ?>">
							<td class="td-bg-m">Наличие на складах</td>
							<td class="item-stock" id="goodstockm-----<?php echo $item['id']; ?>">
								<?php foreach ($this->warehouses[$item['id']] as $warh) : ?>
									<p><?php echo $warh; ?></p>
								<?php endforeach; ?>
							</td>
						</tr>
						<tr class="border-bottom-m item-row-m-<?php echo $item['id']; ?>">
							<td class="td-bg-m"></td>
							<td class="item-action" style="padding: 10px 0;">
								<img id="one-delete-m-<?php echo $item['id']; ?>" class="one-delete" src="/themes/default/responsiveDesign/images/basket-delete.webp" />								
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<div class="total-sum">
				Итого:&nbsp;&nbsp;&nbsp;&nbsp;<span id="all-basket-summ" class="rubbles"><?php echo number_format($this->itemsInBasketCount, 0, "", " "); ?></span> руб.
			</div>
			<a class="arrange-order good-count" id="get-good-count" href="#">Уточнить количество</a>
			<a class="arrange-order" href="/control/order/">Оформить заказ</a>
		<?php else : ?>
			<table width="100%" cellspacing="0" cellpadding="0" border="0" class="order-history">
				<tr>
					<th style="border-bottom: 1px solid #e4e4e4; border-top: 1px solid #e4e4e4; width: 50%;">Наименование товара</th>
					<!--<th>Упаковка/л.</th>-->
					<th style="border-bottom: 1px solid #e4e4e4; border-top: 1px solid #e4e4e4; width: 25%;">Цена, руб.</th>
					<th style="border-bottom: 1px solid #e4e4e4; border-top: 1px solid #e4e4e4;" colspan="2" style="width: 60px">Количество</th>
				</tr>
				<tr class="info">
					<td colspan="4" class="item-name" style="padding: 5px 15px;">
						<p style="font-size: 12px">Корзина пуста, подберите что-нибудь в нашем <a href="/catalog/">каталоге</a> или воспользуйтесь блоком «Желаемый продукт».</p>
					</td>
				</tr>
			</table>
		<?php endif; ?>
	</div>
</div>
<div class="wishes-block">
    <h1 id="page-title">Желаемый продукт</h1>
    <p>Если вы не нашли на нашем сайте нужный вам товар — Вы можете добавить его в заказ в раздел «Желаемая продукция» — наши менеджеры свяжутся с Вами, подтвердят возможность выполнения заказа и сообщат о возможных сроках доставки.</p>
    <form class="desired-ajax-form" action="/catalog/desired/">
		<div class="input-append">
            <input type="text" value="" name="catalog-search-text" id="wishes-search-input" class="span7 form-control" autocomplete="off">
            <button type="submit" class="btn" id="wishes-search-submit">Отправить</button>
			<br style="clear: both;"/>
        </div>        
    </form>
    <div id="desiredtable">
		<?php if (count($this->desired)) { ?>
	        <table style="width: 100%">
	            <thead>
					<tr>
						<td style="font-weight: 700">Наименование желаемого товара для заказа</td>
						<td>&nbsp;</td>
					</tr>
	            </thead>
				<?php foreach ($this->desired as $product) { ?>
		            <tr>
		                <td><?php echo htmlspecialchars($product['name']); ?></td>
		                <td style="width: 50px; text-align: right"><a id="desired<?php echo $product['id']; ?>" style="margin: 25px 0px 0 0;" href="/delete/">Удалить</a></td>
		            </tr>
				<?php } ?>
	        </table>
		<?php } ?>
    </div>
</div>



<?php function translit($s) {
	$s = (string) $s;
	$s = strip_tags($s);
	$s = str_replace(array("\n", "\r"), " ", $s);
	$s = preg_replace("/\s+/", ' ', $s);
	$s = trim($s);
	$s = function_exists('mb_strtolower') ? mb_strtolower($s,'utf-8') : strtolower($s);
	$s = strtr($s, array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => ''));
	$s = preg_replace("/[^0-9a-z-_ ]/i", "", $s);
	$s = str_replace(" ", "-", $s);
	return $s;
} ?>