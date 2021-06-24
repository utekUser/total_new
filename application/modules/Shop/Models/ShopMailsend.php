<?php

class Shop_Models_ShopMailsend extends Engine_Model_Abstract {

	protected $_siteUrl = "томавтотрейд.рф";
	protected $_adminEmail = "mail@avtoritet.su";
	protected $_setFrom = "no-reply@томавтотрейд.рф";
	protected $_setFromOrder = "order@томавтотрейд.рф";
	protected $_userTypes = array(
		'0' => 'Физическое лицо',
		'1' => 'Юридическое лицо'
	);

	public function physicalRegistration($id, $request) {
		$email = $request->getPost('email');

		$patterns[0] = '/{site}/';
		$patterns[1] = '/{login}/';
		$patterns[2] = '/{data}/';
		$patterns[3] = '/{module}/';
		$patterns[4] = '/{id}/';

		$data = '----------------------------------------------------------' . '<br />' .
			'Логин: ' . htmlspecialchars($request->getPost('login')) . '<br />' .
			'Пароль: ' . $request->getPost('password') . '<br />' .
			'E-mail: ' . htmlspecialchars($request->getPost('email')) . '<br />' .
			'Контактное имя: ' . htmlspecialchars($request->getPost('name')) . '<br />' .
			'Адрес: ' . htmlspecialchars($request->getPost('address')) . '<br />' .
			'Телефон: ' . htmlspecialchars($request->getPost('phone')) . '<br />' .
			'Дополнительная информация: ' . htmlspecialchars($request->getPost('info')) . '<br />' .
			'----------------------------------------------------------' . '<br /><br />';

		$replacements[0] = $_SERVER['HTTP_HOST'];
		$replacements[1] = htmlspecialchars($request->getPost('login'));
		$replacements[2] = $data;
		$replacements[3] = "user";
		$replacements[4] = $id;

		$subject = iconv("utf8", "cp1251", 'Ваш аккаунт на сайте http://' . $replacements[0] . '/ успешно создан.');

		$letter = file_get_contents(APPLICATION_PATH . '/public/templates/reg_fiz.txt');
		$letter = preg_replace($patterns, $replacements, $letter);
		$letter = iconv("utf8", "cp1251", $letter);
		/* $fromName = iconv('utf8', 'cp1251', 'Томавтотрейд');
		  $toName = iconv('utf8', 'cp1251', $request->getPost('login')); */
		$mail = new Zend_Mail("windows-1251");
		$mail->setBodyHtml($letter);
		$mail->setFrom($this->_setFrom);
		$mail->addTo($email, iconv("utf8", "cp1251", $request->getPost('login')));
		$mail->setSubject($subject);
		$mail->send();

		$mailReplay = Engine_Cms::setupValue("reg");
		if ($mailReplay != '') {
			$mailSend = explode(',', $mailReplay);
			$subject = iconv("utf8", "cp1251", 'Регистрация на сайте http://' . $replacements[0] . '/');

			$letter2 = file_get_contents(APPLICATION_PATH . "/public/templates/reg_manager.txt");
			$letter2 = preg_replace($patterns, $replacements, $letter2);
			$letter2 = iconv("utf8", "cp1251", $letter2);
			/* $fromName = iconv('utf8', 'cp1251', "Томавтотрейд");
			  $toName = iconv('utf8', 'cp1251', "Администратору"); */
			foreach ($mailSend as $key => $value) {
				$emailPost = trim($value);
				if ($emailPost != '') {
					$mail = new Zend_Mail("windows-1251");
					$mail->setBodyHtml($letter2);
					$mail->setFrom($this->_setFrom);
					$mail->setReplyTo($this->_setFrom, "Томавтотрейд");
					$mail->addTo($emailPost, iconv("utf8", "cp1251", "Администратору"));
					$mail->setSubject($subject);
					$mail->send();
				}
			}
		}
	}

	public function legalentityRegistration($id, $request) {
		$email = $request->getPost('email');
		$patterns[0] = '/{site}/';
		$patterns[1] = '/{login}/';
		$patterns[2] = '/{data}/';
		$patterns[3] = '/{module}/';
		$patterns[4] = '/{id}/';

		$data = '----------------------------------------------------------' . '<br />' .
			'Логин: ' . htmlspecialchars($request->getPost('login')) . '<br />' .
			'Пароль: ' . $request->getPost('password') . '<br />' .
			'E-mail: ' . htmlspecialchars($request->getPost('email')) . '<br />' .
			'Контактное имя: ' . htmlspecialchars($request->getPost('name')) . '<br />' .
			'<p>Реквизиты:</p>' .
			'Наименование организации: ' . htmlspecialchars($request->getPost('title')) . '<br />' .
			'Юридический адрес: ' . htmlspecialchars($request->getPost('ur_address')) . '<br />' .
			'Фактический адрес: ' . htmlspecialchars($request->getPost('fact_address')) . '<br />' .
			'ОГРН: ' . htmlspecialchars($request->getPost('ogrn')) . '<br />' .
			'ИНН: ' . htmlspecialchars($request->getPost('inn')) . '<br />' .
			'Банк: ' . htmlspecialchars($request->getPost('bank')) . '<br />' .
			'КПП: ' . htmlspecialchars($request->getPost('kpp')) . '<br />' .
			'Р/С: ' . htmlspecialchars($request->getPost('rs')) . '<br />' .
			'КС: ' . htmlspecialchars($request->getPost('ks')) . '<br />' .
			'БИК: ' . htmlspecialchars($request->getPost('bik')) . '<br />' .
			'ОКПО: ' . htmlspecialchars($request->getPost('okpo')) . '<br />' .
			'<p>Дополнительная информация: ' . htmlspecialchars($request->getPost('info')) . '</p>' .
			'----------------------------------------------------------<br /><br />';

		$replacements[0] = $_SERVER['HTTP_HOST'];
		$replacements[1] = htmlspecialchars($request->getPost('login'));
		$replacements[2] = $data;
		$replacements[3] = 'user';
		$replacements[4] = $id;
		$subject = iconv("utf8", "cp1251", 'Ваш аккаунт на сайте http://' . $replacements[0] . '/ успешно создан.');

		$letter = file_get_contents(APPLICATION_PATH . '/public/templates/reg_yur.txt');
		$letter = preg_replace($patterns, $replacements, $letter);
		$letter = iconv("utf8", "cp1251", $letter);
		/* $fromName = iconv('utf8', 'cp1251', 'Томавтотрейд');
		  $toName = iconv('utf8', 'cp1251', $request->getPost('login')); */
		$mail = new Zend_Mail('windows-1251');
		$mail->setBodyHtml($letter);
		$mail->setFrom($this->_setFrom);
		$mail->addTo($email, iconv("utf8", "cp1251", $request->getPost('login')));
		$mail->setSubject($subject);
		$mail->send();

		$mailReplay = Engine_Cms::setupValue("reg");
		if ($mailReplay != '') {
			$mailSend = explode(',', $mailReplay);
			$subject = iconv("utf8", "cp1251", 'Регистрация на сайте http://' . $replacements[0] . '/');

			$letter2 = file_get_contents(APPLICATION_PATH . '/public/templates/reg_manager.txt');
			$letter2 = preg_replace($patterns, $replacements, $letter2);
			$letter2 = iconv("utf8", "cp1251", $letter2);
			/* $fromName = iconv('utf8', 'cp1251', 'Томавтотрейд');
			  $toName = iconv('utf8', 'cp1251', 'Администратору'); */
			foreach ($mailSend as $key => $value) {
				$emailPost = trim($value);
				if ($emailPost != '') {
					$mail = new Zend_Mail('windows-1251');
					$mail->setBodyHtml($letter2);
					$mail->setFrom($this->_setFrom);
					$mail->setReplyTo($this->_setFrom, "Томавтотрейд");
					$mail->addTo($emailPost, iconv("utf8", "cp1251", "Администратору"));
					$mail->setSubject($subject);
					$mail->send();
				}
			}
		}
	}

	public function restorePassword($id, $login, $email) {
		$userInfoModel = new User_Models_UserInfo();
		$userInfo = $userInfoModel->getUserInfo($id);
		if ($userInfo['name'] != '') {
			$name = ', ' . $userInfo['name'];
		} else {
			$name = '';
		}

		$key = md5(substr($login, 0, 2) . $login . 'restore');

		$patterns[0] = '/{site}/';
		$patterns[1] = '/{name}/';
		$patterns[2] = '/{key}/';
		$patterns[3] = '/{login}/';

		$replacements[0] = $_SERVER['HTTP_HOST'];
		$replacements[1] = $name;
		$replacements[2] = $key;
		$replacements[3] = $login;

		$letter = file_get_contents(APPLICATION_PATH . '/public/templates/restore.txt');
		$letter = preg_replace($patterns, $replacements, $letter);

		$mail = new Zend_Mail('utf-8');
		$mail->setBodyHtml($letter);
		$mail->setFrom($this->_setFrom);
		$mail->addTo($email, 'Администратору');
		$mail->setSubject('Ссылка для восстановления пароля на http://' . $replacements[0] . '/');
		$mail->send();

		//письмо для нас, отслеживать попытки смены пароля
		$letter2 = 'На сайте http://' . $this->_siteUrl . '/ произошла попытка смены пароля. <br/><br/>' .
			'IP: ' . $_SERVER['REMOTE_ADDR'] . '<br/>' .
			'Time: ' . date('Y-m-d H:i:s') . '<br/>' .
			'Input: ' . $search;
		$mail2 = new Zend_Mail('utf8');
		$mail2->setBodyHtml($letter2);
		$mail2->setFrom($this->_setFrom);
		$mail2->addTo($this->_adminEmail, 'Администратору');
		$mail2->setSubject('Смена пароля на http://' . $replacements[0] . '/');
		$mail2->send();
	}

	public function afterActivation($id) {
		$userModel = new User_Models_UserUser();
		$userModel->setUserAccess($id);

		$uInfo = $userModel->getUser($id);
		$mail = new Zend_Mail('windows-1251');

		$messag = "<p>Здравствуйте, " . $uInfo['login'] . "</p>\n\r";
		$messag .= "<p>Ваш профиль на сайте <a href='http://" . $this->_siteUrl .
			"' target='_blank'>" . $this->_siteUrl . "</a> активирован." . "</p>\n\r";

		$mail->setBodyHtml(iconv('utf8', 'cp1251', $messag));
		$mail->setFrom($this->_setFrom);
		$mail->addTo($uInfo['email'], iconv('utf8', 'cp1251', $uInfo['login']));
		$mail->setSubject(iconv('utf8', 'cp1251', "Ваш профиль активирован."));
		$mail->send();
	}

	public function sendOrderEmail($items, $orderData, $orderId) {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		$userUser = new User_Models_UserUser();
		$userInfo = new User_Models_UserInfo();
		$viewUser = $userUser->getUser($auth_id);
		$viewUserInfo = $userInfo->getUserInfo($auth_id);

		$userType = Engine_AuthUser::getUserType();
		$mailReplay = Engine_Cms::setupValue('order');
		if ($mailReplay != '') {
			$mailSend = explode(',', $mailReplay);

			$patterns[0] = '/{site}/';
			$patterns[1] = '/{user_type}/';
			$patterns[2] = '/{login}/';
			$patterns[3] = '/{name}/';
			$patterns[4] = '/{email}/';
			$patterns[5] = '/{phone}/';
			$patterns[6] = '/{items}/';
			$patterns[7] = '/{total_sum}/';
			$patterns[8] = '/{comment}/';
			$patterns[9] = '/{order_id}/';
			$patterns[10] = '/{order_date}/';
			$patterns[11] = '/{company_info}/';
			$patterns[12] = '/{delivery}/';
			$patterns[13] = '/{payment}/';
			$patterns[14] = '/{order_name}/';

			$items_list = '';
			foreach ($items as $item) {
				$items_list .= '<tr>' .
					'<td>' . $item['article'] . '</td>' .
					'<td>' . $item['name'] . '</td>' .
					'<td>' . $item['price'] . '</td>' .
					'<td>' . $item['basket_count'] . '</td>' .
					'<td>' . $item['price'] * $item['basket_count'] . '</td>' .
					'</tr>';
			}

			$replacements[0] = $_SERVER['HTTP_HOST'];
			$replacements[1] = $this->_userTypes[$orderData['customer_type']];
			$replacements[2] = $orderData['customer_login'];
			$replacements[3] = $orderData['customer_name'];
			$replacements[4] = $orderData['customer_email'];
			$replacements[5] = $orderData['customer_phone'];
			$replacements[6] = $items_list;
			$replacements[7] = $orderData['total_sum'];
			$replacements[8] = $orderData['comment'];
			$replacements[9] = $orderId;
			$replacements[10] = $orderData['date'];

			if ($userType) {
				$replacements[11] = '<tr><td>Название компании:</td><td>' . $orderData['company_name'] . '</td></tr>' .
					'<tr><td>Юридический адрес:</td><td>' . $orderData['company_address'] . '</td></tr>' .
					'<tr><td>ИНН:</td><td>' . $orderData['company_inn'] . '</td></tr>' .
					'<tr><td>КПП:</td><td>' . $orderData['company_kpp'] . '</td></tr>';
			} else {
				$replacements[11] = '';
			}

			$form = new Shop_Form_Order(); // Форма заказа
			$delivery = $form->delivery_type->getMultiOptions();
			$payment = $form->payment_type->getMultiOptions();
			$warehouse = $form->warehouse_type->getMultiOptions();

			$replacements[12] = $delivery[$orderData['delivery_type']];
			$replacements[13] = $payment[$orderData['payment_type']];

			if ($orderData['customer_type'] == 0) {
				$replacements[14] = "Розничный заказ";
				$typeOrder = 'Розничный заказ № ' . $orderId;
				$subject = 'Розничный заказ № ' . $orderId . '.' . ($orderData['company_name'] ? ' ' . $orderData['company_name'] . '.' : ($orderData['customer_name'] ? ' ' . $orderData['customer_name'] . '.' : ''));
			} else {
				$replacements[14] = "Оптовый заказ";
				$typeOrder = 'Оптовый заказ № ' . $orderId;
				$subject = 'Оптовый заказ № ' . $orderId . '.' . ($orderData['company_name'] ? ' ' . $orderData['company_name'] . '.' : ($orderData['customer_name'] ? ' ' . $orderData['customer_name'] . '.' : ''));
			}
			$subject = iconv('utf8', 'cp1251', $subject);
			$toName = iconv('utf8', 'cp1251', 'Администратору');

			$view = new Zend_View();
			$view->items = $items;
			$desired = new Shop_Models_DesiredProduct();
			$view->desiredItems = $desired->getProduct($auth->getIdentity());
			$view->totalSum = $orderData['total_sum'];
			$view->user = $viewUser;
			$view->userInfo = $viewUserInfo;
			$view->orderData = $orderData;
			$view->delivery = $replacements[12];
			$view->payment = $replacements[13];
			$view->comment = $orderData['comment'];
			$view->phone = $orderData['customer_phone'];
			$view->type = $userTypes[$orderData['customer_type']];
			$view->typeOrder = $typeOrder;

			$view->setScriptPath(APPLICATION_PATH . DS . 'application' . DS . 'modules' . DS . 'Order/templates/bill/');
			$contents = $view->render('in.php');

			//$mpdf = new mPDF('ru-RU', 'A4', '', '', 5, 5, 5, 5, 0, 0);
			$mpdf = new Mpdf\Mpdf();
			
			//$mpdf->myvariable = file_get_contents(APPLICATION_PATH . DS . 'application' . DS . 'modules' . DS . 'Order/templates/bill/images/header.jpg');
			$mpdf->WriteHTML($contents);
			$content = $mpdf->Output('', 'S');

			$desired->isOrder($auth->getIdentity(), $orderId);

			// save in file
			$pdfPath = APPLICATION_PATH . DS . 'media' . DS . 'order';
			if (is_writable($pdfPath)) {
				$mkdir = $pdfPath . DS . substr($orderId, -1) . DS . substr($orderId, -2, 1) . DS . $orderId;
				mkdir($mkdir, 0777, true);
				$mpdf->Output($mkdir . DS . 'order.pdf', 'F');
			}
			$nameOfFile = iconv('utf8', 'cp1251', $typeOrder . " от " . date('d.m.Y') . ". " . ($view->userInfo->title ? $view->userInfo->title : $view->userInfo->name) . ".pdf"); //  mb_convert_encoding($typeOrder . " от " . date('d.m.Y') .". " . ($view->userInfo->title ? $view->userInfo->title : $view->userInfo->name) . ".pdf", "utf-8", "cp1251");

			if ($_SERVER['REMOTE_ADDR'] == '46.161.158.155') {
				$tFileName = 'public/order/' . $orderId . '/' . $nameOfFile;
				mkdir(APPLICATION_PATH . '/public/order/' . $orderId . '/');
				$mpdf->Output(APPLICATION_PATH . '/' . $tFileName, 'F');

				$orderModel = new Shop_Models_OrderOrder();
				$table = $orderModel->getDbTable();
				$table->update(array('pdf' => $tFileName), array('id = ?' => $orderId));
			} 
			
			foreach ($mailSend as $key => $value) {
				$emailPost = trim($value);
				if ($emailPost != '') {
					$mailtr = new Zend_Mail_Transport_Sendmail();
					Zend_Mail::setDefaultTransport($mailtr);
					$mail = new Zend_Mail('windows-1251');
					$mail->addHeader('MIME-Version', '1.0');
					$mail->addHeader('Content-Type', 'text/html');
					$mail->addHeader('Content-Transfer-Encoding', '8bit');
					$mail->addHeader('X-Mailer:', 'PHP/' . phpversion());

					$mail->setFrom(($viewUser->email ? $viewUser->email : $this->_setFromOrder), iconv('utf8', 'cp1251', trim($viewUserInfo->name)));
					$mail->setReplyTo($viewUser->email ? $viewUser->email : $this->_setFromOrder, iconv('utf8', 'cp1251', 'Томавтотрейд'));
					/* $mail->setFrom("turkov.ya.ru", iconv('utf8', 'cp1251', "Томавтотрейд"));					
					  $mail->setReplyTo("turkov.ya.ru", iconv('utf8', 'cp1251', 'Томавтотрейд')); */
					$mail->addTo($emailPost, $toName);
					$mail->setBodyHtml(iconv('utf8', 'cp1251', "<p>Данные заказа в прикреплении письма в формате PDF.</p>"));
					$mail->setSubject($subject);

					$file = new Zend_Mime_Part($content);
					$file->type = 'application/pdf';
					$file->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
					$file->encoding = Zend_Mime::ENCODING_BASE64;
					$file->filename = $nameOfFile;

					$mail->addAttachment($file);
					$mail->send();
				}
			}
		}
	}

	public function mailingToClients() {
		$time = explode(":", date('H:i:s', time()));
		if (($time[0] == "10") && ($time[1] == "30")) {
			$letter = "<h3>Уважаемый клиент!</h3>" .
				"<p>Напоминаем Вам, что у Вас имеются не оформленные заказы!</p> " .
				"<p>Рекомендуем оформить заказ в течении трех дней.</p>" .
				"<p>По истечению данного срока выбранные Вами товары, будут удалены!</p><br>" . date('H:i:s', time());

			/* $subject = iconv('utf8', 'cp1251', 'Сообщение с сайта томавтотрейд.рф');
			  $toName = iconv('utf8', 'cp1251', 'Клиенту');
			  $letter = iconv('utf8', 'cp1251', $letter); */
			$shopSaveOrder = new Basket_Models_ShopSavedorder();
			$users = $shopSaveOrder->getUserIDsSaveOrder();
			$usInfo = new User_Models_UserUser();
			foreach ($users as $user) {
				$us = $usInfo->getUser($user['user_id']);
				$emails[] = $us['email'];
			}
			foreach ($emails as $email) {
				$emailPost = $email;
				$mail = new Zend_Mail('windows-1251');
				$mail->setBodyHtml(iconv('utf8', 'cp1251', $letter));
				$mail->setFrom($this->_setFrom);
				$mail->addTo($emailPost, iconv('utf8', 'cp1251', 'Клиенту'));
				$mail->setSubject(iconv('utf8', 'cp1251', 'Сообщение с сайта томавтотрейд.рф'));
				$mail->send();
			}
		}
	}

	public function mailingToManagers() {
		/* SMS рассылка менеджерам */
		$modelUser = new User_Models_UserUser();
		$modelOrder = new Shop_Models_OrderOrder();
		$modelManager = new Shop_Models_OrderManager();
		$orders = $modelOrder->getOrdersWhereSmsNotSend();
		foreach ($orders as $order) {
			$user = $modelUser->getUserByLogin($order['customer_login']);
			if ($user['manager_id'] != 0) {
				$manager = $modelManager->getManagerById($user['manager_id']);
				if (strlen($manager['manager_phone']) > 9) {
					$ch = curl_init("https://sms.ru/sms/send?json=1");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_TIMEOUT, 30);

					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

					curl_setopt($ch, CURLOPT_VERBOSE, 1);
					curl_setopt($ch, CURLOPT_POST, 1);

					//$message = "ИД: " . $order['id'] . ". Сумма: " . $order['total_sum'] . "руб. Компания: " . $order['company_name'] . "; " . $order['comment'];
					$message = $order['id'] . " на " . $order['total_sum'] . "р от " . $order['company_name'];
					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
						"api_id" => "C86FACF4-2343-2EFD-6706-92724FB2CEF8",
						"to" => $manager['manager_phone'],
						"msg" => $message,
					)));

					$body = curl_exec($ch);
					if ($body === FALSE) {
						$error = curl_error($ch);
					} else {
						$error = FALSE;
					}
					curl_close($ch);					
					/*if ($error) {
						echo "<pre>";
						print_r($error);
						echo "</pre>";
						die;
					}*/						
					$json = json_decode($body);
					if ($json) {
						if ($json->status == "OK") {
							foreach ($json->sms as $phone => $data) {
								if ($data->status == "OK") {
									$modelOrder->setSmsStatus($order['id']);
									//echo "Сообщение на номер $phone успешно отправлено. ";
									//echo "ID сообщения: $data->sms_id. ";
								} else {
									//echo "Сообщение на номер $phone не отправлено. ";
									//echo "Код ошибки: $data->status_code. ";
									//echo "Текст ошибки: $data->status_text. ";
								}
							}
							//echo "Баланс после отправки: $json->balance руб.";
						} else {
							//echo "Запрос не выполнился. ";      
							//echo "Код ошибки: $json->status_code. ";
							//echo "Текст ошибки: $json->status_text. ";
						}
					} else {
						//echo "Смс запрос не выполнился. Не удалось установить связь с сервером. ";
					}
				}
			}
		}
	}

}
