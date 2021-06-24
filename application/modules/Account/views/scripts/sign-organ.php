<?php 

function printErrorsU($errors) {
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
<div id="reg-organizational">
    <p><strong>Заполнение анкеты для заключения договора юридическим лицом</strong></p>
    <p>Просим Вас при заполнении анкеты использовать информацию, которая в случае необходимости может быть подтверждена документально.</p>
    <p>Знаком <span class="orandzh">*</span> отмечены обязательные для заполнения поля</p>
    <form method="post" action="/account/signup/2/">
        <input type="hidden" name="type" value="1" />
        <input type="hidden" name="active" value="1" />
        <input type="hidden" name="access" value="0" />
        <div class="form-group login-input">
            <input type="text" name="login" id="login-o" value="" required="true"  placeholder="Логин*" class="form-control mask-login">
			<div class="field-info"></div>
            <?php //echo $this->user->login; ?>
            <?php printErrorsU($this->user->login->getMessages()); ?>
        </div>
        <div class="form-group login-input">
            <input type="text" name="email" id="email-o" value="" required="true"  placeholder="E-mail*" class="form-control mask-email">
			<div class="field-info"></div>
            <?php //echo $this->user->email; ?>
            <?php printErrorsU($this->user->email->getMessages()); ?>
        </div>
        <div class="form-group login-input">
            <input type="text" name="name" id="name-o" value="" required="true"  placeholder="Контактное лицо*" class="form-control">
            <?php //echo $this->info->name; ?>
            <?php printErrorsU($this->info->name->getMessages()); ?>
        </div>
        <div class="form-group login-input">
            <input type="text" name="phone" id="phone-o" value="" required="true"  placeholder="Телефон*" class="form-control mask-phone">
            <?php //echo $this->info->phone; ?>
            <?php printErrorsU($this->info->phone->getMessages()); ?>
        </div>
        <h2 class="second-title">Реквизиты</h2>            
        <div class="form-group login-input">
            <input type="text" name="title" id="title" value="" required="true"  placeholder="Наименование организации*" class="form-control">
            <?php //echo $this->info->title; ?>
            <?php printErrorsU($this->info->title->getMessages()); ?>
        </div>
        <div class="form-group login-input">
            <input type="text" name="ur_address" id="ur_address" value="" required="true"  placeholder="Юридический адрес*" class="form-control">
            <?php //echo $this->info->ur_address; ?>
            <?php printErrorsU($this->info->ur_address->getMessages()); ?>
        </div>
        <?php /* <div class="form-group login-input">
            <input type="text" name="fact_address" id="fact_address" value="" required="true"  placeholder="Фактический адрес*" class="form-control">
            <?php //echo $this->info->fact_address; ?>
            <?php printErrorsU($this->info->fact_address->getMessages()); ?>
        </div> */ ?>
		<div class="form-group">
            <input class="tomauto-sel" type="checkbox" id="ip" name="ip" value="1">
            <label for="ip">Индивидуальные предприниматель</label>
        </div>
        <div class="form-group login-input">
            <input type="text" name="ogrn" id="ogrn" value="" required="true"  placeholder="ОГРН*" class="form-control mask-ogrn">
            <?php //echo $this->info->ogrn; ?>
            <?php printErrorsU($this->info->ogrn->getMessages()); ?>
        </div>
        <div class="form-group login-input">
            <input type="text" name="inn" id="inn-o" value="" required="true"  placeholder="ИНН*" class="form-control mask-inn-organization">
			<div class="field-info"></div>
            <?php //echo $this->info->inn; ?>
            <?php printErrorsU($this->info->inn->getMessages()); ?>
        </div>
        <div class="form-group login-input">
            <input type="text" name="bank" id="bank" value="" required="true"  placeholder="Банк*" class="form-control">
            <?php //echo $this->info->bank; ?>
            <?php printErrorsU($this->info->bank->getMessages()); ?>
        </div>
        <div class="form-group login-input">
            <input type="text" name="kpp" id="kpp" value="" required="true"  placeholder="КПП*" class="form-control mask-kpp">
            <?php //echo $this->info->kpp; ?>
            <?php printErrorsU($this->info->kpp->getMessages()); ?>
        </div>
        <div class="form-group login-input">
            <input type="text" name="rs" id="rs" value="" required="true"  placeholder="Р/С*" class="form-control mask-account">
            <?php //echo $this->info->rs; ?>
            <?php printErrorsU($this->info->rs->getMessages()); ?>
        </div>
        <div class="form-group login-input">
            <input type="text" name="ks" id="ks" value="" required="true"  placeholder="КС*" class="form-control">
            <?php //echo $this->info->ks; ?>
            <?php printErrorsU($this->info->ks->getMessages()); ?>
        </div>
        <div class="form-group login-input">
            <input type="text" name="bik" id="bik" value="" required="true"  placeholder="БИК*" class="form-control mask-bik">
            <?php //echo $this->info->bik; ?>
            <?php printErrorsU($this->info->bik->getMessages()); ?>
        </div>
        <div class="form-group login-input">
            <input type="text" name="okpo" id="okpo" value="" required="true"  placeholder="ОКПО*" class="form-control">
            <?php //echo $this->info->okpo; ?>
            <?php printErrorsU($this->info->okpo->getMessages()); ?>
        </div>
        <div class="form-group login-input">
            <textarea class="form-control" name="info" id="info-o" rows="5" cols="20" class="input-long" placeholder="Дополнительная информация*"></textarea>
            <?php //echo $this->info->info; ?>
            <?php printErrorsU($this->info->info->getMessages()); ?>
        </div>
		<h2 class="second-title">Адреса точек доставки</h2>
		<div class="form-group login-input over-addr">
			<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 dot-addr">
				<input type="text" name="dot-address[]" id="address-1" value="" required="true" placeholder="Адрес доставки*" class="form-control">
				<?php //echo $this->info->okpo; ?>
				<?php printErrorsU($this->address->address->getMessages()); ?>
			</div>
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 add-address">
				<img id="add-address-img" class="add-address-img" alt="Добавить ещё один адрес" title="Добавить ещё один адрес"  src="/themes/default/responsiveDesign/images/plus-addr.webp">
			</div>
        </div>
		<div id="new-address-div"></div>
        <div class="form-group login-input">			
            <p>Выберите пароль, который Вы будете использовать для доступа в раздел "Для клиентов" для заказа и настройки услуг:</p>
            <input type="password" name="password" id="password-o" value="" required="true"  placeholder="Пароль*" class="form-control">
            <?php //echo $this->user->password; ?>
            <?php printErrorsU($this->user->password->getMessages()); ?>
        </div>
        <div class="form-group login-input">
            <input type="password" name="verifypassword" id="verifypassword-o" value="" required="true"  placeholder="Повтор пароля*" class="form-control">
            <?php //echo $this->user->verifypassword; ?>
            <?php printErrorsU($this->user->verifypassword->getMessages()); ?>
            <p>Разрешается использовать только латинские буквы и цифры.</p>
        </div> 
        <input type="submit" id="submit" class="send-form" value="Отправить" />
    </form>
</div>