<?php if ($this->orderInfo) : ?>
	<div class="notetext">
	    <b>Заказ сформирован</b><br /><br />
	    Ваш заказ <b>№<?php echo $this->orderInfo['id']; ?></b> от <?php echo $this->Date($this->orderInfo['date'], 'numeric'); ?> успешно создан.<br />
	    Вы можете следить за выполнением своего заказа в <a href="/control/history/">Персональном разделе сайта</a>.
	</div>
<?php else : ?>
	<p>Неверная ссылка.</p>
<?php endif; ?>
