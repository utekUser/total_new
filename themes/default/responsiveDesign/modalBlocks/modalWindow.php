<script>
    $(document).ready(function () {
		<?php if (isset($_GET['callme'])) { ?>
	        $('#successModal').modal('show');
		<?php } ?>
    });
</script>
<?php
$mod = new Popup_Models_Popup();
$popups = $mod->getActivePopups(1);
if (count($popups) > 0) :
	?>
	<script>
		$(document).ready(function () {
			if (!$.cookie('wasVisitTrade')) {
				$('#popupModal').modal('show');
			}
			$.cookie('wasVisitTrade', true, {
				expires: 1,
				path: '/'
			});     
	    });
	</script>
	<div id="popupModal" class="modal fade">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<?php foreach ($popups as $key => $popup) : ?>					
					<?php if (strlen($popup['file']) == 0) : ?>
						<div class="container-fluid call-form-padding">
							<h3><?php echo $popup['name']; ?></h3>
						</div>
					<?php else : ?>
						<img style="width: 100%;" alt="<?php echo $popup['name']; ?>" title="<?php echo $popup['name']; ?>" src="/<?php echo $popup['file']; ?>" />
					<?php endif; ?>
					<br><br>
				<?php endforeach; ?>				
			</div>
		</div>
	</div>
<?php endif; ?>
<div id="successModal" class="modal fade">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
					<span aria-hidden="true">&times;</span>
				</button>
				<h1 class="call-form-h1">Ваше сообщение отправлено. Скоро мы Вам перезвоним.</h1>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<div id="callmeModal" class="modal fade">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
					<span aria-hidden="true">&times;</span>
				</button>
				<h1 class="call-form-h1">Заказать обратный звонок</h1>
			</div>
			<div class="container-fluid call-form-padding">
				<form method="POST" id="call-form-callme" action="/?callme=yes">
					<div class="form-group call-form-div-control">    
						<input required="true" type="text" class="form-control call-form-input" name="callmenametotalby" id="callMeName" placeholder="Имя*:">
					</div>
					<div class="form-group call-form-div-control">    
						<input required="true" type="text" class="form-control call-form-input" name="callmephonetotalby" id="callMePhone" placeholder="Телефон*:">
					</div>
					<div class="form-group call-form-div-control"> 
						<div class="g-recaptcha" data-sitekey="6LfqKxQUAAAAAMqF0JGAcIYmu3x29QU_RUG50ecK"></div>
					</div>
<?php /* <p>Мы гарантируем конфиденциальность контактных данных, которые будут использованы только в целях обеспечения связи между Вами и нашей компанией.</p> */ ?>
					<p>Наши менеджеры свяжутся с Вами в ближайшее время</p>
					<button type="submit" class="btn btn-default call-form-submit-send">Отправить</button>
				</form>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<div id="writeusModal" class="modal fade">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
					<span aria-hidden="true">&times;</span>
				</button>
				<h1 class="call-form-h1">Обратная связь</h1>
			</div>
			<div class="container-fluid call-form-padding">
				<form method="POST" id="call-form-writeus" action="/?callme=yes">
					<div class="form-group call-form-div-control">    
						<input required="true" type="text" class="form-control call-form-input" name="callmenametotalby" id="writeusName" placeholder="Имя*:">
					</div>
					<div class="form-group call-form-div-control">    
						<input required="true" type="text" class="form-control call-form-input" name="callmephonetotalby" id="writeusPhone" placeholder="Телефон*:">
					</div>
					<div class="form-group call-form-div-control"> 
						<textarea required="true" class="form-control call-form-input" placeholder="Текст сообщения*:" name="callmecommenttotalby" rows="5"></textarea>
					</div>
					<div class="form-group call-form-div-control"> 
						<div class="g-recaptcha" data-sitekey="6LfqKxQUAAAAAMqF0JGAcIYmu3x29QU_RUG50ecK"></div>
					</div>
<?php /* <p>Мы гарантируем конфиденциальность контактных данных, которые будут использованы только в целях обеспечения связи между Вами и нашей компанией.</p> */ ?>
					<p>Наши менеджеры свяжутся с Вами в ближайшее время</p>
					<button type="submit" class="btn btn-default call-form-submit-send">Отправить</button>
				</form>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>