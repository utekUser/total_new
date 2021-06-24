<?php $good = $this->good; ?>
<div class="row-fluid good-page">
	<div class="row-fluid good-info">
		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 padding-lr-0">
			<?php $imgLink = "/themes/default/responsiveDesign/images/no_photo.webp";
			if ($good['image'] != "") {
				$imgLink = "/public/catalog/" . $good['image'];
			} ?>
			<img class="logo-img" height="130" alt="<?php echo $good['name']; ?>" src="<?php echo $imgLink; ?>" />
			<?php /* <img class="logo-img" height="130" src="/public/catalog/<?php echo $good['image']; ?>" alt="<?php echo $good['name']; ?>" /> */ ?>
		</div>	
		<div class="col-lg-9 col-md-9 col-sm-8 col-xs-6 padding-lr-0">
			<p><span class="upper">Категория:</span> <?php echo $this->goodCategory; ?></p>
			<p><span class="upper">Артикул:</span> <?php echo $good['article']; ?></p>
			<?php if ($good['offer_count'] == 0) : ?>
				<p class="not-on-warehouse">* Товар отсутствует на складе. Срок поставки от 2-х дней, точную дату можно уточнить у менеджера по тел.:
					<a href="tel:8-3822-266-687">266-687</a>
				</p>
			<?php else : ?>
				<p><span class="upper">Количество:</span> <?php echo number_format($good['offer_count'], 0, "", " "); ?></p>				
			<?php endif; ?>
			<p class="good-price">
				<span class="upper">Цена:</span> 
				<span class="price-size"><?php echo number_format($good['price'], 0, "", " "); ?></span> руб.				
			</p>				
			<div class="to-basket <?php echo ($this->inBasket == "Yes!" ? "added" : ""); ?>">
				<a class="add-to-basket" id="add-to-basket-<?php echo $good['id']; ?>">
					<?php echo ($this->inBasket == "Yes!" ? "Удалить" : "В корзину"); ?>					
				</a>
			</div>
		</div>	
	</div>
	<ul class="good-tabs">
		<li><span>Описание</span></li>
	</ul>
	<div class="row-fluid col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-lr-0">			
		<?php echo $good['description']; ?>
	</div>
</div>