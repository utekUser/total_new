<div class="path">
    <a href="/"><img alt="" src="/themes/default/images/house.png" /></a>
    <a href="/control/">Личный кабинет</a>
    <a href="/control/history/">История заказов</a>
    <span>Заказ от <?php echo $this->orderinfo['date']; ?></span>
</div>
<br/>
<h2 class="h2-black">Заказ от <?php echo $this->orderinfo['date']; ?></h2>
<table width="100%" cellspacing="0" class="order-properties">
    <thead>
        <tr>
            <th colspan="2">
                Наименование товара
            </th>
            <th>
                Количество
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th class="field-title" colspan="3">Масла</th>
        </tr>
        <?php foreach($this->orderinfo['oils'] as $key => $value) { ?>
        <tr>
            <td colspan="2"><?php echo $value['name']; ?></td>
            <td><?php echo $value['count']; ?></td>
        </tr>
        <?php } ?>
        <tr>
            <th class="field-title" colspan="3">Фильтра</th>
        </tr>
        <?php /*print_r($this->orderinfo);*/ foreach($this->orderinfo['filters'] as $key => $value) { ?>
        <tr>
            <td colspan="2"><?php echo $value['name']; ?></td>
            <td><?php echo $value['count']; ?></td>
        </tr>
        <?php } ?>
        <tr>
            <th class="field-title" colspan="3">Свечи зажигания</th>
        </tr>
        <?php foreach($this->orderinfo['plugs'] as $key => $value) { ?>
        <tr>
            <td colspan="2"><?php echo $value['name']; ?></td>
            <td><?php echo $value['count']; ?></td>
        </tr>
        <?php } ?>
		<tr>
            <th class="field-title" colspan="3">Автозапчасти</th>
        </tr>
        <?php foreach($this->orderinfo['autoparts'] as $key => $value) { ?>
        <tr>
            <td colspan="2"><?php echo $value['name']; ?></td>
            <td><?php echo $value['count']; ?></td>
        </tr>
        <?php } ?>
		<tr>
            <th class="field-title" colspan="3">Coolstream</th>
        </tr>
        <?php foreach($this->orderinfo['coolstream'] as $key => $value) { ?>
        <tr>
            <td colspan="2"><?php echo $value['name']; ?></td>
            <td><?php echo $value['count']; ?></td>
        </tr>
        <?php } ?>
		<tr>
            <th class="field-title" colspan="3">Efele</th>
        </tr>
        <?php foreach($this->orderinfo['efele'] as $key => $value) { ?>
        <tr>
            <td colspan="2"><?php echo $value['name']; ?></td>
            <td><?php echo $value['count']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<a style="float: left; margin-right: 25px;" class="add-to-bask" href="/control/history/savedorder/<?php echo $this->sessId; ?>/tobasket/">Поместить предзаказ в корзину</a>
<a style="float: left;" class="delete-item" href="/control/history/savedorder/<?php echo $this->sessId; ?>/delete/">Удалить предзаказ</a>


