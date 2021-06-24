<?php
$mod = new Popup_Models_Popup();
$popups = $mod->getActivePopups($this->userType);
if (count($popups) > 0) :
	?>
	<script>
		$(document).ready(function () {
			if (!$.cookie('wasVisitTradeUser')) {
				$('#popupModal').modal('show');
			}
			$.cookie('wasVisitTradeUser', true, {
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