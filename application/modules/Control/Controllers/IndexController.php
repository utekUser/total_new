<?php

class Control_controllers_IndexController extends Core_Controller_Action_User {

	public function init() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));

		if (!$auth->hasIdentity()) {
			$this->_redirect('/account/login/');
		}
		$this->view->id = $auth->getIdentity();
		$this->view->userType = Engine_AuthUser::getUserType();
		$this->view->userLogin = Engine_AuthUser::getLogin();
		$this->view->userEmail = Engine_AuthUser::getEmail();


		$this->orderId = $this->_getUrl('url', 1);
		$module = $this->_getUrl('url', 0);
		if ($this->_getUrl('url', 3) == "tobasket" || $this->_getUrl('url', 3) == "delete") {
			$actionOH = $this->_getUrl('url', 3);
			$shopSaveOrder = new Basket_Models_ShopSavedorder();
			if ($actionOH == "tobasket") {
				$shopSaveOrder->putToTheBasket($this->_getUrl('url', 2));
			} else {
				$shopSaveOrder->deleteForewer($this->_getUrl('url', 2));
			}
			echo $this->basketaction;
			$this->_redirector->gotoUrl('/control/history/');
		} elseif (strlen($this->_getUrl('url', 2))) {
			$this->sessId = $this->_getUrl('url', 2);
			Core_Controller_Action_User::setViewMain('history-savedorder');
			Core_Controller_Action_User::setDefaultParseUrlAction('savedorder');
		} elseif ($this->orderId == 'clear' && $module == 'history') {
//            Core_Controller_Action_User::setViewMain('history-view');
			Core_Controller_Action_User::setDefaultParseUrlAction('clear');
		} elseif (intval($this->orderId) && $module == 'history') {
			Core_Controller_Action_User::setViewMain('history-view');
			Core_Controller_Action_User::setDefaultParseUrlAction('view');
		} elseif (intval($this->orderId) && $module == 'notice') {
			Core_Controller_Action_User::setViewMain('notice-view');
			Core_Controller_Action_User::setDefaultParseUrlAction('noticeview');
		}
		$userModel = new User_Models_UserUser();
		$this->view->isManager = $userModel->isManager($auth->getIdentity());
	}

	public function puttoonecAction() {
		
		/*if (($handle = fopen(APPLICATION_PATH . '/temporary/catalog/new/address_total.csv', "r")) !== FALSE) {
			$addrArr = array();
			$info = "";
			while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
				if ($data[0] == "+" && $data[6] != "") {
					$modelInfo = new User_Models_UserInfo();
					$info = $modelInfo->getUserIdByINN($data[6]);
					if ($info != "") {
						$addrArr[$info] = array();
					}
				} else {
					if ($data[0] == "+") {
						$info = "";
					}
					if ($info != "" && $data[0] != "") {
						$addrArr[$info][] = trim($data[0]);						
					}
				}
			}
		}
		$this->view->addrArr = $addrArr;*/


		$modelUser = new User_Models_UserUser();
		$this->view->users = $modelUser->getUsersByTypeAndId(1, 0);

		$_SESSION['UrlAfterAutorize'] = $_SERVER['REQUEST_URI'];
		$this->view->breadCrumbs = array(
			"/" => "Главная",
			"/control/" => "Личный кабинет",
			"/control/puttoonec/" => "Выгрузка пользователей в 1С"
		);
		$this->view->pageTitle = "Выгрузка пользователей в 1С";
	}

	public function indexAction() {
		/* $shopSaveOrder = new Basket_Models_ShopSavedorder();
		  $this->view->isOrderMessageShow = $shopSaveOrder->putToTheBasketIfExist(); */

		/*
		  $model = new Report_Models_Report();
		  $form = new Report_Form_Report();
		  $request = $this->getRequest();
		  if ($request->isPost()) {
		  if ($form->isValid($request->getPost())) {
		  $model->saveNew($form->getElements());

		  $elements = $form->getElements();

		  $mailReplay = Engine_Cms::setupValue('mes');
		  if ($mailReplay != ''){
		  $mailSend = explode(',', $mailReplay);

		  //                    $patterns[0] = '/{site}/';
		  //                    $patterns[1] = '/{id}/';
		  $patterns[0] = '/{posted}/';
		  $patterns[1] = '/{author}/';
		  $patterns[2] = '/{mail}/';
		  $patterns[3] = '/{message}/';
		  $patterns[4] = '/{ip}/';
		  $patterns[5] = '/{site}/';


		  //                    $replacements[0] = $_SERVER['HTTP_HOST'];
		  //                    $replacements[1] = $id;
		  $replacements[0] = Engine_View_Helper_Date::getDateAndTime(date('Y-m-d H:i:s'));
		  $replacements[1] = htmlspecialchars($elements['author']->getValue());
		  $replacements[2] = htmlspecialchars($elements['email']->getValue());
		  $replacements[3] = htmlspecialchars($elements['message']->getValue());
		  $replacements[4] = $_SERVER['REMOTE_ADDR'];
		  $replacements[5] = $_SERVER['HTTP_HOST'];
		  //                    $replacements[7] = 'guestbook';

		  $letter = file_get_contents(APPLICATION_PATH . '/public/templates/message.txt');

		  $letter = preg_replace($patterns, $replacements, $letter);

		  $subject = iconv('utf8', 'cp1251', 'Сообщение от пользователя на сайте http://' . $replacements[5] . '/');
		  $letter = iconv('utf8', 'cp1251', $letter);
		  $fromName = iconv('utf8', 'cp1251', $replacements[1]);
		  $toName = iconv('utf8', 'cp1251', 'Администратору');


		  foreach ($mailSend as $key => $value) {
		  $emailPost = trim($value);
		  if ($emailPost != '') {
		  $mail = new Zend_Mail('windows-1251');
		  $mail->setBodyHtml($letter);
		  //                        	$mail->setFrom($replacements[2], $fromName);
		  $mail->setFrom("message@total.tomauto.ru");
		  $mail->addTo($emailPost, $toName);
		  $mail->setSubject($subject);
		  $mail->send();
		  }
		  }
		  }
		  $this->_redirector->gotoUrl('/control/?success=1');
		  }
		  }
		  if ($request->getQuery('success') == 1) $this->view->success = 1; else $this->view->success = 0;
		  $this->view->elements = $form->getElements();
		 */
		$modelBasket = new Account_Models_Basket();
		$modelFavourites = new Account_Models_Favourites();
		$modelUser = new User_Models_UserUser();
		$modelInfo = new User_Models_UserInfo();

		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$data = array('user_id' => $auth->getIdentity());
		$this->view->favGoods = $modelFavourites->getFavouritesToUserPage($data);
		$this->view->basketGoods = $modelBasket->getAllBasket($data);
		$this->view->basketSumm = $modelBasket->getAllBasketCount($data);
		$this->view->user = $user = $modelUser->getUser($this->view->id);
		$this->view->info = $modelInfo->getUserInfo($this->view->id);
		if ($user['type'] == "1") {
			$this->view->userType = 3;
		} else {
			$this->view->userType = 2;
		}
		$_SESSION['UrlAfterAutorize'] = $_SERVER['REQUEST_URI'];
		$this->view->breadCrumbs = array(
			"/" => "Главная",
			"/control/" => "Личный кабинет"
		);
		$this->view->pageTitle = "Личный кабинет";
	}

	public function profileAction() {
		$modelUser = new User_Models_UserUser();
		$modelInfo = new User_Models_UserInfo();
		$modelAddr = new User_Models_UserAddress();
		$this->view->user = $modelUser->getUser($this->view->id);
		$this->view->info = $modelInfo->getUserInfo($this->view->id);
		//echo $this->view->id; die;
		$this->view->userAddr = $modelAddr->getUserAddr($this->view->id);
		$request = $this->getRequest();
		$formInfo = new User_Form_UserInfo();
		$formUser = new User_Form_UserUser();
		if (!$this->view->user['type']) {
			$formInfo->fact_address->setRequired(false);
			$formInfo->ur_address->setRequired(false);
			$formInfo->inn->setRequired(false);
			$formInfo->title->setRequired(false);
		}
		$formUser->addSubForms(array(
			'information' => $formInfo
		));
		$this->view->formUser = $modelUser;
		$this->view->formInfo = $modelInfo;

		$error = array();
		if ($request->isPost()) {
			if ($request->getPost('password') || $request->getPost('verifypassword')) {
				$password = $request->getPost('password');
				$verify = $request->getPost('verifypassword');
				$salt = Engine_Filter_Encrypt_Password::getSalt();
				Engine_Filter_Encrypt_Password::setUser($request->getPost('login'));
				if ($password != $verify) {
					$error['password'] = 'Пароли не совпадают.';
				}
				if (empty($error)) {
					$salt = Engine_Filter_Encrypt_Password::getSalt();
					Engine_Filter_Encrypt_Password::setUser($request->getPost('login'));
					$encrypt = new Engine_Filter_Encrypt_Password($options = '');
					$newpass = $encrypt->filter($password);
					$modelUser->changePassword($this->view->id, $newpass, $salt);
					$this->_redirect('/control/profile/?pass=success');
				}
			} else { // Change information about user				
				if ($formInfo->isValid($request->getPost())) {
					$modelInfo->updateProfile($this->view->id, $formInfo->getElements(), $this->view->userType);
					$this->_redirect('/control/profile/?change=success');
				} else {
					//echo "<pre>";					print_r($formInfo->getMessages()); die;
				}
			}
		} else { // TODO если не было отправки - надо присвоить
			$formInfo->setDefaults($this->view->info->toArray());
		}
		if ($request->getQuery('pass') == 'success') {
			$this->view->success = 'Пароль успешно изменен.';
		} elseif ($request->getQuery('change') == 'success') {
			$this->view->success = 'Данные успешно изменены.';
		}
		$this->view->error = array_merge($error, $formInfo->getMessages());
		$this->view->userA = $formUser;
		$this->view->infoA = $formInfo;
		$this->view->elementsUser = $formUser->getElements();
		$this->view->elementsInfo = $formInfo->getElements();
		$_SESSION['UrlAfterAutorize'] = $_SERVER['REQUEST_URI'];
		$this->view->breadCrumbs = array(
			"/" => "Главная",
			"/control/" => "Личный кабинет",
			"/control/profile/" => "Мои данные"
		);
		$this->view->pageTitle = "Мои данные";
	}

	public function repeatorderAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$composition = new Shop_Models_OrderComposition();
			$repeat = $composition->getOrderComposition($this->_getUrl('url', 1));
			$basketModel = new Account_Models_Basket();
			foreach ($repeat as $key => $value) {
				//echo $value["base_id"]; die;
				$goodModel = new Shop_Models_OrderGood();
				$goodId = $goodModel->getOnecIdByArticleId($value["base_id"]);
				//echo $goodId; die;
				$data = array(
					'user_id' => $auth_id,
					'count' => $value['amount'],
					'good_id' => $goodId,
					'added_date' => date('Y-m-d H:i:s', time())
				);
				$basketModel->repeatBasket($data);
			}
			/* print_r($data);
			  die; */
			$this->_redirect("/control/viewbasket/");
		} else {
			$this->_redirect("/account/login/");
		}
	}

	public function messagesAction() {
		
	}

	public function viewbasketAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$data = array(
				'user_id' => $auth_id,
			);
			$basketModel = new Account_Models_Basket();
			$this->view->itemsInBasket = $goods = $basketModel->getAllBasketGoods($data);
			$this->view->itemsInBasketCount = $basketModel->getAllBasketCount($data);
		} else {
			$this->view->itemsInBasket = array();
			$this->view->itemsInBasketCount = 0;
		}
		$this->view->breadCrumbs = array(
			"/" => "Главная",
			"/control/" => "Личный кабинет",
			"/control/viewbasket/" => "Корзина"
		);
		$this->view->pageTitle = "Корзина";
	}

	public function orderAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();

		$basketModel = new Account_Models_Basket();
		$basketModel->deleteIfCountNull(array('user_id' => $auth_id));

		$settingModel = new Shop_Models_ShopSetting();
		$sumToday = $settingModel->getSettingById(1);
		$this->view->sumToday = $sumToday['textfield'];
		$timeToday = $settingModel->getSettingById(2);
		$this->view->timeToday = date("H:i", strtotime($timeToday['datetime']));
		if (isset($auth_id)) {
			$userType = Engine_AuthUser::getUserType();
			$this->view->userType = $userType;
			if ($userType) {
				$uAdrModel = new User_Models_UserAddress();
				$this->view->userAddrs = $addrIds = $uAdrModel->getUserAddr($auth_id);
				$this->view->firstAddrId = $firstAddrId = $addrIds[0]->id;
			}
			$userUser = new User_Models_UserUser();
			$userInfo = new User_Models_UserInfo();
			$this->view->user = $viewUser = $userUser->getUser($auth_id);
			$this->view->userInfo = $viewUserInfo = $userInfo->getUserInfo($auth_id);
		} else {
			$this->view->itemsInBasketCount = 0;
		}

		$error = array();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if (!$userType) {
				if ($request->getPost('name') == '')
					$error['name'] = 'Поле <b>Ф.И.О.</b> является обязательным для заполения.';
				if ($request->getPost('email') == '')
					$error['email'] = 'Поле <b>E-Mail</b> является обязательным для заполения.';
				if ($request->getPost('phone') == '')
					$error['phone'] = 'Поле <b>Телефон</b> является обязательным для заполения.';
			} else {
				if ($request->getPost('title') == '')
					$error['title'] = 'Поле <b>Название компании</b> является обязательным для заполения.';
				if ($request->getPost('name') == '')
					$error['name'] = 'Поле <b>Контактное лицо</b> является обязательным для заполения.';
				if ($request->getPost('email') == '')
					$error['email'] = 'Поле <b>E-Mail</b> является обязательным для заполения.';
			}

			$data = array(
				'user_id' => $auth_id,
			);
			$basketModel = new Account_Models_Basket();
			$itemsInBasketCount = $basketModel->getAllBasketGoods($data);

			if (count($itemsInBasketCount) == 0)
				$error['items_count'] = 'Необходимо добавить в корзину хотя бы один товар.';
			if ($request->getPost('delivery_type') == '')
				$error['delivery_type'] = 'Необходимо указать способ доставки.';
			if ($request->getPost('payment_type') == '')
				$error['payment_type'] = 'Необходимо указать способ оплаты.';

			if (empty($error)) {
				$orderData = array(
					'date' => date('Y-m-d H:i:s'),
					'customer_name' => $request->getPost('name'),
					'customer_login' => Engine_AuthUser::getLogin(),
					'customer_type' => $userType,
					'customer_phone' => $request->getPost('phone'),
					'customer_email' => $request->getPost('email'),
					'total_sum' => $request->getPost('total_sum'),
					'comment' => ($request->getPost('comment') ? $request->getPost('comment') : "Комментарий отсутствует"),
					'delivery_type' => $request->getPost('delivery_type'),
					'payment_type' => $request->getPost('payment_type'),
					'warehouse_type' => '0',
				);
				if ($userType) {
					$orderData['company_name'] = $request->getPost('title');
					$orderData['company_address'] = $request->getPost('ur_address');
					$orderData['company_inn'] = $request->getPost('inn');
					$orderData['company_kpp'] = $request->getPost('kpp');
					$priceType = 'from1c';
				} else {
					$priceType = 'base';
				}

				$order = new Shop_Models_OrderOrder();
				$order->createNewOrder($orderData, $request->getPost("dot-addr"), $itemsInBasketCount, $priceType);

				$basketModel = new Account_Models_Basket();
				$basketModel->clearBasket($data);

				$this->_redirect('/control/success/?order=' . $order_id);
			}
		}

		$this->view->breadCrumbs = array(
			"/" => "Главная",
			"/control/" => "Личный кабинет",
			"/control/viewbasket/" => "Корзина",
			"/control/order/" => "Оформление заказа"
		);
		$this->view->pageTitle = "Оформление заказа";
	}

	public function successAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		if (!$auth->hasIdentity()) {
			$this->_redirect('/account/login/');
		}
		$userLogin = Engine_AuthUser::getLogin();

		$request = $this->getRequest();
		if ($request->getQuery('order') && intval($request->getQuery('order'))) {
			$order_id = $request->getQuery('order');
			$orderModel = new Shop_Models_OrderOrder();
			$this->view->orderInfo = $orderModel->getOrderDateAndId($order_id, $userLogin);
		}

		$this->view->breadCrumbs = array(
			"/" => "Главная",
			"/control/" => "Личный кабинет",
			"/control/success/" => "Успешное оформление заказа"
		);
		$this->view->pageTitle = "Успешное оформление заказа";
	}

	public function favouritesAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$data = array(
				'user_id' => $auth_id
			);
			$favouritesModel = new Account_Models_Favourites();
			$this->view->goods = $favouritesModel->getAllFavouritesByUser($data);
		}

		$_SESSION['UrlAfterAutorize'] = $_SERVER['REQUEST_URI'];
		$this->view->breadCrumbs = array(
			"/" => "Главная",
			"/control/" => "Личный кабинет",
			"/control/favourites/" => "Избранное"
		);
		$this->view->pageTitle = "Избранные товары";
	}

	public function historyAction() {
		$userLogin = Engine_AuthUser::getLogin();
		$orderModel = new Shop_Models_OrderOrder();
		$this->view->orders = $orders = $orderModel->getUserOrders($userLogin);

		$composition = new Shop_Models_OrderComposition();
		$orderInfo = array();
		foreach ($orders as $key => $value) {
			$orderInfo[$value['id']] = $composition->getOrderComposition($value['id']);
		}
		$this->view->orderInfo = $orderInfo;
		/* $shopSaveOrder = new Basket_Models_ShopSavedorder();
		  $this->view->savedorders = $shopSaveOrder->getUserSaveOrders(); */
		$status = array();
		$table = new Shop_Models_OrderStatus();
		$select = $table->getStatus();
		foreach ($select as $value) {
			$status[$value->id]['name'] = $value->name;
			$status[$value->id]['code'] = $value->code;
		}
		$this->view->statusList = $status;
		$this->view->paymentList = array(
			"1" => "Наличными",
			"2" => "Безналичный расчёт",
		);
		$this->view->delivetyList = array(
			"1" => "Самовывоз",
			"2" => "Доставка курьером",
		);
		$_SESSION['UrlAfterAutorize'] = $_SERVER['REQUEST_URI'];
		$this->view->breadCrumbs = array(
			"/" => "Главная",
			"/control/" => "Личный кабинет",
			"/control/history/" => "История заказов"
		);
		$this->view->pageTitle = "История заказов";
	}

	public function clearAction() {
		$userLogin = Engine_AuthUser::getLogin();
		$orderModel = new Shop_Models_OrderOrder();
		$orderModel->clearHistory($userLogin);
		$this->_redirector->gotoUrl('/control/history/');
	}

	public function viewAction() {
		$orderId = $this->orderId;
		$userLogin = Engine_AuthUser::getLogin();
		$orderModel = new Shop_Models_OrderOrder();
		$this->view->orderInfo = $orderModel->getCurrentOrder($userLogin, $orderId);

		$status = array();
		$table = new Shop_Models_OrderStatus();
		$select = $table->getStatus();
		foreach ($select as $value) {
			$status[$value->id]['name'] = $value->name;
			$status[$value->id]['code'] = $value->code;
		}
		$this->view->statusList = $status;

		$composition = new Shop_Models_OrderComposition();
		$this->view->items = $composition->getOrderComposition($orderId);
		$totalSum = 0;
		foreach ($this->view->items as $item) {
			$totalSum += $item['price'] * $item['amount'];
		}
		$this->view->totalSum = $totalSum;

		$userModel = new User_Models_UserUser();
		$this->view->user = $userModel->getUserByLogin($userLogin);
		$userInfo = new User_Models_UserInfo();
		$this->view->userInfo = $userInfo->getUserInfo($this->view->id);
	}

	public function savedorderAction() {
		$shopSaveOrder = new Basket_Models_ShopSavedorder();
		$this->view->orderinfo = $shopSaveOrder->getUserOrderBySessionId($this->sessId);
		$this->view->sessId = $this->sessId;
	}

	public function noticeAction() {
		$model = new Notice_Models_Notice();
		$this->view->messages = $messages = $model->getUserNotices($this->view->id);
	}

	public function noticeviewAction() {
		$notice_id = intval($this->_getUrl('url', 1));
		$user_id = $this->view->id;

		$model = new Notice_Models_Notice();
		$modelConn = new Notice_Models_Connection();
		$this->view->notice = $notice = $model->getNotice($notice_id);

		if (!$modelConn->checkViewed($notice_id, $user_id)) {
			$modelConn->setViewed($notice_id, $user_id);
		}
	}

	public function getbalanceAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$shopExchange = new Shop_Models_ShopExchange();
			echo $shopExchange->getBalanceByText($_GET['id']);
		} else {
			echo "No!";
		}
		die;
	}

	public function oneminusAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$data = array(
				'user_id' => $auth_id,
				'good_id' => $_POST['id']
			);
			$basketModel = new Account_Models_Basket();
			echo $basketModel->oneMinus($data);
		} else {
			echo "No!";
		}
		die;
	}

	public function oneplusAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$data = array(
				'user_id' => $auth_id,
				'good_id' => $_POST['id']
			);
			$basketModel = new Account_Models_Basket();
			echo $basketModel->onePlus($data);
		} else {
			echo "No!";
		}
		die;
	}

	public function onedeleteAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$data = array(
				'user_id' => $auth_id,
				'good_id' => $_POST['id']
			);
			$basketModel = new Account_Models_Basket();
			echo $basketModel->oneDelete($data);
		} else {
			echo "No!";
		}
		die;
	}

	public function allbasketsummAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$data = array(
				'user_id' => $auth_id
			);
			$basketModel = new Account_Models_Basket();
			echo number_format($basketModel->getAllBasketCount($data), 0, "", " ");
		} else {
			echo "No!";
		}
		die;
	}

	public function getallpriceAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$data = array(
				'user_id' => $auth_id,
			);
			$basketModel = new Account_Models_Basket();
			$itemsInBasketCount = $basketModel->getAllBasketCount($data);
			$res = "<h4>Итого к оплате:&nbsp;&nbsp;&nbsp;&nbsp;";
			if (Engine_AuthUser::getUserType()) {
				$allPrice = $basketModel->getPriceWithDiscount($data, $_POST['id']);
				if ($allPrice == $itemsInBasketCount) {
					$res .= number_format($itemsInBasketCount, 2, ".", " ") . " руб.";
					$res .= "<input type='hidden' name='total_sum' value='" . $itemsInBasketCount . "'/>";
				} else {
					$res .= "<strike>" . number_format($itemsInBasketCount, 2, ".", " ") . " руб.</strike>&nbsp;"
						. number_format($allPrice, 2, ".", " ") . " руб. (с учётом Вашей персональной скидки)";
					$res .= "<input type='hidden' name='total_sum' value='" . $allPrice . "'/>";
				}
			} else {
				$res .= number_format($itemsInBasketCount, 2, ".", " ") . " руб.";
				$res .= "<input type='hidden' name='total_sum' value='" . $itemsInBasketCount . "'/>";
			}
			echo $res;
		} else {
			echo "No!";
		}
		die;
	}

	public function getordersaleAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$data = array(
				'user_id' => $auth_id,
			);
			$basketModel = new Account_Models_Basket();
			$itemsInBasket = $basketModel->getAllBasketGoods($data);

			$shopExchange = new Shop_Models_ShopExchange();
			if (Engine_AuthUser::getUserType()) {
				$goods1c = array();
				foreach ($itemsInBasket as $value) {
					$goods1c[] = $value['article'];
				}
				$goodsSale = $shopExchange->getPrice($goods1c, $_POST['id']);
			}

			$res = "";
			$goodsByWarehouse = $shopExchange->getItemsByWarehouse($itemsInBasket, $_POST['id']);
			if (is_array($goodsByWarehouse['near'])) {
				if (count($goodsByWarehouse['near']) > 0) {
					$res .= '<tr><td colspan="4"><h4>Ближний склад</h4></td></tr>';
				}
				foreach ($goodsByWarehouse['near'] as $key => $item) {
					$priceItem = $item['price'];
					if (Engine_AuthUser::getUserType()) {
						foreach ($goodsSale as $key => $value) {
							if ($item['article'] == $value->Product->ID) { //echo $value->Product->ID;
								$priceItem = $value->Price;
							}
						}
					}
					$res .= '<tr>';
					$res .= '<td class="col-name">' . $item['name'] . '</td>';
					$res .= '<td class="col-price">' . number_format($priceItem, 2, ".", " ") . " руб." . '</td>';
					$res .= '<td class="col-count">' . $item['basket_count'] . " шт." . '</td>';
					$res .= '<td class="col-summ">';
					$icP = $priceItem * $item['basket_count'];
					$res .= number_format($icP, 2, ".", " ") . " руб.";
					$res .= '</td>';
					$res .= '</tr>';
				}
			}
			if (is_array($goodsByWarehouse['far'])) {
				if (count($goodsByWarehouse['far']) > 0) {
					$res .= '<tr><td colspan="4"><h4>Дальний склад</h4></td></tr>';
				}
				foreach ($goodsByWarehouse['far'] as $key => $item) {
					$priceItem = $item['price'];
					if (Engine_AuthUser::getUserType()) {
						foreach ($goodsSale as $key => $value) {
							if ($item['article'] == $value->Product->ID) {
								echo $value->Product->ID;
								$priceItem = $value->Price;
							}
						}
					}
					$res .= '<tr>';
					$res .= '<td class="col-name">' . $item['name'] . '</td>';
					$res .= '<td class="col-price">' . number_format($priceItem, 2, ".", " ") . " руб." . '</td>';
					$res .= '<td class="col-count">' . $item['basket_count'] . " шт." . '</td>';
					$res .= '<td class="col-summ">';
					$icP = $priceItem * $item['basket_count'];
					$res .= number_format($icP, 2, ".", " ") . " руб.";
					$res .= '</td>';
					$res .= '</tr>';
				}
			}
			echo $res;
		} else {
			echo "No!";
		}
		die;
	}

	public function getordersalemobileAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$data = array(
				'user_id' => $auth_id,
			);
			$basketModel = new Account_Models_Basket();
			$itemsInBasket = $basketModel->getAllBasketGoods($data);
			$shopExchange = new Shop_Models_ShopExchange();
			if (Engine_AuthUser::getUserType()) {
				$goods1c = array();
				foreach ($itemsInBasket as $value) {
					$goods1c[] = $value['article'];
				}
				$goodsSale = $shopExchange->getPrice($goods1c, $_POST['id']);
			}
			$res = "";
			$goodsByWarehouse = $shopExchange->getItemsByWarehouse($itemsInBasket, $_POST['id']);
			if (is_array($goodsByWarehouse['near'])) {
				if (count($goodsByWarehouse['near']) > 0) {
					$res .= '<tr><td colspan="2"><h4>Ближний склад</h4></td></tr>';
				}
				foreach ($goodsByWarehouse['near'] as $key => $item) {
					$priceItem = $item['price'];
					if (Engine_AuthUser::getUserType()) {
						foreach ($goodsSale as $key => $value) {
							if ($item['article'] == $value->Product->ID) {
								echo $value->Product->ID;
								$priceItem = $value->Price;
							}
						}
					}
					$res .= '<tr class="border-top-m"><td class="td-bg-m">Наименование товара</td><td class="item-name">' . $item['name'] . '</td>';
					$res .= '<tr><td class="td-bg-m">Цена</td><td class="item-price">' . number_format($priceItem, 2, ".", " ") . " руб." . '</td></tr>';
					$res .= '<tr><td class="td-bg-m">Количество</td><td class="item-stock">' . $item['basket_count'] . " шт." . '</td></tr>';
					$res .= '<tr class="border-bottom-m"><td class="td-bg-m">Сумма</td><td class="item-action">';
					$icP = $priceItem * $item['basket_count'];
					$res .= number_format($icP, 2, ".", " ") . " руб.</td></tr>";
				}
			}
			if (is_array($goodsByWarehouse['far'])) {
				if (count($goodsByWarehouse['far']) > 0) {
					$res .= '<tr><td colspan="2"><h4>Дальний склад</h4></td></tr>';
				}
				foreach ($goodsByWarehouse['far'] as $key => $item) {
					$priceItem = $item['price'];
					if (Engine_AuthUser::getUserType()) {
						foreach ($goodsSale as $key => $value) {
							if ($item['article'] == $value->Product->ID) {
								echo $value->Product->ID;
								$priceItem = $value->Price;
							}
						}
					}
					$res .= '<tr class="border-top-m"><td class="td-bg-m">Наименование товара</td><td class="item-name">' . $item['name'] . '</td>';
					$res .= '<tr><td class="td-bg-m">Цена</td><td class="item-price">' . number_format($priceItem, 2, ".", " ") . " руб." . '</td></tr>';
					$res .= '<tr><td class="td-bg-m">Количество</td><td class="item-stock">' . $item['basket_count'] . " шт." . '</td></tr>';
					$res .= '<tr class="border-bottom-m"><td class="td-bg-m">Сумма</td><td class="item-action">';
					$icP = $priceItem * $item['basket_count'];
					$res .= number_format($icP, 2, ".", " ") . " руб.</td></tr>";
				}
			}
			echo $res;
		} else {
			echo "No!";
		}
		die;
	}

}
