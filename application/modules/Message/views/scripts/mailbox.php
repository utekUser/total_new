<script>
	$(function () {
		$("label.form-check-label").click(function(e){
			labelID = $(this).attr('for');
			$('#ch'+labelID).trigger('click');
		});
	});
</script>
<div class="messages">
	<form action="/messages/mailbox/" method="post">
		<?php if (sizeof($this->paginator)) : 
			$conversation = new Message_Models_MessageConversations();
			$messageModel = new Message_Models_MessageMessages();
			$messageRes = new Message_Models_MessageRecipients(); ?>
			<?php foreach ($this->paginator as $item) : 
				$firstMessage = $messageModel->getFirstMessage($item['conversation_id']);
				$lastMessage = $messageModel->getLastMessage($item['conversation_id']);
				$mesRead = $messageRes->getMessageReadStatus($lastMessage['conversation_id'], $this->user_id);
				$message = $conversation->getOutboxMessage($item['user_id'], $item['conversation_id']);
				$messages = $conversation->getOutboxMessage($item['user_id'], $item['conversation_id']);
				foreach ($conversation->getRecipients($item['conversation_id']) as $tmpUser) {
					if ($tmpUser['id'] != $item['user_id']) {
						$sender = $tmpUser; // должна храниться уже информация о пользователе!!!
						break;
					}
				} ?>
				<div class="row-fluid one-message">
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<p class="date">&nbsp;</p>
						<input class="form-check-input tomauto-sel" type="checkbox" id="ch<?php echo $item['conversation_id']; ?>" value="<?php echo $item['conversation_id']; ?>" name="type[]" />
						<label for="ch<?php echo $item['conversation_id']; ?>" class="form-check-label">&nbsp;</label>
					</div>
					<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 padding0">
						<p class="date"><?php echo date("d.m.y", strtotime($firstMessage['date'])); ?></p>
						<div class="question border-left">
							<?php echo $firstMessage['body']; ?>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<p class="date">&nbsp;</p>
					</div>
					<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 padding0">
						<div class="answer-icon">
							<div class="answer border">
								<?php echo $lastMessage['body']; ?>
							</div>
						</div>
					</div>
				</div>				
			<?php endforeach; ?>
			<input type="submit" id="submit" class="send-form-del" value="Удалить отмеченные" />
		<?php else : ?>
			<p>У Вас нет сообщений.</p>
		<?php endif; ?>
	</form>
</div>
<div class="send-message-block">
	<h1 id="page-title">Написать сообщение</h1>
	<div class="send-message-form col-lg-6 col-md-6 col-sm-8 col-xs-12 padding0">
		<form action="/messages/send/" method="POST" class="">
			<div class="form-group login-input">
				<input type="text" required="" name="theme" id="theme" value="" placeholder="Тема:" class="form-control">
			</div>
			<div class="form-group login-input">
				<textarea class="form-control" required="" name="message-text" id="message-text" rows="5" cols="20" class="input-long" placeholder="Сообщение:"></textarea>
			</div>
			<input type="submit" id="submit" class="send-form" value="Отправить" />
		</form>
	</div>
</div>
<?php /*
<style>
    .messages-info a.add-messageN {
        margin: 0;
    }
    .add-messageN {
        background: url(/themes/default/images/newdesign/write.png) 0px 0px no-repeat;
        width: 152px;
        height: 31px;
        display: block;
        float: right;
        font-size: 0;     
        margin: -35px 0 0 0;
    }
    .add-messageN:hover {
        background: url(/themes/default/images/newdesign/writeH.png) 0px 0px no-repeat;
    }
    .messages-actionsN {
        color: #00aaf0;
        margin: 12px 0 12px 0;
    }
    .messages-actionsN span {
        color: #00aaf0;
        font-family: Arial;
        font-size: 12px;
        text-decoration: underline;
    }
    .messages-actionsN span:hover {
        color: #03597d;
    }
    .sendb {
        background: url(/themes/default/images/newdesign/send.png);
        width: 96px;
        height: 31px;
        border: 0px;
        font-size: 0px;
    }
    .sendb:hover {
        background: url(/themes/default/images/newdesign/sendh.png);
    }
    .messageText {
        color: #8b8c8d;
        font-family: Arial;        
    }
    a.mesLink {
        font-size: 12px;
        text-decoration: underline;
        color: #00aaf0;
    }
    a.mesLink:hover {
        color: #03597d;
    }
    .messageText .message-text {
        font-size: 12px;
    }
</style>
<?php if (!$this->isManager) { ?>
	<a href="/messages/send/" class="add-messageN"></a>
<?php } ?>
<form action="/messages/mailbox/" method="post">
	<?php if (sizeof($this->paginator)) { ?>
		<?php
		$conversation = new Message_Models_MessageConversations();
		$messageModel = new Message_Models_MessageMessages();
		$messageRes = new Message_Models_MessageRecipients();
		foreach ($this->paginator as $item) {
			$lastMessage = $messageModel->getLastMessage($item['conversation_id']);
			$mesRead = $messageRes->getMessageReadStatus($lastMessage['conversation_id'], $this->user_id);
			$message = $conversation->getOutboxMessage($item['user_id'], $item['conversation_id']);
			foreach ($conversation->getRecipients($item['conversation_id']) as $tmpUser) {
				if ($tmpUser['id'] != $item['user_id']) {
					$sender = $tmpUser; // должна храниться уже информация о пользователе!!!
					break;
				}
			}
			?>
			<div class="message message-first" style="margin: 35px 0;">
				<table width="100%" cellspacing="0" cellpadding="0" border="0" class="msg" style="border: 0px;">
					<tbody>
						<tr>
							<td valign="middle" align="left" style="width: 25px; padding: 10px;">
								<input type="checkbox" value="<?php echo $item['conversation_id']; ?>" name="type[]" />
							</td>
							<td class="messageText" style="border-left: 1px solid #ffe735;">
								<a class="mesLink" href="/messages/view/<?php echo $item['conversation_id']; ?>"><?php echo $item['title']; ?></a>
								<div class="message-text <?php echo ($mesRead ? '' : 'mes-unread'); ?>" style="padding: 5px 0;">
									<?php echo $lastMessage['body']; ?>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php } ?>
	<?php } else { ?>
		<p>У Вас нет сообщений.</p>
	<?php } ?>
	<div class="messages-actionsN">
		<span onclick="$('input[type=checkbox]').attr('checked', true);" style="cursor:pointer;">Отметить все</span>  /  <span onclick="$('input[type=checkbox]').removeAttr('checked');" style="cursor:pointer;">Снять выделение</span>
	</div>
	<div class="message-deleteN">
		<input type="submit" class="sendb" name="button" id="button" />
	</div>
</form> */ ?>