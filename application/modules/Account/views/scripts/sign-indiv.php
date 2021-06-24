<?php

function printErrors($errors) {
    if (!empty($error)) :
        ?>
        <div class="error-list">
            <ul>
                <?php foreach ($error as $keyError => $valueError) : ?>
                    <li><?php echo $valueError; ?></li>
        <?php endforeach; ?>
            </ul>
        </div>
        <?php
    endif;
}
?>
<div id="reg-individual">
    <p><strong>Заполнение анкеты для заключения договора физическим лицом</strong></p>
    <p>Просим Вас при заполнении анкеты использовать информацию, которая в случае необходимости может быть подтверждена документально.</p>
    <p>Знаком <span class="orandzh">*</span> отмечены обязательные для заполнения поля</p>
    <form method="post" action="/account/signup/1/">
        <input type="hidden" name="type" value="0" />
        <input type="hidden" name="active" value="1" />
        <input type="hidden" name="access" value="1" />
        <div class="form-group">
            <input type="text" name="login" id="login" value="" required="true" placeholder="Логин*" class="form-control mask-login">
			<div class="field-info"></div>
            <?php //echo $this->user->login; ?>
            <?php printErrors($this->user->login->getMessages()); ?>
        </div>
        <div class="form-group">
            <input type="text" name="email" id="email" value="" required="true" placeholder="E-mail*" class="form-control mask-email">
			<div class="field-info"></div>
            <?php //echo $this->user->email; ?>
            <?php printErrors($this->user->email->getMessages()); ?>            
        </div>
        <div class="form-group">
            <input type="text" name="name" id="name" value="" required="true" placeholder="Контактное лицо*" class="form-control">
            <?php //echo $this->info->name; ?>
            <?php printErrors($this->info->name->getMessages()); ?>   
        </div>
        <div class="form-group">
            <input type="text" name="address" id="address" value="" required="true"  placeholder="Адрес*" class="form-control">
            <?php //echo $this->info->address;  ?>
        </div>
        <div class="form-group">
            <input type="text" name="phone" id="phone" value="" required="true"  placeholder="Телефон*" class="form-control mask-phone">
            <?php //echo $this->info->phone; ?>
            <?php printErrors($this->info->phone->getMessages()); ?>
        </div>
        <div class="form-group">
            <textarea class="form-control" name="info" id="info" rows="5" cols="20" class="input-long" placeholder="Дополнительная информация*"></textarea>
            <?php //echo $this->info->info;  ?>
            <p>Вы можете указать марку Вашего автомобиля, ДВС, КПП, VIN.</p>
            <?php printErrors($this->info->info->getMessages()); ?>
        </div>
        <div class="form-group">
            <p>Выберите пароль, который Вы будете использовать для доступа в раздел "Для клиентов" для заказа и настройки услуг:</p>
            <input type="password" name="password" id="password" value="" required="true"  placeholder="Пароль*" class="form-control">
            <?php //echo $this->user->password; ?>
            <?php printErrors($this->user->password->getMessages()); ?>
        </div>
        <div class="form-group">
            <input type="password" name="verifypassword" id="verifypassword" value="" required="true"  placeholder="Повтор пароля*" class="form-control">
            <?php //echo $this->user->verifypassword; ?>
            <?php printErrors($this->user->verifypassword->getMessages()); ?>
            <p>Разрешается использовать только латинские буквы и цифры.</p>
        </div>
        <input type="submit" id="submit-indiv" class="send-form" value="Отправить" />
    </form>
</div>