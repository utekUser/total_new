<div id="order-history">
	<p class="hello-world">На этой странице Вы можете посмотреть историю и отследить состояние (статус) Ваших заказов.</p>
	<?php if (sizeof($this->orders)) : ?>
		<div class="hidden-xs">
			<div class="row-fluid history-title">
				<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">№ заказа</div>
				<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">Дата заказа</div>
				<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">Дата отправки</div>
				<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">Доставка</div>
				<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">Оплата</div>
				<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">Сумма</div>
			</div>
		</div>
		<?php foreach ($this->orders as $order) : ?>
			<div class="hidden-xs">
				<div class="row-fluid order-block">
					<div class="row-fluid history-order plus-minus-order" id="<?php echo $order['id']; ?>">
						<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs order-number">№&nbsp;<?php echo $order['id']; ?></div>
						<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs"><?php echo $this->Date($order['date'], 'slash'); ?></div>
						<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">
							<?php if ($order['status_id'] == "3") : ?>
								<?php echo $this->Date($order['modified'], 'slash'); ?>
							<?php endif; ?>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs"><?php echo $this->delivetyList[$order['delivery_type']]; ?></div>
						<div class="col-lg-1 col-md-1 col-sm-1 hidden-xs"><?php echo $this->paymentList[$order['payment_type']]; ?></div>
						<div class="col-lg-3 col-md-3 col-sm-3 padding0 hidden-xs">
							<div class="col-lg-10 col-md-10 col-sm-10 order-number aright"><?php echo number_format($order['total_sum'], 0, '.', ' '); ?> руб.</div>
							<div class="col-lg-2 col-md-2 col-sm-2">
								<img id="img-<?php echo $order['id']; ?>" src="/themes/default/responsiveDesign/images/order-plus.webp" title="Показать товары заказа" />
							</div>
						</div>
					</div>
					<div class="order-info" id="order-info-<?php echo $order['id']; ?>">
						<?php $allAmount = 0;
						if (sizeof($this->orderInfo[$order['id']])) : ?>
							<table>
								<thead>
									<tr>
										<th class="good-name">Наименование \ номер</th>
										<th>Цена, руб</th>
										<th>Заказано</th>
										<th>Статус</th>
										<?php /* <th>Склад</th> */ ?>
										<th>Сумма, руб</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($this->orderInfo[$order['id']] as $orderInfo) : ?>
										<?php $allAmount = $allAmount + $orderInfo['amount']; ?>
										<tr>
											<td class="good-name"><?php echo $orderInfo['name']; ?></td>
											<td><?php echo number_format($orderInfo['price'], 0, '.', ' '); ?> руб.</td>
											<td><?php echo $orderInfo['amount']; ?></td>
											<td><?php echo $this->statusList[$order['status_id']]['name']; ?></td>
											<?php /* <td><?php if ($order['warehouse_type'] == "1" | $order['warehouse_type'] == "0") : ?>
												Тверская 18
												<?php elseif ($order['warehouse_type'] == "2") : ?>
												Томскснаб
												<?php elseif ($order['warehouse_type'] == "3") : ?>
												Томскснаб-Фильтра
												<?php endif; ?>
											</td> */ ?>
											<td><?php echo number_format($orderInfo['price'] * $orderInfo['amount'], 0, '.', ' '); ?> руб.</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						<?php endif; ?>
						<div class="row-fluid">
							<div class="col-lg-4 col-md-1 col-sm-1">
								<a class="repeat-order" href="/control/repeatorder/<?php echo $order['id']; ?>/" id="repeat-order-<?php echo $order['id']; ?>">Повторить заказ</a>
							</div>
							<div class="col-lg-2 col-md-1 col-sm-1"></div>
							<div class="col-lg-6 col-md-9 col-sm-9">
								<div class="col-lg-4 col-md-4 col-sm-4 aright wbold">ИТОГО: </div>
								<div class="col-lg-4 col-md-4 col-sm-4 aright wbold"><?php echo $allAmount; ?> шт.</div>
								<div class="col-lg-4 col-md-4 col-sm-4 aright wbold"><?php echo number_format($order['total_sum'], 0, '.', ' '); ?> руб.</div>							
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="visible-xs-block">
				<div class="row order-block">
					<div class="col-xs-5">
						<p>№ заказа</p>
						<p>Дата заказа</p>
						<p>Дата отправки</p>
						<p>Доставка</p>
						<p>Оплата</p>
						<p>Сумма</p>
					</div>
					<div class="col-xs-6 padding-lrm-0">
						<p><b>№&nbsp;<?php echo $order['id']; ?></b></p>
						<p><?php echo $this->Date($order['date'], 'slash'); ?></p>
						<p>
							<?php if ($order['status_id'] == "3") : ?>
								<?php echo $this->Date($order['modified'], 'slash'); ?>
							<?php else : ?>
								&nbsp;
							<?php endif; ?>
						</p>
						<p><?php echo $this->delivetyList[$order['delivery_type']]; ?></p>
						<p><?php echo $this->paymentList[$order['payment_type']]; ?></p>
						<p><b><?php echo number_format($order['total_sum'], 0, '.', ' '); ?> руб.</b></p>
					</div>
					<div class="col-xs-1 padding-lrm-0 order-img">
						<img class="order-show-m" id="img-m-<?php echo $order['id']; ?>" src="/themes/default/responsiveDesign/images/order-plus.webp" title="Показать товары заказа" />
					</div>
					<div class="col-xs-12 order-info-block" id="order-info-m-<?php echo $order['id']; ?>">
						<?php $allAmount = 0;
						if (sizeof($this->orderInfo[$order['id']])) : ?>
							<?php foreach ($this->orderInfo[$order['id']] as $orderInfo) : ?>
								<?php $allAmount = $allAmount + $orderInfo['amount']; ?>
								<div class="order-one-good">
									<h5><?php echo $orderInfo['name']; ?></h5>
									<div class="info">
										<div class="col-xs-6 padding-lrm-0"><p>Цена, руб:</p></div>
										<div class="col-xs-6 padding-lrm-0"><p><?php echo number_format($orderInfo['price'], 0, '.', ' '); ?> руб.</p></div>
									</div>
									<div class="info">
										<div class="col-xs-6 padding-lrm-0"><p>Заказано:</p></div>
										<div class="col-xs-6 padding-lrm-0"><p><?php echo $orderInfo['amount']; ?></p></div>
									</div>
									<div class="info">
										<div class="col-xs-6 padding-lrm-0"><p>Статус:</p></div>
										<div class="col-xs-6 padding-lrm-0"><p><?php echo $this->statusList[$order['status_id']]['name']; ?></p></div>
									</div>
									<?php /* <div class="info">
										<div class="col-xs-6 padding-lrm-0"><p>Склад:</p></div>
										<div class="col-xs-6 padding-lrm-0">
											<p>
											<?php if ($order['warehouse_type'] == "1" | $order['warehouse_type'] == "0") : ?>
												Тверская 18
											<?php elseif ($order['warehouse_type'] == "2") : ?>
												Томскснаб
											<?php elseif ($order['warehouse_type'] == "3") : ?>
												Томскснаб-Фильтра
											<?php endif; ?>
											</p>
										</div>
									</div> */ ?>
									<div class="info">
										<div class="col-xs-6 padding-lrm-0"><p>Сумма, руб:</p></div>
										<div class="col-xs-6 padding-lrm-0"><p><?php echo number_format($orderInfo['price'] * $orderInfo['amount'], 0, '.', ' '); ?> руб.</p></div>
									</div>
								</div>
							<?php endforeach; ?>	
						<?php endif; ?>
						<div class="row-fluid">
							<div class="col-xs-3 padding-lrm-0 wbold"><p>ИТОГО:</p></div>
							<div class="col-xs-3 aright wbold"><p><?php echo $allAmount; ?> шт.</p></div>
							<div class="col-xs-6 padding-lrm-0 aright wbold"><p><?php echo number_format($order['total_sum'], 0, '.', ' '); ?> руб.</p></div>							
						</div>
						<div class="row-fluid">
							<a class="repeat-order" href="/control/repeatorder/<?php echo $order['id']; ?>/" id="repeat-order-mobile-<?php echo $order['id']; ?>">Повторить заказ</a>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>    		
	<?php endif; ?>
</div>