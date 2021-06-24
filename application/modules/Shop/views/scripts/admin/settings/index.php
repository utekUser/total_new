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
<div class="settings">
    <div>
        <a href="/admin/shop/settings/status/"><img alt="" src="/application/themes/admin/images/settings.png" /></a><br />
        <a href="/admin/shop/settings/status/">Статусы заказа</a>
    </div>
    <div>
        <a href="/admin/shop/settings/prices/"><img alt="" src="/application/themes/admin/images/settings.png" /></a><br />
        <a href="/admin/shop/settings/prices/">Типы цен</a>
    </div>
    <div>
        <a href="/admin/shop/settings/sale/"><img alt="" src="/application/themes/admin/images/settings.png" /></a><br />
        <a href="/admin/shop/settings/sale/">Скидки</a>
    </div>
</div>
<script>
	$(function () {
		$("#textfield").change(function () {
			textfield = $("#textfield").val();
			$.ajax({
				url: "/admin/shop/settings/updatesetting/",
				type: "GET",
				data: "textfield=" + textfield,
				cache: false,
				success: function (response) {
					if (response == "yes") {
						$("#textfield").next().text("Данные успешно изменены.").css("color", "green").fadeIn(400);
					} else {
						$("#textfield").next().text("Ошибка обновления данных.").css("color", "red").fadeIn(400);
					}
				}
			});
		});
		$("#datetime").change(function () {
			datetime = $("#datetime").val();
			$.ajax({
				url: "/admin/shop/settings/updatesetting/",
				type: "GET",
				data: "datetime=" + datetime,
				cache: false,
				success: function (response) {
					if (response == "yes") {
						$("#datetime").next().text("Данные успешно изменены.").css("color", "green").fadeIn(400);
					} else {
						$("#datetime").next().text("Ошибка обновления данных.").css("color", "red").fadeIn(400);
					}
				}
			});
		});
	});
</script>
<div id="order-settings">
	<div class="edit-div-mm">
		<table class="edit-table" cellpadding="0" cellspacing="0">
			<tbody>
				<tr>
					<?php $settingModel = new Shop_Models_ShopSetting();
					$sumToday = $settingModel->getSettingById(1); ?>
					<td class="td-title">Сумма заказа, при доставке в день заказа</td>
					<td>
						<input type="text" name="textfield" id="textfield" value="<?php echo $sumToday['textfield'];?>">                        
						<p></p>
					</td>
				</tr>
				<tr>
					<?php $timeToday = $settingModel->getSettingById(2); ?>
					<td class="td-title">Время, до которого доставка будет в день заказа</td>
					<td>
						<div class="input-calendar">
							<input type="text" name="datetime" id="datetime" value="<?php echo $timeToday['datetime'];?>">
							<p></p>
							<script type="text/javascript">Calendar("datetime", fmtYYYYMMDD, "-");</script>
							<a href="javascript:arrCalendars[0].Show()">
								<img src="/externals/calendar/calendar.gif" class="dateimg" align="absmiddle" title="Выбрать дату">
							</a>
						</div>                        
					</td>
				</tr>				
			</tbody>
		</table>
	</div>
</div>