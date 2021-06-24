<?php /* <button type="button" class="btn btn-primary" data-toggle="popover"
  title="Сообщение" data-content="Ура, Bootstrap 4 работает">
    Поднеси ко мне курсор
</button> */ ?>
<script type="text/javascript">
    $(document).ready(function () {
        function arcticmodal_close() {
            $('#boxUserFirstInfo').arcticmodal('close');
        }

        if (!$.cookie('wasVisit')) {
            $('#boxUserFirstInfo').arcticmodal({
                closeOnOverlayClick: true,
                closeOnEsc: true
            });
            //setTimeout(arcticmodal_close, 6000)
        }
        $.cookie('wasVisit', true, {
            expires: 1,
            path: '/'
        });

//            $(".sale227").click(function() {
//            $('#boxUserFirstInfo').arcticmodal({
//            closeOnOverlayClick: true,
//            closeOnEsc: true
//            });
//            });

        setTimeout(function () {
            if (!$.cookie('wasShownCallMe')) {
                $(".inlineCallmeFormByTime").colorbox({
                    inline: true,
                    width: "490px",
                    open: true
                });
            }

            $.cookie('wasShownCallMe', true, {
                expires: 1,
                path: '/'
            });
        }, 20000);
        //}
    });
</script> 
<?php /* <style>
	.arcticmodal-container_i td {
		padding: 0;
		backgroud: none !important;
	}
	.arcticmodal-container_i2 {
		padding: 0;
		backgroud: none !important;;
	}
</style> */ ?>
<div id="top-link"><a href="#top">наверх</a></div>