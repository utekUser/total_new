<?php
$adParam = "";
if (isset($this->addParam)) {
	$adParam = '&' . $this->addParam;
}
?>
<?php if ($this->pageCount > 1) : ?>
	<ul class="nav">
		<?php if (isset($this->previous)) : ?>
			<?php if ($this->previous != 1) : ?>
			<li><a title="Первая" href="?page=1<?php echo $adParam;?>" class="pager-first">Первая</a></li>
			<?php endif; ?>
			<li><a title="Предыдущая" class="pager-left" href="?page=<?php echo $this->previous . $adParam; ?>">Предыдущая</a></li>
		<?php endif; ?>
		<?php foreach ($this->pagesInRange as $page) : ?>
			<?php if ($page != $this->current) : ?>
				<li><a title="<?php echo $page; ?>" href="?page=<?php echo $page . $adParam; ?>"><?php echo $page; ?></a></li>
			<?php else : ?>
				<li><a href='#' class="pager-active"><?php echo $page; ?></a></li>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php if (isset($this->next)) : ?>
			<li><a title="Следующая" href="?page=<?php echo $this->next . $adParam; ?>" class="pager-right">Следующая</a></li>
			<?php if ($this->next != $this->last) : ?>
				<li><a title="Последняя" href="?page=<?php echo $this->last . $adParam; ?>" class="pager-last">Последняя</a></li>
			<?php endif; ?>
		<?php endif; ?>
	</ul>
<?php endif; ?>