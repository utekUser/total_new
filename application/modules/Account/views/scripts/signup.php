<div id="signup-choose-form" class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
    <p>Регистрация нового пользователя под физическим лицом позволяет заказывать продукцию в обычном режиме (розничные цены). 
        Выбор и заказ продукции происходит сразу после заполнения анкеты и подтверждения регистрации.
    </p>
    <p>Регистрация нового пользователя под организацией предназначена для оптовых покупателей, магазинов, автосервисов и т.д. 
        Выбор и заказ продукции, доступ к личному кабинету для организации – будет доступен после того, как наш менеджер свяжется с вами для подтверждения данных.
    </p>
    <form method="post" action="/account/signup/">
        <div>
            <input class="tomauto-sel" type="radio" id="fiz-lico" name="account-type" value="1" />
            <label for="fiz-lico">Для физического лица</label>
        </div>
        <div>
            <input class="tomauto-sel" type="radio" id="ur-lico" name="account-type" value="2" />
            <label for="ur-lico">Для организации</label>
            <span>(для юридического лица и индивидуального предпринимателя (ИП))</span>
        </div>
    </form>
</div>
<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 singup-right">
    <?php include 'sign-indiv.php'; ?>
    <?php include 'sign-organ.php'; ?>    
</div>