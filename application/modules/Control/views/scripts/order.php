<div class="order-send">
	<p class="before-text">
		После подтверждения – заказ будет отправлен в обработку. С Вами свяжется наш менеджер.
		<br />Знаком <span class="orandzh">*</span> отмечены обязательные для заполнения поля.
	</p>
	<?php if (sizeof($this->error)) : ?>
		<div class="error-list">
			<?php foreach ($this->error as $error)
				echo '<p>' . $error . '</p>'; 
			?>
		</div>
	<?php endif; ?>
	<form method="POST" action="/control/order/">
		<div class="order-block">
			<h3>1. Контактное лицо</h3>
			<?php if (!$this->userType) : ?>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-l0 padding-lrm-0">
					<input class="form-control order-input" type="text" required="true" placeholder="Имя *" name="name" value="<?php echo $this->userInfo['name']; ?>" maxlength="250" />
					<input class="form-control order-input" type="text" required="true" placeholder="E-mail *" name="email" value="<?php echo $this->user['email']; ?>" maxlength="250" />
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-r0 padding-lrm-0">
					<input class="form-control order-input" type="text" required="true" placeholder="Телефон *" name="phone" value="<?php echo $this->userInfo['phone']; ?>" maxlength="250" />
				</div>
				<br style="clear: both;">
			<?php else : ?>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-l0 padding-lrm-0">
					<input class="form-control order-input" type="text" required="true" placeholder="Название компании *" name="title" value="<?php echo htmlspecialchars($this->userInfo['title']); ?>" maxlength="250" />
					<input class="form-control order-input" type="text" placeholder="ИИН" name="inn" value="<?php echo $this->userInfo['inn']; ?>" maxlength="250" />
					<input class="form-control order-input" type="text" placeholder="КПП" name="kpp" value="<?php echo $this->userInfo['kpp']; ?>" maxlength="250" />
					<textarea class="form-control order-input"  placeholder="Юридический адрес" name="ur_address" rows="4"><?php echo $this->userInfo['ur_address']; ?></textarea>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-r0 padding-lrm-0">
					<input class="form-control order-input" type="text" required="true" placeholder="Контактное лицо *" name="name" value="<?php echo $this->userInfo['name']; ?>" maxlength="250" />
					<input class="form-control order-input" type="text" required="true" placeholder="Телефон *" name="phone" value="<?php echo $this->userInfo['phone']; ?>" maxlength="250" />
					<input class="form-control order-input" type="text" placeholder="E-Mail" name="email" value="<?php echo $this->user['email']; ?>" maxlength="250" />
					<?php if ($this->userType) : ?>
						<label for="dot-addr">Выберите точку доставки заказа:</label>
						<select class="form-control order-input" name="dot-addr" id="dot-addr">
							<?php foreach ($this->userAddrs as $key => $value) : ?>
								<option value="<?php echo $value->id; ?>" <?php if($this->firstAddrId == $value->id) { echo "selected"; } ?>>
									<?php echo $value->address; ?>
								</option>						
							<?php endforeach; ?>
						</select>
					<?php endif; ?>
				</div>
				<br style="clear: both;">
			<?php endif; ?>
		</div>
		<div class="order-block">
			<h3>2. Где и как вы хотите получить заказ *</h3>
				<?php if (!$this->userType) : ?>
					<div class="form-order-check">
						<input class="form-check-input tomauto-order-sel" required="true" checked="checked" type="radio" name="delivery_type" id="del-type-1" value="1" />
						<label class="form-check-label" for="del-type-1">Самовывоз</label>
					</div>
				<?php else : ?>
					<div class="form-order-check">
						<input class="form-check-input tomauto-order-sel" required="true" <?php if (isset($_POST['delivery_type']) && $_POST['delivery_type'] == 1) {
							echo 'checked="checked"';
						} ?> <?php if (!isset($_POST['delivery_type'])) echo 'checked="checked"'; ?> type="radio" name="delivery_type" id="del-type-1" value="1" />
						<label class="form-check-label" for="del-type-1">Самовывоз</label>
					</div>
					<div class="form-order-check">
						<input class="form-check-input tomauto-order-sel" required="true" <?php if (isset($_POST['delivery_type']) && $_POST['delivery_type'] == 2) {
							echo 'checked="checked"';
						} ?> type="radio" name="delivery_type" id="del-type-2" value="2">
						<label class="form-check-label" for="del-type-2">Доставка курьером</label>
					</div>
					<?php if (isset($_POST['delivery_type']) && $_POST['delivery_type'] == 2) {
						$st = "display: block;";
					} else {
						$st = "display: none;";
					} ?>
	                <div class="delivery-schedule" style="<?php echo $st; ?>">
	                    <p><strong>График доставки заказов экспедитором (курьером)</strong></p>
	                    <table>
							<thead>
								<tr>
									<th scope="col">Заявки поступившие</th>
									<th scope="col">Срок выполнения</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>до <?php echo $this->timeToday; ?></td>
									<td>в день подачи</td>
								</tr>
								<tr>
									<td>после <?php echo $this->timeToday; ?></td>
									<td>на следующий рабочий день</td>
								</tr>
							</tbody>
	                    </table>
						<br>						
						<p>Заказы, поступившие <b>после <?php echo $this->timeToday; ?></b>, сумма которых <b>выше <?php echo number_format($this->sumToday, 0, "", " "); ?> руб.</b> могут быть доставлены, 
							по согласованию с вашим менеджером, <b>в тот же день</b>.
						</p>
	                </div>
				<?php endif; ?>
		</div>
		<div class="order-block">
			<h3>3. Как Вам будет удобнее оплатить заказ? *</h3>
			<div class="form-order-check">
				<input class="form-check-input tomauto-order-sel" required="true" <?php if ((isset($_POST['payment_type']) && $_POST['payment_type'] == 1) || !isset($_POST['payment_type'])) {
					echo 'checked="checked"';
				} ?> type="radio" name="payment_type" id="payment-type-1" value="1">
				<label class="form-check-label" for="payment-type-1">Наличными</label>
			</div>
			<div class="form-order-check">
				<input class="form-check-input tomauto-order-sel" required="true" <?php if ((isset($_POST['payment_type']) && $_POST['payment_type'] == 2) || !isset($_POST['payment_type'])) {
					echo 'checked="checked"';
				} ?> type="radio" name="payment_type" id="payment-type-2" value="2">
				<label class="form-check-label" for="payment-type-2">Безналичный расчёт</label>
			</div>			
		</div>
		<div class="goods-block">
			<table class="hidden-xs">
				<thead>
					<tr>
						<th class="col-name">Наименование товара</th>
						<th class="col-price">Цена</th>
						<th class="col-count">Количество</th>
						<th class="col-summ">Сумма</th>
					</tr>
				</thead>
				<tbody id="order-sale">
					<tr>
						<td colspan="4">
							<img class="loading-warehouse" src="/themes/default/responsiveDesign/images/loader-front.webp" />
						</td>
					</tr>
				</tbody>
			</table>
			<table class="visible-xs-block basket-m">
				<tbody id="order-sale-mobile">
					<tr>
						<td colspan="2">
							<img class="loading-warehouse" src="/themes/default/responsiveDesign/images/loader-front.webp" />
						</td>
					</tr>
				</tbody>
			</table>
			<div id="total-sum-block"></div>
		</div>
		<p>
			Нажимая кнопку "Оформить заказ"
			<br>Вы принимаете условия <a class="privacy" target="_blank" href="/privacy-policy/">Политики конфиденциальности</a>.				
		</p>
		<input class="order-submit" type="submit" value="Подтвердить заказ">
	</form>
</div>