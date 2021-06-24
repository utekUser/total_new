<?php

class Account_controllers_IndexController extends Core_Controller_Action_User {

	public function init() {
		$this->_redirector = $this->_helper->getHelper('Redirector');
	}

	public function indexAction() {
		
	}

	public function loginAction() {
		$request = $this->getRequest();
		if ($request->isPost()) {
			$login = $request->getPost('login');
			$password = $request->getPost('password');
			$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
			$authAdapter = new Engine_AuthUser($login, $password);
			// Попытка аутентификации, сохранение результата
			//echo md5(md5("turkov_dm18313168")) . $login . $password; die;
			$result = $auth->authenticate($authAdapter);
			if ($result->isValid()) {
				//echo $_SESSION['UrlAfterAutorize']; die;
				//$this->_redirect('/control/');
				if ($_SESSION['UrlAfterAutorize'] == "/account/login/") {
					$_SESSION['UrlAfterAutorize'] = "/control/";
				}
				$this->_redirect($_SESSION['UrlAfterAutorize']);
			} else {
				$this->view->error = $result->getMessages();
			}
		}
		$_SESSION['UrlAfterAutorize'] = "/control/";
		$this->view->breadCrumbs = array(
			"/" => "Главная",
			"/account/login/" => "Вход"
		);
		$this->view->pageTitle = "Авторизация на сайте";
	}

	public function logoutAction() {
		Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'))->clearIdentity();
		setcookie("nid", "", time() - 3600 * 24 * 30 * 12, "/");
		setcookie("hhash", "", time() - 3600 * 24 * 30 * 12, "/");
		//$this->_redirect("/");
		if ($_SESSION['UrlAfterAutorize'] == "/control/") {
			$_SESSION['UrlAfterAutorize'] = "/";
		}
		$_SESSION['basketcount'] = 0;
		$this->_redirect($_SESSION['UrlAfterAutorize']);
	}

	/**
	 * Восстановление пароля
	 *
	 */
	public function restoreAction() {
		$_SESSION['UrlAfterAutorize'] = "/control/";
		$this->view->breadCrumbs = array(
			"/" => "Главная",
			"/account/restore/" => "Восстановление пароля"
		);
		$this->view->pageTitle = "Забыли пароль?";

		$request = $this->getRequest();
		$error = array();

		//переход по ссылке из письма
		if ($request->getQuery('mode') && $request->getQuery('mode') == 'restore') {
			$this->view->mode = 'restore';

			if ($request->getQuery('action') == 'success') {
				
			} elseif ($request->getQuery('action') == 'setpassword') {
				$login = $request->getQuery('login');

				// проверка логина
				if (preg_match('/[^A-Za-z0-9-_.@]/', $login)) {
					$error['disabled'] = 'Ссылка содержит недопустимые символы!';
				}
				if (empty($error)) {
					$userModel = new User_Models_UserUser();
					$thisUser = $userModel->getUserByLogin($login);

					// Есть ли пользователь с таким логином?
					if (!$thisUser) {
						$error['empty'] = 'Такого пользователя нет!';
					}
					if (empty($error)) {
						$keyDb = md5(substr($login, 0, 2) . $login . 'restore');
						$key = $request->getQuery('key');

						if ($keyDb != $key) {
							$error['key'] = 'Неправильная контрольная сумма!';
						}
						if (empty($error)) {
							//Отправка нового пароля
							if ($request->isPost()) {
								$newPassError = array();
								$password = $request->getPost('password');
								$repeatpassword = $request->getPost('repeatpassword');
								// проверка паролей
								if ($password == '') {
									$newPassError['empty'] = 'Поле <b>Новый пароль</b> не заполнено!';
								} elseif ($password !== $repeatpassword) {
									$newPassError['repeat'] = 'Поля <b>Новый пароль</b> и <b>Повтор пароля</b> не совпадают!';
								} elseif (!preg_match("/^\w{3,}$/", $password)) {
									$newPassError['disabled'] = 'В поле <b>Пароль</b> введены недопустимые символы!';
								} else {
									$salt = Engine_Filter_Encrypt_Password::getSalt();
									Engine_Filter_Encrypt_Password::setUser($thisUser['login']);
//                                    echo 'salt='.$salt.'<br>';
									$filter = new Engine_Filter_Encrypt_Password(array());
									$password = $filter->filter($password);

									$userModel->changePassword($thisUser['id'], $password, $salt);

									$this->_redirector->gotoUrl('/account/restore/?mode=newpassword');
								}
							}
						}
					}
				}
			}
			$this->view->error = $error;
			$this->view->newPassError = $newPassError;
		} elseif ($request->getQuery('mode') && $request->getQuery('mode') == 'newpassword') {
			$this->view->mode = 'newpassword';
		}

		//Запрос на восстановление пароля
		else {
			if ($request->isPost()) {
				$search = $request->getPost('email');
				$this->view->search = $search;

//                $captcha = new Engine_Validate_Captcha();
//                $captcha->isValid($request->getPost('captcha'));
				$captcha = $request->getPost('captcha');
				$captchaValidator = new Engine_Validate_Captcha();

				if ($search == '') {
					$error['empty'] = 'Поле <b>E-mail</b> не заполнено';
				}
//                elseif(!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $search)) {
//                    $error['wrong'] = 'Указанный <b>E-mail</b> имеет недопустимый формат!';
//                } 

				if ($captcha == '') {
					$error['emptyCaptcha'] = 'Поле <b>Защитный код</b> не заполнено';
				} elseif (!$captchaValidator->isValid($captcha)) {
					$error['wrongCaptcha'] = 'Неверный защитный код';
				}

				if (empty($error)) {
					$userModel = new User_Models_UserUser();
					$user = $userModel->getUserByLogin($search);
					if (!$user) {
//                	    $user_email = $user['email'];
						$user = $userModel->getUserByEmail($search);
					}
//                	else {
//                	    $user = $userModel->getUserByEmail($search);
//                	    if ($user) {
//                	        $user_email = $user['email'];
//                	    }
//                	}


					if ($user) {
						/*$userInfoModel = new User_Models_UserInfo();
						$userInfo = $userInfoModel->getUserInfo($user['id']);

						if ($userInfo['name'] != '')
							$name = ', ' . $userInfo['name'];
						else
							$name = '';

						$key = md5(substr($user['login'], 0, 2) . $user['login'] . 'restore');

						$patterns[0] = '/{site}/';
						$patterns[1] = '/{name}/';
						$patterns[2] = '/{key}/';
						$patterns[3] = '/{login}/';

						$replacements[0] = $_SERVER['HTTP_HOST'];
						$replacements[1] = $name;
						$replacements[2] = $key;
						$replacements[3] = $user['login'];

						$letter = file_get_contents(APPLICATION_PATH . '/public/templates/restore.txt');

						$letter = preg_replace($patterns, $replacements, $letter);

						$mail = new Zend_Mail('utf-8');
						$mail->setBodyHtml($letter);
						$mail->setFrom("account@total.tomauto.ru");
						$mail->addTo($user['email'], 'Администратору');
						$mail->setSubject('Ссылка для восстановления пароля на http://' . $replacements[0] . '/');
						$mail->send();

						//письмо для нас, отслеживать попытки смены пароля
						$email2 = 'mail@avtoritet.su';
						$letter2 = 'На сайте http://total.tomsk.ru/ произошла попытка смены пароля. <br/><br/>' .
							'IP: ' . $_SERVER['REMOTE_ADDR'] . '<br/>' .
							'Time: ' . date('Y-m-d H:i:s') . '<br/>' .
							'Input: ' . $search;
						$mail2 = new Zend_Mail('utf8');
						$mail2->setBodyHtml($letter2);
						$mail2->setFrom("account@total.tomauto.ru");
						$mail2->addTo($email2, 'Администратору');
						$mail2->setSubject('Смена пароля на http://' . $replacements[0] . '/');
						$mail2->send();*/

						$shopMailsend = new Shop_Models_ShopMailsend();
						$msresult = $shopMailsend->restorePassword($user['id'], $user['login'], $user['email']);

						$this->_redirector->gotoUrl('/account/sent/');
//                    	$this->view->successMessage = 'На ваш электронный адрес отправлено письмо с инструкцией по обновлению пароля.';
					} else {
						$error['notfound'] = '<b>Такой E-mail либо логин</b> не найден в базе данных!';
					}
				}
				$this->view->error = $error;
			}
		}
	}

	public function sentAction() {
		
	}

	/**
	 * Регистрация
	 *
	 */
	public function signupAction() {
		$_SESSION['UrlAfterAutorize'] = "/control/";
		$this->view->breadCrumbs = array(
			"/" => "Главная",
			"/account/signup/" => "Регистрация нового аккаунта на сайте"
		);
		$this->view->pageTitle = "Регистрация нового аккаунта на сайте";
		$pageId = $this->_getParam('pageId');

		// Если регистрируется на физическое лицо
		if ($pageId == 1) {
			Core_Controller_Action_User::setViewMain('signup-individual');

			$request = $this->getRequest();
			$formUser = new User_Form_UserUser();
			$formInfo = new User_Form_UserInfo();

			//$formInfo->phone->setRequired(false);
			//$formInfo->name->setRequired(false);
			$formInfo->title->setRequired(false);
			$formInfo->ur_address->setRequired(false);
			$formInfo->fact_address->setRequired(false);
			$formInfo->ogrn->setRequired(false);
			$formInfo->inn->setRequired(false);
			$formInfo->bank->setRequired(false);
			$formInfo->kpp->setRequired(false);
			$formInfo->rs->setRequired(false);
			$formInfo->ks->setRequired(false);
			$formInfo->bik->setRequired(false);
			//$formInfo->okpo->setRequired(false);

			if ($request->isPost()) {
				$modelUser = new User_Models_UserUser();
				$elementsUser = $formUser->getElements();
				$modelInfo = new User_Models_UserInfo();
				$elementsInfo = $formInfo->getElements();

				$salt = Engine_Filter_Encrypt_Password::getSalt();
				Engine_Filter_Encrypt_Password::setUser($request->getPost('login'));

				$elementsUser['salt']->setValue($salt);
				$password = $request->getPost('password');
				$elementsUser['password']->setValue($request->getPost('verifypassword'));
				$elementsUser['password']->setRequired(true);

				$formInfo->name->setValue($request->getPost('name'));
				$formInfo->address->setValue($request->getPost('address'));
				$formInfo->phone->setValue($request->getPost('phone'));
				$formInfo->info->setValue(($request->getPost('info') == "" ? "Нет информации" : $request->getPost('info')));

				$elementsUser['salt']->setValue($salt);
				$formUser->login->setValue($request->getPost('login'));
				$formUser->email->setValue($request->getPost('email'));
				$formUser->type->setValue($request->getPost('type'));
				$formUser->active->setValue($request->getPost('active'));
				$formUser->access->setValue($request->getPost('access'));
				$modelUser->saveUser($formUser->getElements());

				$id = $modelUser->getDbTable()->getAdapter()->lastInsertId();
				$elementsInfo['user_id']->setValue($id);
				$modelInfo->saveInfoFiz($formInfo->getElements());

				$shopMailsend = new Shop_Models_ShopMailsend();
				$msresult = $shopMailsend->physicalRegistration($id, $request);
				
				/*$email = $request->getPost('email');

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
				$replacements[3] = 'user';
				$replacements[4] = $id;

				$letter = file_get_contents(APPLICATION_PATH . '/public/templates/reg_fiz.txt');
				$letter = preg_replace($patterns, $replacements, $letter);

				$subject = iconv('utf8', 'cp1251', 'Ваш аккаунт на сайте http://' . $replacements[0] . '/ успешно создан.');
				$letter = iconv('utf8', 'cp1251', $letter);
				$fromName = iconv('utf8', 'cp1251', 'Томавтотрейд');
				$toName = iconv('utf8', 'cp1251', $request->getPost('login'));

				$mail = new Zend_Mail('windows-1251');
				$mail->setBodyHtml($letter);
				$mail->setFrom("account@total.tomauto.ru");
				$mail->addTo($email, $toName);
				$mail->setSubject($subject);
				$mail->send();

				$mailReplay = Engine_Cms::setupValue('reg');
				if ($mailReplay != '') {
					$mailSend = explode(',', $mailReplay);

					$letter2 = file_get_contents(APPLICATION_PATH . '/public/templates/reg_manager.txt');
					$letter2 = preg_replace($patterns, $replacements, $letter2);

					$subject = iconv('utf8', 'cp1251', 'Регистрация на сайте http://' . $replacements[0] . '/');
					$letter2 = iconv('utf8', 'cp1251', $letter2);
					$fromName = iconv('utf8', 'cp1251', 'Томавтотрейд');
					$toName = iconv('utf8', 'cp1251', 'Администратору');

					foreach ($mailSend as $key => $value) {
						$emailPost = trim($value);
						if ($emailPost != '') {
							$mail = new Zend_Mail('windows-1251');
							$mail->setBodyHtml($letter2);
							$mail->setFrom("account@total.tomauto.ru");
							$mail->setReplyTo('noreply@total.tomauto.ru', 'Томавтотрейд');
							$mail->addTo($emailPost, $toName);
							$mail->setSubject($subject);
							$mail->send();
						}
					}
				}*/				
				$this->_redirector->gotoUrl('/account/success/?user=f');
			}
			$this->view->user = $formUser;
			$this->view->info = $formInfo;
		} elseif ($pageId == 2) {
			Core_Controller_Action_User::setViewMain('signup-organization');

			$request = $this->getRequest();
			$formUser = new User_Form_UserUser();
			$formInfo = new User_Form_UserInfo();

			if ($request->isPost()) {
				$modelUser = new User_Models_UserUser();
				$elementsUser = $formUser->getElements();
				$modelInfo = new User_Models_UserInfo();
				$elementsInfo = $formInfo->getElements();
				$modelAddress = new User_Models_UserAddress();

				$salt = Engine_Filter_Encrypt_Password::getSalt();
				Engine_Filter_Encrypt_Password::setUser($request->getPost('login'));

				$elementsUser['salt']->setValue($salt);
				$password = $request->getPost('password');
				$elementsUser['password']->setValue($request->getPost('verifypassword'));
				$elementsUser['password']->setRequired(true);

				$formUser->login->setValue($request->getPost('login'));
				$formUser->email->setValue($request->getPost('email'));
				$formUser->type->setValue($request->getPost('type'));
				$formUser->active->setValue($request->getPost('active'));
				$formUser->access->setValue($request->getPost('access'));

				$formInfo->name->setValue($request->getPost('name'));
				$formInfo->phone->setValue($request->getPost('phone'));
				$formInfo->address->setValue("Поле не используется");
				$formInfo->title->setValue($request->getPost('title'));
				$formInfo->ur_address->setValue($request->getPost('ur_address'));
				$formInfo->fact_address->setValue("Поле не используется");
				$formInfo->ogrn->setValue($request->getPost('ogrn'));
				$formInfo->inn->setValue($request->getPost('inn'));
				$formInfo->bank->setValue($request->getPost('bank'));
				$formInfo->kpp->setValue($request->getPost('kpp'));
				$formInfo->rs->setValue($request->getPost('rs'));
				$formInfo->ks->setValue($request->getPost('ks'));
				$formInfo->bik->setValue($request->getPost('bik'));
				$formInfo->okpo->setValue($request->getPost('okpo'));
				$formInfo->okpo->setValue(($request->getPost('ip') == "1" ? "1" : "0"));
				$formInfo->info->setValue(($request->getPost('info') == "" ? "Нет информации" : $request->getPost('info')));

				$elementsUser['salt']->setValue($salt);
				$modelUser->saveUser($formUser->getElements());
				$id = $modelUser->getDbTable()->getAdapter()->lastInsertId();
				$elementsInfo['user_id']->setValue($id);
				$modelInfo->saveInfoUr($formInfo->getElements());

				$address1C = array();
				foreach ($_POST['dot-address'] as $value) {
					$addr = array(
						"user_id" => $id,
						"address" => $value
					);
					$idA = $modelAddress->saveAddr($addr);
					//$idA = $modelAddress->getDbTable()->getAdapter()->lastInsertId();
					$address1C["Adress"][] = array(
						"ID" => $idA,
						"Name" => $value,
						"Active" => true
					);
				}
				$shopExchange = new Shop_Models_ShopExchange();			
				$result = $shopExchange->registrationRequest($id, $_POST, $address1C);

				$shopMailsend = new Shop_Models_ShopMailsend();
				$msresult = $shopMailsend->legalentityRegistration($id, $request);
				
				/*$email = $request->getPost('email');
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

				$letter = file_get_contents(APPLICATION_PATH . '/public/templates/reg_yur.txt');
				$letter = preg_replace($patterns, $replacements, $letter);

				$subject = iconv('utf8', 'cp1251', 'Ваш аккаунт на сайте http://' . $replacements[0] . '/ успешно создан.');
				$letter = iconv('utf8', 'cp1251', $letter);
				$fromName = iconv('utf8', 'cp1251', 'Томавтотрейд');
				$toName = iconv('utf8', 'cp1251', $request->getPost('login'));

				$mail = new Zend_Mail('windows-1251');
				$mail->setBodyHtml($letter);
				$mail->setFrom("account@total.tomauto.ru");
				$mail->addTo($email, $toName);
				$mail->setSubject($subject);
				$mail->send();


				$mailReplay = Engine_Cms::setupValue('reg');
				if ($mailReplay != '') {
					$mailSend = explode(',', $mailReplay);

					$letter2 = file_get_contents(APPLICATION_PATH . '/public/templates/reg_manager.txt');
					$letter2 = preg_replace($patterns, $replacements, $letter2);

					$subject = iconv('utf8', 'cp1251', 'Регистрация на сайте http://' . $replacements[0] . '/');
					$letter2 = iconv('utf8', 'cp1251', $letter2);
					$fromName = iconv('utf8', 'cp1251', 'Томавтотрейд');
					$toName = iconv('utf8', 'cp1251', 'Администратору');

					foreach ($mailSend as $key => $value) {
						$emailPost = trim($value);
						if ($emailPost != '') {
							$mail = new Zend_Mail('windows-1251');
							$mail->setBodyHtml($letter2);
							$mail->setFrom("account@total.tomauto.ru");
							$mail->setReplyTo('noreply@total.tomauto.ru', 'Томавтотрейд');
							$mail->addTo($emailPost, $toName);
							$mail->setSubject($subject);
							$mail->send();
						}
					}
				}*/
				$this->_redirector->gotoUrl('/account/success/?user=u');
			}
			$this->view->user = $formUser;
			$this->view->info = $formInfo;
		} else {
			$request = $this->getRequest();

			$formUser = new User_Form_UserUser();
			$formInfo = new User_Form_UserInfo();
			$formAddress = new User_Form_UserAddress();
			$this->view->user = $formUser;
			$this->view->info = $formInfo;
			$this->view->address = $formAddress;

			if ($request->isPost()) {
				if ($request->getPost('account') == 1) {
					$this->_redirector->gotoUrl('/account/signup/1/');
				} elseif ($request->getPost('account') == 2) {
					$this->_redirector->gotoUrl('/account/signup/2/');
				}
			}
			$this->view->error = $error;
		}
	}

	/**
	 * После успешной регистрации
	 *
	 */
	public function successAction() {
		$request = $this->getRequest();
		$this->view->breadCrumbs = array(
			"/" => "Главная",
			"/account/signup/" => "Регистрация нового аккаунта на сайте",
			"/account/success/?user=" . $request->getQuery('user') => "Успешная регистрация"
		);
		$this->view->pageTitle = "Успешная регистрация";

		if ($request->getQuery('user') && $request->getQuery('user') == 'f') {
			$this->view->user = 'fiz';
		} else if ($request->getQuery('user') && $request->getQuery('user') == 'u') {
			$this->view->user = 'ur';
		}
	}

	/**
	 * Активация аккаунта после регистрации
	 *
	 */
	public function activeAction() {
		$request = $this->getRequest(); // получение объекта запроса Engine_Controller_Request_Http
		//Активация аккаунта пользователя после регистрации
		if ($request->getQuery('mode') && $request->getQuery('mode') == 'activation') {
			$error = array(); // array of errors

			$loginPost = $request->getQuery('user');
			$key = $request->getQuery('key');

			// Делаем проверку login на нехорошие символы
			if (preg_match('/[^A-Za-z0-9-_.]/', $loginPost)) {
				$error['activation'] = 'Неверная ссылка!';
			}
			if (empty($error)) {
				$time = time();

				$userModel = new User_Models_UserUser();
				$thisUser = $userModel->getUserByLogin($loginPost);

				// Есть ли пользователь с таким логином?
				if (!$thisUser) {
					$error['user'] = 'Такого пользователя нет!';
				}

				if (empty($error)) {
					// Может он уже активен?
					if ($thisUser['active'] == '1') {
						$error['activated'] = 'Данный логин уже подтвержден!';
					}
					if (empty($error)) {
						// Успел ли юзер активировать логин? (если нет - удаляем из базы)
						if ($time - $thisUser['timestamp'] > 7 * 24 * 60 * 60) {
							$userModel->deleteUser($thisUser['id']);
							$error['time'] = 'Срок активации истёк!<br /><br />Зарегистрируйтесь заново!';
						}

						if (empty($error)) {
							$key1 = md5(substr($thisUser['email'], 0, 2) . $thisUser['id'] . substr($loginPost, 0, 2));
//                            
							// Поверяем "keystring"
							if ($key1 != $key) {
								$error['key'] = 'Неправильная контрольная сумма!';
							}
							if (empty($error)) {
								$userModel->setUserActive($thisUser['id']);
							}
						}
					}
				}
			}
			$this->view->error = $error;
		}
	}

	/*
	 * 	Проверка логина на существование	
	 */

	public function checkloginAction() {
		if (isset($_GET['login'])) {
			$login = $_GET['login'];
			$userModel = new User_Models_UserUser();
			$isLogin = $userModel->getUserByLogin($login);
			if (is_object($isLogin)) {
				echo "yes";
			} else {
				echo "no";
			}
		}
		die;
		exit;
	}

	/*
	 * 	Проверка e-mail на существование	
	 */

	public function checkemailAction() {
		if (isset($_GET['email'])) {
			$email = $_GET['email'];
			$userModel = new User_Models_UserUser();
			$isLogin = $userModel->getUserByEmail($email);
			if (is_object($isLogin)) {
				echo "yes";
			} else {
				echo "no";
			}
		}
		die;
		exit;
	}

	/*
	 * 	Проверка ИНН на существование	
	 */

	public function checkinnAction() {
		if (isset($_GET['inn'])) {
			$inn = $_GET['inn'];
			$userModel = new User_Models_UserInfo();
			$isLogin = $userModel->getInn($inn);
			if (is_object($isLogin)) {
				echo "yes";
			} else {
				echo "no";
			}
		}
		die;
		exit;
	}

	public function favouritesAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$data = array(
				'user_id' => $auth_id,
				'good_id' => $_GET['id'],
				'added_date' => date('Y-m-d H:i:s', time())
			);
			$favouritesModel = new Account_Models_Favourites();
			$favouritesModel->favouritesAdd($data);
		} else {
			echo "No!";
		}
		die;
	}

	public function basketAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$data = array(
				'user_id' => $auth_id,
				'good_id' => $_GET['id'],
				'added_date' => date('Y-m-d H:i:s', time())
			);
			$basketModel = new Account_Models_Basket();
			$basketModel->basketAdd($data);
			echo $basketModel->getAllBasket($data);
		} else {
			echo "No!";
		}
		die;
	}

	public function isitfavouritesAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$data = array(
				'user_id' => $auth_id,
				'good_id' => $_POST['id']
			);
			$favouritesModel = new Account_Models_Favourites();
			echo $favouritesModel->getFavouritesByData($data);
		} else {
			echo "No!";
		}
		die;
	}

	public function isitinbasketAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$data = array(
				'user_id' => $auth_id,
				'good_id' => $_POST['id']
			);
			$basketModel = new Account_Models_Basket();
			echo $basketModel->getBasketByData($data);
		} else {
			echo "No!";
		}
		die;
	}

	public function getbasketcountAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$data = array(
				'user_id' => $auth_id,
			);
			$basketModel = new Account_Models_Basket();
			$_SESSION['basketcount'] = $basketModel->getAllBasket($data);
			echo $_SESSION['basketcount'];
		} else {
			echo "0";
		}
		die;
	}

	public function updateaddrAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$modelAddress = new User_Models_UserAddress();
			if ($_GET['id'] == "new") {
				$addr = array(
					"user_id" => $auth_id,
					"address" => $_GET['address']
				);
				$modelAddress->saveAddr($addr);
				$id = $modelAddress->getDbTable()->getAdapter()->lastInsertId();
			} else {
				$addr = array(
					"address" => $_GET['address']
				);
				$modelAddress->updateAddr($_GET['id'], $addr);
				$id = $_GET['id'];
			}
			$shopExchange = new Shop_Models_ShopExchange();
			$result = $shopExchange->updateAddr1C($auth_id, $id, $_GET['address'], true);
			//$this->updateAddr1C($auth_id, $id, $_GET['address'], true);
			echo $id;
		} else {
			echo "0";
		}
		die;
	}

	public function deleteddrAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$modelAddress = new User_Models_UserAddress();
			if ($_GET['del'] == "1") {
				$modelAddress->deleteAddr($_GET['id']);
				$isAct = false;
			} else {
				$modelAddress->unDeleteAddr($_GET['id']);
				$isAct = true;
			}
			$shopExchange = new Shop_Models_ShopExchange();			
			$result = $shopExchange->updateAddr1C($auth_id, $_GET['id'], $_GET['address'], $isAct);
			//$this->updateAddr1C($auth_id, $_GET['id'], $_GET['address'], $isAct);
			echo "1";
		} else {
			echo "0";
		}
		die;
	}

	public function activateAction() {
		header('Content-Type: application/json');
		if ($_GET['secret'] == "7BXBoTnTDOg5QV8NyQsb") {
			if ($_GET['mode'] == "activation") {
				if (isset($_GET['id'])) {
					$userModel = new User_Models_UserUser();
					$user = $userModel->getUser($_GET['id']);
					if ($user != null) {
						$userModel->setUserAccess($_GET['id']);
						
						$shopMailsend = new Shop_Models_ShopMailsend();
						$result = $shopMailsend->afterActivation($_GET['id']);
						
						echo '{"result": true}';
					} else {
						echo '{"result": false, "error" : "Undefined user"}';
					}					
				} else {
					echo '{"result": false, "error" : "User id not set"}';
				}
			} else {
				echo '{"result": false, "error" : "Undefined mode"}';
			}
		} else {
			echo '{"result": false, "error" : "Invalid secret key"}';
		}
		die;
		/*http://dev.томавтотрейд.рф/account/activate/?secret=7BXBoTnTDOg5QV8NyQsb&mode=activation&id=606*/
	}

}
