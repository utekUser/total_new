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

<?php if ($this->itIsEfeles == 1) : ?>
	<div style="margin: 40px 0 40px 0; padding: 10px 10px 20px 10px; background: #F9F9F9; border-radius: 5px; moz-border-radius: 5px; webkit-border-radius: 5px; width: 500px; border: 1px solid #D4D4D4;">
		<h4>Отчеты о поиске Смазок Efele</h4>
		<form name="searches" method="post" action="/admin/oils/searchoilreport/" target="_blank">
			<input type="text" placeholder="Дата начала периода: 2015-10-01" name="startdate" style="width: 300px; margin: 0 0 15px 0; padding: 4px 10px; background: #ffffff;" /> <br/>
			<input type="text" placeholder="Дата окончания периода: 2015-10-31" name="enddate" style="width: 300px; margin: 0 0 15px 0; padding: 4px 10px; background: #ffffff;" /> <br/>
			<input type="hidden" name="typesearch" value="efeles" />
			<p style="font-size: 20px; font-weight: bold; margin: 0 0 20px 0;">Формат ввода даты: <br/> ГОД-МЕСЯЦ-ДЕНЬ (2015-10-31)</p>
			<input type="submit" style="padding: 4px 10px;" value="Сформировать отчет" />
		</form>
	</div>
<?php endif; ?>

<?php if ($this->itIsAutoparts == 1) : ?>
	<div style="margin: 40px 0 40px 0; padding: 10px 10px 20px 10px; background: #F9F9F9; border-radius: 5px; moz-border-radius: 5px; webkit-border-radius: 5px; width: 500px; border: 1px solid #D4D4D4;">
		<h4>Отчеты о поиске Автомобильных запчастей</h4>
		<form name="searches" method="post" action="/admin/oils/searchoilreport/" target="_blank">
			<input type="text" placeholder="Дата начала периода: 2015-10-01" name="startdate" style="width: 300px; margin: 0 0 15px 0; padding: 4px 10px; background: #ffffff;" /> <br/>
			<input type="text" placeholder="Дата окончания периода: 2015-10-31" name="enddate" style="width: 300px; margin: 0 0 15px 0; padding: 4px 10px; background: #ffffff;" /> <br/>
			<input type="hidden" name="typesearch" value="autoparts" />
			<p style="font-size: 20px; font-weight: bold; margin: 0 0 20px 0;">Формат ввода даты: <br/> ГОД-МЕСЯЦ-ДЕНЬ (2015-10-31)</p>
			<input type="submit" style="padding: 4px 10px;" value="Сформировать отчет" />
		</form>
	</div>
<?php endif; ?>

<?php if ($this->itIsCoolstreams == 1) : ?>
	<div style="margin: 40px 0 40px 0; padding: 10px 10px 20px 10px; background: #F9F9F9; border-radius: 5px; moz-border-radius: 5px; webkit-border-radius: 5px; width: 500px; border: 1px solid #D4D4D4;">
		<h4>Отчеты о поиске охлаждающей жидкости</h4>
		<form name="searches" method="post" action="/admin/oils/searchoilreport/" target="_blank">
			<input type="text" placeholder="Дата начала периода: 2015-10-01" name="startdate" style="width: 300px; margin: 0 0 15px 0; padding: 4px 10px; background: #ffffff;" /> <br/>
			<input type="text" placeholder="Дата окончания периода: 2015-10-31" name="enddate" style="width: 300px; margin: 0 0 15px 0; padding: 4px 10px; background: #ffffff;" /> <br/>
			<input type="hidden" name="typesearch" value="coolstreams" />
			<p style="font-size: 20px; font-weight: bold; margin: 0 0 20px 0;">Формат ввода даты: <br/> ГОД-МЕСЯЦ-ДЕНЬ (2015-10-31)</p>
			<input type="submit" style="padding: 4px 10px;" value="Сформировать отчет" />
		</form>
	</div>
<?php endif; ?>

<?php if ($this->itIsPlugs == 1) : ?>
	<div style="margin: 40px 0 40px 0; padding: 10px 10px 20px 10px; background: #F9F9F9; border-radius: 5px; moz-border-radius: 5px; webkit-border-radius: 5px; width: 500px; border: 1px solid #D4D4D4;">
		<h4>Отчеты о поиске свечей</h4>
		<form name="searches" method="post" action="/admin/oils/searchoilreport/" target="_blank">
			<input type="text" placeholder="Дата начала периода: 2015-10-01" name="startdate" style="width: 300px; margin: 0 0 15px 0; padding: 4px 10px; background: #ffffff;" /> <br/>
			<input type="text" placeholder="Дата окончания периода: 2015-10-31" name="enddate" style="width: 300px; margin: 0 0 15px 0; padding: 4px 10px; background: #ffffff;" /> <br/>
			<input type="hidden" name="typesearch" value="plugs" />
			<p style="font-size: 20px; font-weight: bold; margin: 0 0 20px 0;">Формат ввода даты: <br/> ГОД-МЕСЯЦ-ДЕНЬ (2015-10-31)</p>
			<input type="submit" style="padding: 4px 10px;" value="Сформировать отчет" />
		</form>
	</div>
<?php endif; ?>

<?php foreach ($this->paginator as $value) :
	$firstEl = $value;
	break;
endforeach; ?>
<div class="add-row">
	<a href="/admin/<?php echo $this->control; ?>/add">Добавить</a>
</div>
<form action="" method="post" enctype="multipart/form-data">
	<div class="mtable-tl">
		<div class="mtable-tr">
			<div class="mtable-tm">
				<div class="mtable-bl">
					<div class="mtable-br">
						<div class="mtable-bm">
							<div id="main-table">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="admin-table">
									<tr>
										<th class="td-l">&nbsp;</th>
										<?php foreach ($this->titles as $value) : ?>
											<th><?php echo $value; ?></th>
										<?php endforeach; ?>
										<th width="7%">#</th>
										<?php if (array_key_exists('display', $firstEl)) : ?>
											<th width="7%">Отображать</th>
										<?php endif; ?>
										<?php if (array_key_exists('pos', $firstEl)) : ?>
											<th width="9%">Переместить</th>
										<?php endif; ?>
									</tr>
									<?php $countOnPage = $this->paginator->getCurrentItemCount();
									$i = 1;
									$count = $this->paginator->getTotalItemCount();
									foreach ($this->paginator as $value) :
										?>
										<tr <?php echo ($i % 2 ? 'class="odd"' : ''); ?>>
											<td align="left" width="2%"><input type="checkbox" value="<?php echo $value['id']; ?>" name="type[]"></td>
											<?php
											$ii = 1;
											foreach ($this->titles as $key => $valueM) :
												?>
												<td <?php if ($ii == 1) echo 'align="left"'; ?>  valign="top" <?php if ($ii != 1) echo 'width="10%"'; ?>>
													<a href="/admin/<?php echo $this->control; ?>/edit/<?php echo $value['id']; ?>"><?php echo htmlspecialchars($value[$key]); ?></a>
													<?php if ($ii == 1) : ?>
														<div class="row-actions-parent">
															<div class="row-actions">
																<span><a href="/admin/<?php echo $this->control; ?>/edit/<?php echo $value['id']; ?>" class="row-actions-change">Изменить</a></span>
																|
																<span><a onclick="if (confirm('Вы собираетесь удалить запись?\n  «Отмена» &mdash; оставить, «OK» &mdash; удалить.')) {
			                                                                            return true;
			                                                                        }
			                                                                        return false;" href="/admin/<?php echo $this->control; ?>/delete/<?php echo $value['id']; ?>" class="row-actions-del">Удалить</a>
																</span>
															</div>
														</div>
													<?php endif; ?>
												</td>
												<?php
												$ii++;
											endforeach;
											?>
											<td valign="top"><?php echo $value['id']; ?></td>
											<?php if (array_key_exists('display', $firstEl)) : ?>
												<td valign="top">
													<?php if ($value['display']) : ?>
														<a href="/admin/<?php echo $this->control; ?>/hide/<?php echo $value['id']; ?>">
															<img src="/application/themes/admin/images/display.png" alt="" width="18" height="15" />
														</a>
													<?php else : ?>
														<a href="/admin/<?php echo $this->control; ?>/display/<?php echo $value['id']; ?>">
															<img src="/application/themes/admin/images/display-not.png" alt="" width="15" height="17" />
														</a>
													<?php endif; ?>
												</td>
											<?php endif; ?>
											<?php if (array_key_exists('pos', $firstEl)) : ?>
											<td valign="top">
												<table class="main-table-pos" width="100%%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="50%">
															<?php if ($i != $countOnPage) : ?>
																<a href="/admin/<?php echo $this->control; ?>/down/<?php echo $value['id']; ?>"><img src="/application/themes/admin/images/arrow-down.png" width="13" height="13" alt="Вниз" /></a>
															<?php endif; ?>
														</td>
														<td>
															<?php if ($i != 1) : ?>
																<a href="/admin/<?php echo $this->control; ?>/up/<?php echo $value['id']; ?>"><img src="/application/themes/admin/images/arrow-up.png" width="13" height="13" alt="Вверх" /></a>
															<?php endif; ?>
														</td>
													</tr>
												</table>
											</td>
											<?php endif; ?>
										</tr>
										<?php
										$i++;
									endforeach;	?>
								</table>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr class="table-footer">
										<td>
											<table width="100%" class="table-footer-all">
												<tr>
													<td width="30%" align="left">Всего: <b><?php echo $count; ?></b> записей</td>
													<td width="40%" align="center">
														<?php echo $this->paginationControl($this->paginator, 'Sliding', 'admin/admin-page.tpl'); ?>
													</td>
													<td width="30%" align="right">
														<input type="hidden" value="<?php echo $this->paginator->getCurrentPageNumber(); ?>" name="page2">
														<select onchange="this.form.submit()" name="pager">
															<option value="1" selected="selected">10</option>
															<option value="2">20</option>
															<option value="3">30</option>
															<option value="4">40</option>
															<option value="5">50</option>
														</select>
														<a href="/admin/<?php echo $this->control; ?>/?page=all" class="show-all">Показать все</a>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="messages-ch">
        <span onclick="$('input[type=checkbox]').attr('checked', true);">Отметить все</span>
        |
        <span onclick="$('input[type=checkbox]').attr('checked', false);">Снять выделение</span>

        <select style="margin: 0 3em 0 3em;" onchange="this.form.submit();" name="submit_mult">
			<option selected="selected" value="С отмеченными:">С отмеченными:</option>
			<option value="display">Отобразить</option>
			<option value="hide">Скрыть</option>
			<option value="delete">Удалить</option>
		</select>

    </div>    
</form>