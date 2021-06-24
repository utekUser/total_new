<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-lr-0 catalog-page">	
	<div class="hidden-xs">
		<?php $i = 0; ?>
		<?php foreach ($this->goods as $key => $good) : ?>
			<?php if ($i == 0) : ?>
				<div class="row-fluid goods-row">				
				<?php endif; ?>
				<?php if ($i < 4) : ?>
					<?php $goodLink = "/catalog/good/" . translit($good['name']) . "-" . $good['id'] . ".html"; ?>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 good-border">
						<div class="good-info good">				
							<div class="favourites-star">
								<img class="add-favourites" id="add-favourites-<?php echo $good['id']; ?>" src="/themes/default/responsiveDesign/images/star.webp">
							</div>
							<a href="<?php echo $goodLink; ?>">
								<?php $imgLink = "/themes/default/responsiveDesign/images/no_photo.webp";
								if ($good['image'] != "") {
									$imgLink = "/public/catalog/" . $good['image'];
								} ?>
								<img class="good-img" height="130" alt="<?php echo $good['name']; ?>" src="<?php echo $imgLink; ?>" />
							</a>						
							<a href="<?php echo $goodLink; ?>" class="good-link">
								<?php echo $good['name']; ?>
							</a>
							<p class="count-text">В наличии: <span class="count-number"><?php echo number_format($good['offer_count'], 0, "", " "); ?></span> шт.</p>
							<p class="price-text"><span class="price-number"><?php echo number_format($good['price'], 0, "", " "); ?></span> руб.</p>						
							<div class="to-basket">
								<a class="add-to-basket" id="add-to-basket-<?php echo $good['id']; ?>">В корзину</a>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php
				$i++;
				if ($i == 4) :
					$i = 0;
					?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php
		if ($i != 0) {
			echo "</div>";
		}
		?>
	</div>
	<div class="visible-xs-block">
		<?php foreach ($this->goods as $key => $good) : ?>			
			<div class="good-border" >
				<?php $goodLink = "/catalog/good/" . translit($good['name']) . "-" . $good['id'] . ".html"; ?>
				<div class="col-sm-12 good-info good good-mobile">
					<div class="col-xs-5 padding-l0">
						<div class="favourites-star">
							<img class="add-favourites" id="add-favourites-<?php echo $good['id']; ?>" src="/themes/default/responsiveDesign/images/star.webp" />
						</div>
						<a href="<?php echo $goodLink; ?>">
							<?php $imgLink = "/themes/default/responsiveDesign/images/no_photo.webp";
							if ($good['image'] != "") {
								$imgLink = "/public/catalog/" . $good['image'];
							} ?>
							<img class="good-img" alt="<?php echo $good['name']; ?>" src="<?php echo $imgLink; ?>" />
						</a>
					</div>
					<div class="col-xs-7 padding-lr-0">
						<a href="<?php echo $goodLink; ?>" class="good-link"><?php echo $good['name']; ?></a>
						<p class="count-text">В наличии: <span class="count-number"><?php echo number_format($good['offer_count'], 0, "", " "); ?></span> шт.</p>
						<p class="price-text"><span class="price-number"><?php echo number_format($good['price'], 0, "", " "); ?></span> руб.</p>
						<div class="to-basket">
							<a class="add-to-basket" id="add-to-basket-<?php echo $good['id']; ?>">В корзину</a>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>	
	</div>
	<?php if ($this->goods->count() > 1) : ?>
		<div class="paginator">
			<?php echo $this->paginationControl($this->goods, 'Sliding', 'user-page.tpl'); ?>
		</div>
	<?php endif; ?>
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