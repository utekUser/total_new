function validateInn(inn) {
    var result = false;
    if (typeof inn === 'number') {
        inn = inn.toString();
    } else if (typeof inn !== 'string') {
        inn = '';
    }
    if (!inn.length) {
        /*error.code = 1;
         error.message = 'ИНН пуст';*/
        error = 'ИНН пуст';
        $(".mask-inn-organization").next().text(error).css("color", "red").fadeIn(400);
        $(".mask-inn-organization").removeClass("inputGreen").addClass("inputRed");
    } else if (/[^0-9]/.test(inn)) {
        /*error.code = 2;
         error.message = 'ИНН может состоять только из цифр';*/
        error = 'ИНН может состоять только из цифр';
        $(".mask-inn-organization").next().text(error).css("color", "red").fadeIn(400);
        $(".mask-inn-organization").removeClass("inputGreen").addClass("inputRed");
    } else if ([10, 12].indexOf(inn.length) === -1) {
        /*error.code = 3;
         error.message = 'ИНН может состоять только из 10 или 12 цифр';*/
        error = 'ИНН может состоять только из 10 или 12 цифр';
        $(".mask-inn-organization").next().text(error).css("color", "red").fadeIn(400);
        $(".mask-inn-organization").removeClass("inputGreen").addClass("inputRed");
    } else {
        var checkDigit = function (inn, coefficients) {
            var n = 0;
            for (var i in coefficients) {
                n += coefficients[i] * inn[i];
            }
            return parseInt(n % 11 % 10);
        };
        switch (inn.length) {
            case 10:
                var n10 = checkDigit(inn, [2, 4, 10, 3, 5, 9, 4, 6, 8]);
                if (n10 === parseInt(inn[9])) {
                    result = true;
                }
                break;
            case 12:
                var n11 = checkDigit(inn, [7, 2, 4, 10, 3, 5, 9, 4, 6, 8]);
                var n12 = checkDigit(inn, [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8]);
                if ((n11 === parseInt(inn[10])) && (n12 === parseInt(inn[11]))) {
                    result = true;
                }
                break;
        }
        if (!result) {
            /*error.code = 4;
             error.message = 'Неправильное контрольное число';*/
            error = 'Неправильное контрольное число';
            $(".mask-inn-organization").next().text(error).css("color", "red").fadeIn(400);
            $(".mask-inn-organization").removeClass("inputGreen").addClass("inputRed");
        }
    }
    return result;
}

function setRandomHeight() {
    var goodsInRow = $('#random-goods').find("div.good");
    var rowHeight = 0;
    $.each(goodsInRow, function () {
        if (rowHeight < $(this).find("a.good-link").height()) {
            rowHeight = $(this).find("a.good-link").height();
        }
        isItFavourites($(this));
        isItInBasket($(this));
    });
    $.each(goodsInRow, function () {
        $(this).find("a.good-link").height(rowHeight);
    });
}

function addToFavourites(thisis) {
    var getId = thisis.attr('id').toString().split('-');
    var msg = "id=" + getId[getId.length - 1];
    $.ajax({
        type: "GET",
        url: "/account/favourites/",
        data: msg,
        success: function (response) {
            if (response == "No!") {
                alert("Для добавления товара в «Избранное» необходимо войти на сайт!");
            } else {
                if (thisis.hasClass("in-favourites")) {
                    thisis.attr('src', function (i, src) {
                        return src.replace("/themes/default/responsiveDesign/images/star.webp", "/themes/default/responsiveDesign/images/star2.webp");
                    });
                    thisis.removeClass("in-favourites");
                } else {
                    thisis.attr('src', function (i, src) {
                        return src.replace("/themes/default/responsiveDesign/images/star2.webp", "/themes/default/responsiveDesign/images/star.webp");
                    });
                    thisis.addClass("in-favourites");
                }
            }
        }
    });
}

function addToBasket(thisis) {
    var getId = thisis.attr('id').toString().split('-');
    var msg = "id=" + getId[getId.length - 1];
    $.ajax({
        type: "GET",
        url: "/account/basket/",
        data: msg,
        success: function (response) {
            if (response == "No!") {
                alert("Для добавления товара в «Корзину» необходимо войти на сайт!");
            } else {
                if (thisis.parent(".to-basket").hasClass("added")) {
                    thisis.parent(".to-basket").removeClass("added");
                    thisis.html("В корзину");
                } else {
                    thisis.parent(".to-basket").addClass("added");
                    thisis.html("Удалить");
                }
                $("#in-basket-count").html(response);
                $("#in-basket-count-mobile").html(response);
            }
        }
    });
}

function isItFavourites(thisis) {
    var getId = thisis.find("img.add-favourites").attr('id').toString().split('-');
    /*var msg = "id=" + getId[getId.length - 1];
     $.ajax({
     type: "GET",
     url: "/account/isitfavourites/",
     data: msg,
     success: function (response) {
     if (response == "Yes!") {
     thisis.find("img.add-favourites").attr('src', function (i, src) {
     return src.replace("/themes/default/responsiveDesign/images/star2.webp", "/themes/default/responsiveDesign/images/star.webp");
     });
     thisis.find("img.add-favourites").addClass("in-favourites");
     }
     }
     });*/
    $.post(
            "/account/isitfavourites/",
            {
                id: getId[getId.length - 1],
            },
            function (response) {
                if (response == "Yes!") {
                    thisis.find("img.add-favourites").attr('src', function (i, src) {
                        return src.replace("/themes/default/responsiveDesign/images/star2.webp", "/themes/default/responsiveDesign/images/star.webp");
                    });
                    thisis.find("img.add-favourites").addClass("in-favourites");
                }
            }
    );
}

function isItInBasket(thisis) {
    var getId = thisis.find("a.add-to-basket").attr('id').toString().split('-');
    /*var msg = "id=" + getId[getId.length - 1];
     $.ajax({
     type: "GET",
     url: "/account/isitinbasket/",
     data: msg,
     success: function (response) {
     if (response == "Yes!") {
     thisis.find("a.add-to-basket").parent(".to-basket").addClass("added");
     thisis.find("a.add-to-basket").html("Удалить");
     }
     }
     });*/
    $.post(
            "/account/isitinbasket/",
            {
                id: getId[getId.length - 1],
            },
            function (response) {
                if (response == "Yes!") {
                    thisis.find("a.add-to-basket").parent(".to-basket").addClass("added");
                    thisis.find("a.add-to-basket").html("Удалить");
                }
            }
    );
}

function getBasketCount() {
    /*$.ajax({
     type: "GET",
     url: "/account/getbasketcount/",
     success: function (response) {
     $("#in-basket-count").html(response);
     }
     });*/
    $.post(
            "/account/getbasketcount/",
            {},
            function (response) {
                $("#in-basket-count").html(response);
                $("#in-basket-count-mobile").html(response);
                $("#in-basket-count-account").html(response);
            }
    );
}

function getAllBasketSumm() {
    $.post(
            "/control/allbasketsumm/",
            {},
            function (response) {
                $("#all-basket-summ").html(response);
            }
    );
}

function oneMinus(thisis) {
    var getId = thisis.attr('id').toString().split('-');
    if ($('#id-basket-order-' + getId[getId.length - 1]).val() == 1) {
        alert("Не может быть меньше одного товара в корзине!");
    } else {
        $.post(
                "/control/oneminus/",
                {
                    id: getId[getId.length - 1],
                },
                function (response) {
                    $('#id-basket-order-' + getId[getId.length - 1]).val(response);
                    $('#id-basket-order-m-' + getId[getId.length - 1]).val(response);
                    getBasketCount();
                    getAllBasketSumm();
                }
        );
    }
}

function onePlus(thisis) {
    var getId = thisis.attr('id').toString().split('-');
    $.post(
            "/control/oneplus/",
            {
                id: getId[getId.length - 1],
            },
            function (response) {
                if (response == "over") {
                    alert("В корзине не может быть больше товаров, чем на складе!");
                } else {
                    $('#id-basket-order-' + getId[getId.length - 1]).val(response);
                    $('#id-basket-order-m-' + getId[getId.length - 1]).val(response);
                    getBasketCount();
                    getAllBasketSumm();
                }
            }
    );
}

function oneDelete(thisis) {
    var getId1 = thisis.attr('id').toString().split('-');
    $('#item-row-' + getId1[getId1.length - 1]).css("background", "rgba(249, 164, 164, 0.45)");
    $('.item-row-m-' + getId1[getId1.length - 1]).css("background", "rgba(249, 164, 164, 0.45)");
    setTimeout(function () {
        if (confirm('Вы действительно хотите удалить товар из корзины?')) {
            var getId = thisis.attr('id').toString().split('-');
            $.post(
                    "/control/onedelete/",
                    {
                        id: getId[getId.length - 1],
                    },
                    function (response) {
                        if (response == "Yes!") {
                            $('#item-row-' + getId[getId.length - 1]).fadeOut();
                            $('#item-row-' + getId[getId.length - 1]).remove();
                            $('.item-row-m-' + getId[getId.length - 1]).fadeOut();
                            $('.item-row-m-' + getId[getId.length - 1]).remove();
                            getBasketCount();
                            getAllBasketSumm();
                        }
                    }
            );
        } else {
            $('#item-row-' + getId1[getId1.length - 1]).css("background", "none");
            $('.item-row-m-' + getId1[getId1.length - 1]).css("background", "none");
        }
    }, 100);
}

function updateAddr(thisis) {
    var getId = thisis.attr('id').toString().split('-');
    var msg = "id=" + getId[getId.length - 1] + "&address=" + thisis.attr('value').toString();
    $.ajax({
        type: "GET",
        url: "/account/updateaddr/",
        data: msg,
        success: function (response) {
            if (response == "0") {
                alert("Ошибка!");
            } else {
                if (getId[getId.length - 1] == "new") {
                    $("#dot-block-new").attr("id", "dot-block-" + response);
                    $("#dot-address-new").attr("name", "dot-address[" + response + "]");
                    $("#dot-address-new").attr("id", "dot-address-" + response);
                    $("#upd-address-new").attr("id", "upd-address-" + response);
                    $("#del-address-new").attr("id", "del-address-" + response);
                    getId[getId.length - 1] = response;
                }
                $("#upd-address-" + getId[getId.length - 1]).show(750, function () {
                    setTimeout(function () {
                        $("#upd-address-" + getId[getId.length - 1]).hide(750);
                    }, 2500);
                });
            }
        }
    });
}
function deleteAddr(thisis) {
    var getId = thisis.attr('id').toString().split('-');
    var msg = "id=" + getId[getId.length - 1] + "&address=" + $("#dot-address-" + getId[getId.length - 1]).attr('value').toString();
    if (thisis.text() == "Восстановить") {
        thisis.text("Удалить").css("color", "#ff1d1d");
        $("#dot-block-" + getId[getId.length - 1]).css("opacity", "1");
        msg += "&del=0";
    } else {
        thisis.text("Восстановить").css("color", "#4e3637");
        $("#dot-block-" + getId[getId.length - 1]).css("opacity", "0.4")
        msg += "&del=1";
    }
    if (getId[getId.length - 1] != "new") {
        $.ajax({
            type: "GET",
            url: "/account/deleteddr/",
            data: msg,
            success: function (response) {
                if (response == "0") {
                    alert("Ошибка!");
                }
            }
        });
    }
    return false;
}
function getallprice() {
    $.ajax({
        type: "POST",
        url: "/control/getallprice/",
        data: "id=" + $("#dot-addr").find('option:selected').val(),
        beforeSend: function (xhr) {
            $('#total-sum-block').html('<img class="loading-warehouse" src="/themes/default/responsiveDesign/images/loader-front.webp" />');
        },
        success: function (response) {
            $("#total-sum-block").html(response);
        }
    });
}
function getordersale() {
    $.ajax({
        type: "POST",
        url: "/control/getordersale/",
        data: "id=" + $("#dot-addr").find('option:selected').val(),
        beforeSend: function (xhr) {
            $('#order-sale').html('<tr><td colspan="4"><img class="loading-warehouse" src="/themes/default/responsiveDesign/images/loader-front.webp" /></td></tr>');
        },
        success: function (response) {
            $("#order-sale").html(response);
        }
    });
}
function getordersalemobile() {
    $.ajax({
        type: "POST",
        url: "/control/getordersalemobile/",
        data: "id=" + $("#dot-addr").find('option:selected').val(),
        beforeSend: function (xhr) {
            $('#order-sale-mobile').html('<tr><td colspan="2"><img class="loading-warehouse" src="/themes/default/responsiveDesign/images/loader-front.webp" /></td></tr>');
        },
        success: function (response) {
            $("#order-sale-mobile").html(response);
        }
    });
}
$(function () {
    $(".inlineWriteUs").colorbox({inline: true, width: "460px"});
    $(".inlineWriteUsMob").colorbox({inline: true, width: "98%"});
    $(".inlineCallMe").colorbox({inline: true, width: "460px"});
    $(".inlineCallMeMob").colorbox({inline: true, width: "98%"});

    /*$('[data-toggle="popover"]').popover({trigger: 'hover'});*/
    $('.mask-phone').mask('+7 (999) 999-99-99');
    //$('.mask-inn-organization').mask('9999999999');
    $('.mask-ogrn').mask('9999999999999');
    $('.mask-kpp').mask('999999999');
    $('.mask-bik').mask('049999999');
    $('.mask-account').mask('99999 999 9 9999 9999999');
    $(".mask-email").inputmask("email");
    $('.mask-login').bind("change keyup input click", function () {
        if (this.value.match(/[^A-Za-z0-9-]/g)) {
            this.value = this.value.replace(/[^A-Za-z0-9-]/g, '');
        }
    });
    /*$(".ajax-send-addr").change(function () {
     updateAddr($(this));
     });
     /*$(".del-address-link").on('click', function () {
     deleteAddr($(this));
     });*/
    $("body").delegate(".del-address-link", "click", function () {
        deleteAddr($(this));
        return false;
    });
    $("body").delegate(".ajax-send-addr", "change", function () {
        updateAddr($(this));
        return false;
    });
    $("#a-add-address").click(function () {
        if ($("#dot-address-new").length > 0) {
            alert("Заполните пустое поле!");
            if ($("#del-address-new").text() == "Восстановить") {
                $("#del-address-new").text("Удалить").css("color", "#ff1d1d");
                $("#dot-block-new").css("opacity", "1");
            }
        } else {
            $("#new-dots").append('<div id="dot-block-new">\n\
                <div class="form-group row-fluid profile-input dot-address">\n\
                    <label for="dot-address" class="col-sm-4 col-form-label">Адрес доставки:</label>\n\
                        <div class="col-sm-8">\n\
                            <input type="text" class="form-control-plaintext ajax-send-addr" name="dot-address[new]" id="dot-address-new" placeholder="Введите новый адрес:">\n\
                        </div>\n\
                    </div>\n\
                    <div class="div-del-address">\n\
                        <a id="upd-address-new" class="upd-address-link">Адрес обновлён</a>\n\
                        <a id="del-address-new" class="del-address-link" href="#" title="Удалить точку доставки">Удалить</a>\n\
                        <hr/>\n\
                    </div>\n\
                </div>');
        }
        return false;
    });
    $("#get-good-count").click(function () {
        $(".item-stock").each(function () {
            var goodId = $(this).attr("id").split("-----");
            //alert(goodId[goodId.length - 1]);
            $.ajax({
                type: "GET",
                url: "/control/getbalance/",
                data: "id=" + goodId[goodId.length - 1],
                beforeSend: function (xhr) {
                    //alert("d");
                    $('#goodstock-----' + goodId[goodId.length - 1]).html('<img class="loading-warehouse" src="/themes/default/responsiveDesign/images/loader-front.webp" />');
                    $('#goodstockm-----' + goodId[goodId.length - 1]).html('<img class="loading-warehouse" src="/themes/default/responsiveDesign/images/loader-front.webp" />');
                },
                success: function (response) {
                    $('#goodstock-----' + goodId[goodId.length - 1]).html(response);
                    $('#goodstockm-----' + goodId[goodId.length - 1]).html(response);
                    if (response.indexOf("Нет данных") != -1) {
                        $('#id-basket-order-' + goodId[goodId.length - 1]).val("0");
                        $('#id-basket-order-m-' + goodId[goodId.length - 1]).val("0");
                    }
                }
            });
        });
        return false;
    });
    $("#content #login").change(function () {
        login = $("#content #login").val();
        $.ajax({
            url: "/account/checklogin/",
            type: "GET",
            data: "login=" + login,
            cache: false,
            success: function (response) {
                if (response == "yes") {
                    $("#content #login").next().text("Логин уже занят.").css("color", "red").fadeIn(400);
                    $("#content #login").removeClass("inputGreen").addClass("inputRed");
                } else {
                    $("#content #login").removeClass("inputRed").addClass("inputGreen");
                    $("#content #login").next().text("");
                }
            }
        });
    });
    $("#login-o").change(function () {
        login = $("#login-o").val();
        $.ajax({
            url: "/account/checklogin/",
            type: "GET",
            data: "login=" + login,
            cache: false,
            success: function (response) {
                if (response == "yes") {
                    $("#login-o").next().text("Логин уже занят.").css("color", "red").fadeIn(400);
                    $("#login-o").removeClass("inputGreen").addClass("inputRed");
                } else {
                    $("#login-o").removeClass("inputRed").addClass("inputGreen");
                    $("#login-o").next().text("");
                }
            }
        });
    });
    $("#email").change(function () {
        login = $("#email").val();
        $.ajax({
            url: "/account/checkemail/",
            type: "GET",
            data: "email=" + login,
            cache: false,
            success: function (response) {
                if (response == "yes") {
                    $("#email").next().text("E-mail уже занят.").css("color", "red").fadeIn(400);
                    $("#email").removeClass("inputGreen").addClass("inputRed");
                } else {
                    $("#email").removeClass("inputRed").addClass("inputGreen");
                    $("#email").next().text("");
                }
            }
        });
    });
    $("#email-o").change(function () {
        login = $("#email-o").val();
        $.ajax({
            url: "/account/checkemail/",
            type: "GET",
            data: "email=" + login,
            cache: false,
            success: function (response) {
                if (response == "yes") {
                    $("#email-o").next().text("E-mail уже занят.").css("color", "red").fadeIn(400);
                    $("#email-o").removeClass("inputGreen").addClass("inputRed");
                } else {
                    $("#email-o").removeClass("inputRed").addClass("inputGreen");
                    $("#email-o").next().text("");
                }
            }
        });
    });
    $(".mask-inn-organization").change(function () {
        var inn = $(".mask-inn-organization").val();
        if (inn.length >= 10) {
            //var error = "";
            var res = validateInn(inn);
            //alert(error);
            if (res) {
                $(".mask-inn-organization").removeClass("inputRed").addClass("inputGreen");
                $(".mask-inn-organization").next().text("");
                $.ajax({
                    url: "/account/checkinn/",
                    type: "GET",
                    data: "inn=" + inn,
                    cache: false,
                    success: function (response) {
                        if (response == "yes") {
                            $(".mask-inn-organization").next().text("ИНН уже есть в базе клиентов. Обратитесь в магазин для консультации.").css("color", "red").fadeIn(400);
                            $(".mask-inn-organization").removeClass("inputGreen").addClass("inputRed");
                        } else {
                            $(".mask-inn-organization").removeClass("inputRed").addClass("inputGreen");
                            $(".mask-inn-organization").next().text("");
                        }
                    }
                });
            }
        }
    });

    var topLink = $('#top-link');
    topLink.css({'padding-bottom': $(window).height()});
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 1) {
            topLink.fadeIn(300);
        } else {
            topLink.fadeOut(300);
        }
    });
    topLink.click(function (e) {
        $("body,html").animate({scrollTop: 0}, 500);
        return false;
    });

    $(".filter-title").click(function () {
        var getId1 = $(this).attr('id').toString().split('-');
        var ftId = "";
        for (var i = 1; i < getId1.length; i++) {
            ftId += getId1[i] + "-";
        }
        if ($('#fv-' + ftId.substr(0, ftId.length - 1)).is(':visible')) {
            $('#fv-' + ftId.substr(0, ftId.length - 1)).fadeOut();
            $('#ft-' + ftId.substr(0, ftId.length - 1) + ' h4').css("background", 'url("/themes/default/responsiveDesign/images/filter-arr-out.webp") no-repeat scroll 0 40%');
        } else {
            $('#fv-' + ftId.substr(0, ftId.length - 1)).fadeIn();
            $('#ft-' + ftId.substr(0, ftId.length - 1) + ' h4').css("background", 'url("/themes/default/responsiveDesign/images/filter-arr-in.webp") no-repeat scroll 0 40%');
        }
    });
    $(".left-usermenu-mobile").click(function () {
        if ($('#user-menu').is(':visible')) {
            $('#user-menu').fadeOut();
        } else {
            $('#user-menu').fadeIn();
        }
    });

    $("#login-link").click(function () {
        if ($(this).hasClass("active-login-block")) {
            $(this).removeClass("active-login-block");
            $("#login-block").css("display", "none");
        } else {
            $(this).addClass("active-login-block");
            $("#login-block").css("display", "block");
        }
    });
    $("#login-link-restore").click(function () {
        if ($("#login-link").hasClass("active-login-block")) {
            $("#login-link").removeClass("active-login-block");
            $("#login-block").css("display", "none");
        } else {
            $("#login-link").addClass("active-login-block");
            $("#login-block").css("display", "block");
        }
    });
    $("#login-link-restore").click(function () {
        if ($("#login-link").hasClass("active-login-block")) {
            $("#login-link").removeClass("active-login-block");
            $("#login-block").css("display", "none");
        } else {
            $("#login-link").addClass("active-login-block");
            $("#login-block").css("display", "block");
        }
    });

    $("input[name='account-type']").change(function () {
        if ($(this).attr('id') == "fiz-lico") {
            $("#reg-individual").css("display", "block");
            $("#reg-organizational").css("display", "none");
        } else if ($(this).attr('id') == "ur-lico") {
            $("#reg-individual").css("display", "none");
            $("#reg-organizational").css("display", "block");
        }
    });

    $(".plus-minus-order").click(function () {
        $("#order-info-" + $(this).attr('id')).toggle("fast");
        if ($("#img-" + $(this).attr('id')).attr("src").indexOf('plus') + 1) {
            $("#img-" + $(this).attr('id')).attr("src", "/themes/default/responsiveDesign/images/order-minus.webp");
            $("#img-" + $(this).attr('id')).attr("title", "Скрыть товары заказа");
        } else {
            $("#img-" + $(this).attr('id')).attr("src", "/themes/default/responsiveDesign/images/order-plus.webp");
            $("#img-" + $(this).attr('id')).attr("title", "Показать товары заказа");
        }
    });
    $(".order-show-m").click(function () {
        var getId = $(this).attr('id').toString().split('-');
        $("#order-info-m-" + getId[getId.length - 1]).toggle("fast");
        if ($("#img-m-" + getId[getId.length - 1]).attr("src").indexOf('plus') + 1) {
            $("#img-m-" + getId[getId.length - 1]).attr("src", "/themes/default/responsiveDesign/images/order-minus.webp");
            $("#img-m-" + getId[getId.length - 1]).attr("title", "Скрыть товары заказа");
        } else {
            $("#img-m-" + getId[getId.length - 1]).attr("src", "/themes/default/responsiveDesign/images/order-plus.webp");
            $("#img-m-" + getId[getId.length - 1]).attr("title", "Показать товары заказа");
        }
    });
    /**/
    $('.search-query-ajax').bind("change keyup input click", function () {
        if (this.value.length > 3) {
            var msg = $('#top-search-form').serialize();
            if (msg.substring(msg.length - 1, msg.length) == '=') {
                var msg = $('#top-search-form-mobile').serialize();
            }
            $.ajax({
                type: "GET",
                url: "/catalog/searchajax/",
                data: msg,
                success: function (response) {
                    $(".search-result-ajax").html(response).fadeIn();
                }
            });
        } else {
            $(".search-result-ajax").fadeOut();
        }
    });

    $(".search-result-ajax").on("click", "li", function () {
        s_user = $(this).text();
        $(".search-query-ajax").val(s_user);
        $(".search-result-ajax").fadeOut();
    });
    $("#catalog-search-text").focusout(function () {
        $(".search-result-ajax").fadeOut();
    });
    $("#catalog-search-text-mobile").focusout(function () {
        $(".search-result-ajax").fadeOut();
    });

    setTimeout(function () {
        $('div.goods-row').each(function () {
            var goodsInRow = $(this).find("div.good");
            var rowHeight = 0;
            $.each(goodsInRow, function () {
                if (rowHeight < $(this).find("a.good-link").height()) {
                    rowHeight = $(this).find("a.good-link").height();
                }
                isItFavourites($(this));
                isItInBasket($(this));
            });
            $.each(goodsInRow, function () {
                $(this).find("a.good-link").height(rowHeight);
            });
        });
        $('div.good-mobile').each(function () {
            isItFavourites($(this));
            isItInBasket($(this));
        });
    }, 1);

    $(document).ready(function () {
        getBasketCount();
        if ($("#all-basket-summ").length) {
            $(".item-stock").each(function () {
                var goodId = $(this).attr("id").split("-----");
                //alert(goodId[goodId.length - 1]);
                $.ajax({
                    type: "GET",
                    url: "/control/getbalance/",
                    data: "id=" + goodId[goodId.length - 1],
                    beforeSend: function (xhr) {
                        //alert("d");
                        $('#goodstock-----' + goodId[goodId.length - 1]).html('<img class="loading-warehouse" src="/themes/default/responsiveDesign/images/loader-front.webp" />');
                        $('#goodstockm-----' + goodId[goodId.length - 1]).html('<img class="loading-warehouse" src="/themes/default/responsiveDesign/images/loader-front.webp" />');
                    },
                    success: function (response) {
                        $('#goodstock-----' + goodId[goodId.length - 1]).html(response);
                        $('#goodstockm-----' + goodId[goodId.length - 1]).html(response);
                        if (response.indexOf("Нет данных") != -1) {
                            //alert(response.indexOf("Нет данных") + '#id-basket-order-' + goodId[goodId.length - 1]);
                            //alert('#id-basket-order-' + goodId[goodId.length - 1]);
                            $('#id-basket-order-' + goodId[goodId.length - 1]).val("0");
                            $('#id-basket-order-m-' + goodId[goodId.length - 1]).val("0");
                        }
                    }
                });
            });
        }
        if ($("#order-sale").length) {
            getallprice();
            getordersale();
            getordersalemobile();
            $('#dot-addr').on('change', function (e) {
                getallprice();
                getordersale();
                getordersalemobile();
            });
        }
        if ($("#loading-image").length) {
            $.ajax({
                type: "GET",
                url: "/catalog/mainajax/",
                /*data: msg,*/
                beforeSend: function () {
                    $("#loading-image").css('display', 'block');
                },
                success: function (response) {
                    $("#random-goods").html(response).fadeIn();
                    $("#loading-image").fadeOut();
                    setRandomHeight();
                }
            }).done(function () {
                $(".add-favourites").on('click', function () {
                    addToFavourites($(this));
                });
                $(".add-to-basket").on('click', function () {
                    addToBasket($(this));
                });
            });
        }
    });

    $(".add-favourites").on('click', function () {
        addToFavourites($(this));
    });

    $(".add-to-basket").on('click', function () {
        addToBasket($(this));
    });

    $(".one-minus").on('click', function () {
        oneMinus($(this));
    });

    $(".one-plus").on('click', function () {
        onePlus($(this));
    });

    $(".one-delete").on('click', function () {
        oneDelete($(this));
    });

    $('input[name=delivery_type]').click(function () {
        if ($('input[name=delivery_type]:checked').val() == 2) {
            $(".delivery-schedule").show();
            $('input[name=warehouse_type]').attr('disabled', 'disabled');
            $('input[name=warehouse_type]').removeAttr("checked");
        } else {
            $(".delivery-schedule").hide();
            $('input[name=warehouse_type]').removeAttr("disabled");
            $('input[name=warehouse_type]').first().attr('checked', 'checked');
        }
    });

    var $btn = document.getElementById('show-menu-m');
    var $nav = document.getElementById('nav-menu-m');
    var $clsBtn = document.getElementById('close-nav-m');

    $btn.addEventListener('click', function () {
        $nav.classList.toggle('active');
    });
    $clsBtn.addEventListener('click', function () {
        $nav.classList.toggle('active');
    });

    $(".dropdown-submenu-img-m").click(function () {
        $("#ul-" + $(this).attr('id').toString()).toggle("fast");
        if ($("#" + $(this).attr('id').toString()).attr("src").indexOf('-m-a.web') + 1) {
            $("#" + $(this).attr('id').toString()).attr("src", "/themes/default/responsiveDesign/images/submenu-m.webp");
            $("#" + $(this).attr('id').toString()).attr("title", "Показать подменю");
        } else {
            $("#" + $(this).attr('id').toString()).attr("src", "/themes/default/responsiveDesign/images/submenu-m-a.webp");
            $("#" + $(this).attr('id').toString()).attr("title", "Скрыть подменю");
        }
    });

    $('#add-address-img').click(function () {
        var i = $('input[name="address[]"]').size() + 1;
        $('<div id="addr-new-' + i + '" class="form-group login-input over-addr"><div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 dot-addr">\n\
                <input type="text" name="dot-address[]" id="address-' + i + '" value="" placeholder="Адрес доставки" class="form-control">\n\
            </div><div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 add-address">\n\
            <img id="rem-address-img-' + i + '" class="rem-address-img" alt="Удалить адрес" title="Удалить адрес"  \n\
            src="/themes/default/responsiveDesign/images/minus-addr.webp"></div></div>\n\
            <script>$(function () {\n\
                $("#rem-address-img-' + i + '").click(function() {\n\
                    $("#addr-new-' + i + '").fadeIn("slow").remove();\n\
                });\n\
            });</script>')
                .fadeIn('slow')
                .appendTo('#new-address-div');
    });
});

