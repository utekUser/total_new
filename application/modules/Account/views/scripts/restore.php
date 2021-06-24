<div id="restore-block">
    <?php if ($this->error) : ?>
        <div class="error-message">
            <div class="block-orange-tl">
                <div class="block-orange-tr">
                    <div class="block-orange-tm"></div>
                </div>
            </div>
            <div class="block-orange-ml">
                <div class="block-orange-mr">
                    <div class="block-orange-mm">
                        <?php
                        foreach ($this->error as $error) {
                            echo "$error<br />";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="block-orange-bl">
                <div class="block-orange-br">
                    <div class="block-orange-bm"></div>
                </div>
            </div>
        </div>
<?php endif; ?>
<?php if ($this->newPassError) : ?>
        <div class="error-message">
            <div class="block-orange-tl">
                <div class="block-orange-tr">
                    <div class="block-orange-tm"></div>
                </div>
            </div>
            <div class="block-orange-ml">
                <div class="block-orange-mr">
                    <div class="block-orange-mm">
                        <?php
                        foreach ($this->newPassError as $error) {
                            echo "$error\n";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="block-orange-bl">
                <div class="block-orange-br">
                    <div class="block-orange-bm"></div>
                </div>
            </div>
        </div>
<?php endif; ?>
<?php if ($this->mode == 'restore' && !$this->error) : ?>
        <form action="" method="post" class="auth-form" id="kcaptchaimg">
            <div class="form-group">
                <input type="password" name="password" id="password" value="" placeholder="Новый пароль*" class="form-control">            
            </div>
            <div class="form-group">
                <input type="password" name="repeatpassword" id="repeatpassword" value="" placeholder="Повторите пароль*" class="form-control">            
            </div>
            <input type="submit" id="submit-restore" class="send-form" value="Отправить" />
        </form>
    <?php elseif ($this->mode == 'newpassword') : ?>
        <p>Ваш пароль успешно изменен!</p>
        <p>Теперь вы можете <a id="login-link-restore" href="#" title="Войти на сайт">войти на сайт</a>, используя новый пароль.</p>
    <?php elseif (!$this->mode) : ?>
        <p>Если вы забыли пароль, введите логин или e-mail, указанные вами при регистрации. Информация для смены пароля будет выслана вам по e-mail.</p>
        <form action="/account/restore/" method="post" class="auth-form">
            <div class="form-group">
                <input type="text" name="email" id="repeatpassword" value="<?php echo (isset($this->search) ? $this->search : ''); ?>" placeholder="Логин или e-mail*" class="form-control">            
            </div>
            <div class="form-group hidden-xs">
                <p><a id="login-link-restore" href="#" title="Я вспомнил пароль">Я вспомнил пароль!</a></p>  
            </div>
			<div class="form-group visible-xs-block">
                <p><a id="login-link-restore" href="/account/login/" title="Я вспомнил пароль">Я вспомнил пароль!</a></p>  
            </div>
            <script>
                function call() {
                    $.ajax({
                        type: 'POST',
                        url: '/externals/kcaptcha/?<?php echo session_name(); ?>=<?php echo session_id(); ?>',
                        success: function (data) {
                            $("#kcaptchaimg1").attr("src", "/externals/kcaptcha/?<?php echo session_name(); ?>=<?php echo session_id(); ?>");
                        },
                        error: function (xhr, str) {
                            alert('Возникла ошибка: ' + xhr.responseCode);
                        }
                    });
                }
            </script>
            <div class="form-group">
                <input type="text" value="" autocomplete="off" name="captcha" placeholder="Код защиты:" class="form-control" />
            </div>
            <div class="form-group">
                <img style="margin-left: 0px;" class="captcha" alt="kcaptcha" id="kcaptchaimg1" src="/externals/kcaptcha/?<?php echo session_name(); ?>=<?php echo session_id(); ?>" />
            </div>
            <div class="form-group">
                <a href="#kcaptchaimg" onclick="call()">
                    <img style="margin: 0 10px 0 0;" src="/themes/default/images/newdesign/refresharr.png" title="Обновить картинку" />
                    Обновить картинку
                </a>
            </div>
            <input type="submit" id="submit-restore" class="send-form" value="Отправить" />
        </form>
    <?php endif; ?>
</div>