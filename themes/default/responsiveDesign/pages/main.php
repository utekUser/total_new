<div id="catalog-blocks">
	<?php foreach ($this->makersMain as $maker) : ?>
		<?php $key = "main-l-" . $maker['link']; ?>
		<style>
			.<?php echo $key; ?> {
				background:url("<?php echo $maker['image']; ?>")  bottom center no-repeat;
			}
			.<?php echo $key; ?>:hover {
				background:url("<?php echo $maker['image_hover']; ?>") bottom center no-repeat;
			}
		</style>
		<a href="/catalog/maker/<?php echo $maker['link']; ?>/">
			<span class="img-social <?php echo $key; ?>" ></span>
		</a>
	<?php endforeach; ?>
</div>
<div id="special-goods-block">
	<div id="special-title">
		<h1>Случайные предложения</h1>
	</div>
	<div id="special-goods">
		<div class="row-fluid">
			<div id="random-goods" class="btn-group btn-group-justified">
				<img id="loading-image" src="/media/filebrowser/uploads/2020/ajax-loader-2.webp" />
			</div>
		</div>
	</div>
</div>
<div id="main-news-block" class="hidden-xs">
	<div class="row-fluid">
		<div class="btn-group btn-group-justified">
			<?php foreach ($this->layout()->news as $new) : ?>			
				<div class="btn-group border-right">
					<div class="col-sm-12 new">								
						<?php echo $this->Link('/news/' . ($new['url'] ? $new['url'] . '-' : '') . $new['id'] . '.html', $new['name']); ?>								
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>