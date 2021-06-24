<?php
$adParam = "";
if (isset($this->addParam)) {
	$adParam = '&' . $this->addParam;
}
?>
<?php if ($this->pageCount > 1) : ?>
	<div class="pager">
		<?php if (isset($this->previous)) : ?>
			<?php if ($this->previous != 1) : ?>
				<a href="?page=1<?php echo $adParam;?>" title="Первая страница" class="prev">&laquo;</a>
			<?php endif; ?>
			<a href="?page=<?php echo $this->previous . $adParam; ?>" title="Предыдущая страница" class="prev">&#8592;</a>
		<?php endif; ?>
		<?php foreach ($this->pagesInRange as $page) : ?>
			<?php if ($page != $this->current) : ?>
				<a href="?page=<?php echo $page . $adParam; ?>" title="<?php echo $page; ?> страница"><?php echo $page; ?></a>
			<?php else : ?>
				<a href="?page=<?php echo $page . $adParam; ?>" title="Текущая страница" class="active"><?php echo $page; ?></a>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php if (isset($this->next)) : ?>
			<a href="?page=<?php echo $this->next . $adParam; ?>" title="Следующая страница" class="next">&#8594;</a>
			<?php if ($this->next != $this->pageCount) : ?>
				<a href="?page=<?php echo $this->pageCount . $adParam; ?>" title="Последняя страница" class="next">&raquo;</a>
			<?php endif; ?>
		<?php endif; ?>		
	</div>
<?php endif; ?>