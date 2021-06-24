<div class="path-l">
	<div class="path-r">
		<div class="path-m">
			<div class="path">
				<?php echo $this->path; ?>
			</div>
			<div class="module-name">
				<?php echo $this->header; ?>
			</div>
		</div>
	</div>
</div>

<div class="list-init">
    <table width="100%%" border="0" cellspacing="0" cellpadding="0">
		<caption>Разделы</caption>
		<?php foreach ($this->module as $key => $value) { ?>
			<tr>
				<th><a href="/admin/shop/<?php echo $key; ?>/"><?php echo $value; ?></a></th>
				<td>
					<?php if ($key != "" && $key != "&nbsp;") : ?>
						<a href="/admin/shop/<?php echo $key; ?>/add">Добавить</a>
					<?php endif; ?>
				</td>
				<td>
					<?php if ($key != "" && $key != "&nbsp;") : ?>
						<a href="/admin/shop/<?php echo $key; ?>/">Изменить</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php } ?>
    </table>
</div>