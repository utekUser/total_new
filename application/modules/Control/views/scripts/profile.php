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
<div id="control-profile">
    <p>В данном разделе Вы можете изменять свои личные данные</p>
    <?php if ($this->success) : ?>
        <div class="error-list">
            <?php echo $this->success; ?>
        </div>
    <?php endif; ?>
    <form method="post" action="/control/profile/">
        <div class="row-fluid">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-l0 padding-lrm-0">
                <div class="profile-block">                    
                    <h3 class="profile-block-title">Статус покупателя</h3>
                    <div class="form-check">
                        <input class="form-check-input tomauto-sel" type="radio" name="account-type" id="fiz-lico" value="1" <?php echo ($this->user['type'] == "0" ? "checked" : ""); ?>>
                        <label class="form-check-label" for="account-type">Физическое лицо</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input tomauto-sel" type="radio" name="account-type" id="ur-lico" value="2" <?php echo ($this->user['type'] == "1" ? "checked" : ""); ?>>
                        <label class="form-check-label" for="account-type">Юридическое лицо</label>
                    </div>
                    <p>Для изменения Вашего статуса обратитесь в магазин "Томавтотрейд".</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-r0 padding-lrm-0">
                <div class="profile-block"> 
                    <h3 class="profile-block-title">Контакты</h3>
                    <div class="form-group row-fluid profile-input">
                        <label for="email" class="col-sm-4 col-form-label">E-mail:</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" name="email" id="email" value="<?php echo $this->user['email']; ?>">
                            <?php printErrors($this->userA->email->getMessages()); ?>
                        </div>
                    </div>
                    <div class="form-group row-fluid profile-input">
                        <label for="name" class="col-sm-4 col-form-label">Контактное имя:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control-plaintext" name="name" id="name" value="<?php echo $this->info['name']; ?>">
                            <?php printErrors($this->infoA->name->getMessages()); ?>
                        </div>
                    </div>
                    <div class="form-group row-fluid profile-input">
                        <label for="phone" class="col-sm-4 col-form-label">Телефон:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control-plaintext" name="phone" id="phone" value="<?php echo $this->info['phone']; ?>">
                            <?php printErrors($this->infoA->phone->getMessages()); ?>
                        </div>
                    </div>
                    <input type="submit" class="safe-changes" value="Сохранить" />
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-l0 padding-lrm-0">
                <div class="profile-block"> 
                    <h3 class="profile-block-title">Логин и пароль</h3>
                    <div class="form-group row-fluid profile-input">
                        <label for="login" class="col-sm-4 col-form-label">Логин:</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" name="login" id="login" value="<?php echo $this->user['login']; ?>">
                            <?php printErrors($this->userA->login->getMessages()); ?>
                        </div>
                    </div>
                    <div class="form-group row-fluid profile-input">
                        <label for="password" class="col-sm-4 col-form-label">Новый пароль:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control-plaintext" name="password" id="password" value="">
                        </div>
                    </div>
                    <div class="form-group row-fluid profile-input">
                        <label for="verifypassword" class="col-sm-4 col-form-label">Подтверждение пароля:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control-plaintext" name="verifypassword" id="verifypassword" value="">
                        </div>
                    </div>
                    <input type="submit" class="safe-changes" value="Изменить пароль" />
                </div>
				<?php if ($this->user['type'] == "1") : ?>
					<div class="profile-block"> 
						<h3 class="profile-block-title">Адреса точек доставки</h3>
						<?php $i = 1; foreach ($this->userAddr as $key => $value) : ?>
							<div id="dot-block-<?php echo $value["id"]; ?>">
								<div class="form-group row-fluid profile-input dot-address">
									<label for="dot-address" class="col-sm-4 col-form-label">Адрес доставки:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control-plaintext ajax-send-addr" name="dot-address[<?php echo $value["id"]; ?>]" 
											id="dot-address-<?php echo $value["id"]; ?>" value="<?php echo $value["address"]; ?>">								
									</div>								
								</div>
								<div class="div-del-address">
									<a id="upd-address-<?php echo $value["id"]; ?>" class="upd-address-link">Адрес обновлён</a>
									<a id="del-address-<?php echo $value["id"]; ?>" class="del-address-link" href="#" title="Удалить точку доставки">Удалить</a>	
									<hr/>
								</div>
							</div>
						<?php $i++; endforeach; ?>
						<div id="new-dots"></div>
						<div class="div-add-address">
							<a id="a-add-address" class="add-address-link" href="#" title="Добавить точку доставки">Добавить новый адрес</a>
						</div>
						<?php /* <input type="submit" class="safe-changes" value="Сохранить" /> */ ?>
					</div>
				<?php endif;; ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-r0 padding-lrm-0">
                <div class="profile-block"> 
                    <h3 class="profile-block-title">Реквизиты</h3>
                    <?php if ($this->user['type'] == "1") : ?>
                        <div class="form-group row-fluid profile-input">
                            <label for="title" class="col-sm-4 col-form-label">Наименование организации:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control-plaintext" name="title" id="title" value="<?php echo $this->info['title']; ?>">
                                <?php printErrors($this->infoA->title->getMessages()); ?>
                            </div>
                        </div>
                        <div class="form-group row-fluid profile-input">
                            <label for="ur_address" class="col-sm-4 col-form-label">Юридический адрес:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control-plaintext" name="ur_address" id="ur_address" value="<?php echo $this->info['ur_address']; ?>">
                                <?php printErrors($this->infoA->ur_address->getMessages()); ?>
                            </div>
                        </div>
                        <?php /* <div class="form-group row-fluid profile-input">
                            <label for="fact_address" class="col-sm-4 col-form-label">Фактический адрес (доставка по умолчанию):</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control-plaintext" name="fact_address" id="fact_address" value="<?php echo $this->info['fact_address']; ?>">
                                <?php printErrors($error = $this->infoA->fact_address->getMessages()); ?>
                            </div>
                        </div> */ ?>
                        <div class="form-group row-fluid profile-input">
                            <label for="inn" class="col-sm-4 col-form-label">ИНН:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control-plaintext" name="inn" id="inn" value="<?php echo $this->info['inn']; ?>">
                                <?php printErrors($error = $this->infoA->inn->getMessages()); ?>
                            </div>
                        </div>
                        <div class="form-group row-fluid profile-input">
                            <label for="ogrn" class="col-sm-4 col-form-label">ОГРН:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control-plaintext" name="ogrn" id="ogrn" value="<?php echo $this->info['ogrn']; ?>">
                                <?php printErrors($error = $this->infoA->ogrn->getMessages()); ?>
                            </div>
                        </div>
                        <div class="form-group row-fluid profile-input">
                            <label for="kpp" class="col-sm-4 col-form-label">КПП:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control-plaintext" name="kpp" id="kpp" value="<?php echo $this->info['kpp']; ?>">
                                <?php printErrors($error = $this->infoA->kpp->getMessages()); ?>
                            </div>
                        </div>
                        <div class="form-group row-fluid profile-input">
                            <label for="bank" class="col-sm-4 col-form-label">Банк:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control-plaintext" name="bank" id="bank" value="<?php echo $this->info['bank']; ?>">
                                <?php printErrors($error = $this->infoA->bank->getMessages()); ?>
                            </div>
                        </div>
                        <div class="form-group row-fluid profile-input">
                            <label for="rs" class="col-sm-4 col-form-label">Р/С:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control-plaintext" name="rs" id="rs" value="<?php echo $this->info['rs']; ?>">
                                <?php printErrors($error = $this->infoA->rs->getMessages()); ?>
                            </div>
                        </div>
                        <div class="form-group row-fluid profile-input">
                            <label for="ks" class="col-sm-4 col-form-label">КС:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control-plaintext" name="ks" id="ks" value="<?php echo $this->info['ks']; ?>">
                                <?php printErrors($error = $this->infoA->ks->getMessages()); ?>
                            </div>
                        </div>
                        <div class="form-group row-fluid profile-input">
                            <label for="bik" class="col-sm-4 col-form-label">БИК:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control-plaintext" name="bik" id="bik" value="<?php echo $this->info['bik']; ?>">
                                <?php printErrors($error = $this->infoA->bik->getMessages()); ?>
                            </div>
                        </div>
                        <div class="form-group row-fluid profile-input">
                            <label for="okpo" class="col-sm-4 col-form-label">ОКПО:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control-plaintext" name="okpo" id="okpo" value="<?php echo $this->info['okpo']; ?>">
                                <?php printErrors($error = $this->infoA->okpo->getMessages()); ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="form-group row-fluid profile-input">
                            <label for="address" class="col-sm-4 col-form-label">Адрес:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control-plaintext" name="address" id="address" value="<?php echo $this->info['address']; ?>">
                                <?php printErrors($error = $this->infoA->address->getMessages()); ?>
                            </div>
                        </div>
                        <?php echo $this->infoA->address; ?>
                    <?php endif; ?>
                    <div class="form-group row-fluid profile-input">
                        <label for="info" class="col-sm-4 col-form-label">Дополнительная информация:</label>
                        <div class="col-sm-8">
                            <textarea class="form-control-plaintext" cols="20" rows="5" name="info"><?php echo $this->info['info']; ?></textarea>
                        </div>
                    </div>
                    <input type="submit" class="safe-changes" value="Сохранить" />
                </div>
            </div>		
        </div>
    </form>
</div>
<?php /* ?>
<div class="path">
    <a href="/"><img alt="" src="/themes/default/images/house.png" /></a>
    <a href="/control/">Личный кабинет</a>
    <span>Личные данные</span>
</div>
<h1>Личные данные</h1>
<div class="">Просим Вас при заполнении анкеты использовать информацию, которая в случае необходимости может быть
    подтверждена документально.<br /><br />
    Знаком <span class="orandzh">*</span> отмечены обязательные для заполнения поля.
</div>


<form method="post" action="/control/profile/">
    <div class="private-profile">
        <div class="grey-corner-m">

            <div class="form-field">
                <div class="field-data">
                    <span>Логин </span><span class="orandzh">*</span>
                </div>
                <div class="input-field">
                    <input readonly="readonly" class="disabled" type="text" value="<?php echo $this->user['login']; ?>"
                           name="login" />
                </div>
            </div>
            <?php
            $error = $this->userA->login->getMessages();
            if (!empty($error)) {
                ?>
                <div class="error-list"><ul>
                <?php foreach ($error as $keyError => $valueError) { ?> <li><?php echo $valueError; ?></li><?php } ?>
                    </ul></div>
<?php } ?>

            <div class="form-field">
                <div class="field-data">
                    <span>Электронная почта </span><span class="orandzh">*</span>
                </div>
                <div class="input-field input-middle"><input readonly="readonly" class="disabled" type="text" value="<?php echo $this->user['email']; ?>" name="email" /></div>
            </div>
            <?php
            $error = $this->userA->email->getMessages();
            if (!empty($error)) {
                ?>
                <div class="error-list"><ul>
                <?php foreach ($error as $keyError => $valueError) { ?> <li><?php echo $valueError; ?></li><?php } ?>
                    </ul></div>
<?php } ?>

            <div class="form-field">
                <div class="field-data">
                    <span>Контактное имя </span><span class="orandzh">*</span>
                </div>
                <div class="input-field input-middle"><input type="text" value="<?php echo $this->info['name']; ?>"
                                                             name="name" /></div>
            </div>
            <?php
            $error = $this->infoA->name->getMessages();
            if (!empty($error)) {
                ?>
                <div class="error-list"><ul>
                <?php foreach ($error as $keyError => $valueError) { ?> <li><?php echo $valueError; ?></li><?php } ?>
                    </ul></div>
<?php } ?>

            <div class="form-field">
                <div class="field-data">
                    <span>Телефон </span><span class="orandzh">*</span>
                </div>
                <div class="input-field input-middle"><input type="text" value="<?php echo $this->info['phone']; ?>"
                                                             name="phone" /></div>
            </div>
            <?php
            $error = $this->infoA->phone->getMessages();
            if (!empty($error)) {
                ?>
                <div class="error-list"><ul>
                <?php foreach ($error as $keyError => $valueError) { ?> <li><?php echo $valueError; ?></li><?php } ?>
                    </ul></div>
            <?php } ?>

<?php if ($this->user['type']) { ?>
                <div class="almost-h2">Реквизиты</div>
                <div class="form-field">
                    <div class="field-data">
                        <span>Наименование организации </span><span
                            class="orandzh">*</span>
                    </div>
                    <div class="input-field input-middle"><?php echo $this->infoA->title; ?></div>
                </div>
                <?php
                $error = $this->infoA->title->getMessages();
                if (!empty($error)) {
                    ?>
                    <div class="error-list"><ul>
                    <?php foreach ($error as $keyError => $valueError) { ?> <li><?php echo $valueError; ?></li><?php } ?>
                        </ul></div>
    <?php } ?>

                <div class="form-field">
                    <div class="field-data">
                        <span>Юридический адрес </span><span class="orandzh">*</span>
                    </div>
                    <div class="input-field input-middle"><?php echo $this->infoA->ur_address; ?></div>
                </div>
                <?php
                $error = $this->infoA->ur_address->getMessages();
                if (!empty($error)) {
                    ?>
                    <div class="error-list"><ul>
                    <?php foreach ($error as $keyError => $valueError) { ?> <li><?php echo $valueError; ?></li><?php } ?>
                        </ul></div>
    <?php } ?>

                <div class="form-field">
                    <div class="field-data">
                        <span>Фактический адрес (адрес доставки по умолчанию) </span><span
                            class="orandzh">*</span>
                    </div>
                    <div class="input-field input-middle"><input type="text" value="<?php echo $this->info['fact_address']; ?>" name="fact_address" /></div>
                </div>
                <?php
                $error = $this->infoA->fact_address->getMessages();
                if (!empty($error)) {
                    ?>
                    <div class="error-list"><ul>
                    <?php foreach ($error as $keyError => $valueError) { ?> <li><?php echo $valueError; ?></li><?php } ?>
                        </ul></div>
    <?php } ?>

                <div class="form-field">
                    <div class="field-data">
                        <span>ОГРН</span>
                    </div>
                    <div class="input-field input-middle"><input type="text" value="<?php echo $this->info['ogrn']; ?>" name="ogrn" /></div>
                </div>
                <div class="form-field">
                    <div class="field-data">
                        <span>ИНН </span><span class="orandzh">*</span>
                    </div>
                    <div class="input-field input-middle">
                        <?php echo $this->infoA->inn; ?>
    <?php /* ?><input type="text" value="<?php echo $this->info['inn']; ?>" name="inn" /><?php * ?>
                    </div>
                </div>
                <?php
                $error = $this->infoA->inn->getMessages();
                if (!empty($error)) {
                    ?>
                    <div class="error-list"><ul>
                    <?php foreach ($error as $keyError => $valueError) { ?> <li><?php echo $valueError; ?></li><?php } ?>
                        </ul></div>
    <?php } ?>

                <div class="form-field">
                    <div class="field-data">
                        <span>Банк</span>
                    </div>
                    <div class="input-field input-middle"><input type="text" value="<?php echo $this->info['bank']; ?>" name="bank" /></div>
                </div>
                <div class="form-field">
                    <div class="field-data">
                        <span>КПП</span>
                    </div>
                    <div class="input-field input-middle"><input type="text" value="<?php echo $this->info['kpp']; ?>" name="kpp" /></div>
                </div>
                <div class="form-field">
                    <div class="field-data">
                        <span>Р/С</span>
                    </div>
                    <div class="input-field input-middle"><input type="text" value="<?php echo $this->info['rs']; ?>" name="rs" /></div>
                </div>
                <div class="form-field">
                    <div class="field-data">
                        <span>КС</span>
                    </div>
                    <div class="input-field input-middle"><input type="text" value="<?php echo $this->info['ks']; ?>" name="ks" /></div>
                </div>
                <div class="form-field">
                    <div class="field-data">
                        <span>БИК</span>
                    </div>
                    <div class="input-field input-middle"><input type="text" value="<?php echo $this->info['bik']; ?>" name="bik" /></div>
                </div>
                <div class="form-field">
                    <div class="field-data">
                        <span>ОКПО</span>
                    </div>
                    <div class="input-field input-middle"><input type="text" value="<?php echo $this->info['okpo']; ?>" name="okpo" /></div>
                </div>
                <div class="razd-grey"></div>
                <div class="form-field no-margin">
                    <div class="field-data">
                        <span>Дополнительная информация</span>
                    </div>
                    <div class="field-input"><textarea class="input-long" cols="20" rows="5" value=""
                                                       name="info"><?php echo $this->info['info']; ?></textarea></div>
                </div>

            <?php } else { ?>
                <?php /* ?>
                  <div class="form-field">
                  <div class="field-data">
                  <span>Телефон</span>

                  </div>
                  <div class="input-field input-middle"><?php echo $this->infoA->phone; ?></div>
                  </div>
                  <?php
                  $error = $this->error['phone'];
                  if (!empty($error)) { ?>
                  <div class="error-list"><ul><li><?php echo $error; ?></li></ul></div>
                  <?php } ?>
                  <?php * ?>

                <div class="form-field">
                    <div class="field-data">
                        <span>Адрес</span>
                    </div>
                    <div class="input-field input-big"><?php echo $this->infoA->address; ?></div>
                </div>

                <div class="form-field no-margin">
                    <div class="field-data">
                        <span>Дополнительная информация</span>
                    </div>
                    <div class="field-input"><textarea class="input-long" cols="20" rows="5" value=""
                                                       name="info"><?php echo $this->info['info']; ?></textarea></div>
                </div>
<?php } ?>

        </div>
    </div>
    <div><input type="submit" class="safe-changes" value="Обновить данные" /></div><br><br>

    <div>Заполните, если хотите изменить пароль:</div>
    <div class="private-profile">
        <div class="grey-corner-tl">
            <div class="grey-corner-tr">
                <div class="grey-corner-tm"></div>
            </div>
        </div>
        <div class="grey-corner-m">
            <div class="form-field">
                <div class="form-field">
                    <div class="field-data">
                        <span>Новый пароль</span><span class="orandzh">*</span>
                    </div>
                    <div class="input-field input-small"><input type="password" value=""
                                                                name="password" /></div>
                </div>

                <div class="form-field">
                    <div class="field-data">
                        <span>Подтверждение пароля</span><span
                            class="orandzh">*</span>
                    </div>
                    <div class="input-field input-small"><input type="password" value=""
                                                                name="verifypassword" /></div>
                </div>
                <?php
                $error = $this->error['password'];
                if (!empty($error)) {
                    ?>
                    <div class="error-list"><ul><li><?php echo $error; ?></li></ul></div>
<?php } ?>
            </div>
        </div>
    </div>
    <div><input type="submit" class="safe-changes" value="Изменить пароль" /></div>
</form> <?php /* */ ?>