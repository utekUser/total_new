<div class="breadcrumbs">
	<?php $i = 1; ?>
	<?php foreach ($this->breadCrumbs as $key => $value) : ?>	
		<a href="<?php echo $key; ?>">
			<?php if ($i != count($this->breadCrumbs)) : ?>
				<b><?php echo $value; ?></b>
			<?php else : ?>
				<?php echo $value; ?>
			<?php endif; ?>
		</a>
		<?php if ($i != count($this->breadCrumbs)) echo "&nbsp;»&nbsp;"; 
		$i++; ?>		 
	<?php endforeach; ?>
</div>