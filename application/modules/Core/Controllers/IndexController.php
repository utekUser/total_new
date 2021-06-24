<?php

/* ВЫВЕСТ�? В Engine_Controller url и Layout как у Zend_Controller_action */

//class Texts_Controllers_AdminController extends Engine_Controller_Action_Admin {
class Core_Controllers_IndexController extends Core_Controller_Action_User {

	protected $_pageId;
	protected $_form = array(
//        'Texts_Form_Texts'
	); // Классы дял создания и/или обновления таблиц в БД

	/**
	 * Инициализация
	 *
	 */

	public function init() {
		exit;
	}

	public function setId($id) {
		$this->_pageId = $id;
	}

	/**
	 * Главная, листинг
	 *
	 */
	public function indexAction() {
		if (isset($_GET['callme']) && (count($_POST) > 0)) {
			$url = 'https://www.google.com/recaptcha/api/siteverify';
			$secret = '6LfqKxQUAAAAAJny0CZpvW6-t-pRtxxoujwoZf-u';
			if (isset($_POST['g-recaptcha-response'])) {
				$recaptcha = $_POST['g-recaptcha-response'];
			}
			$ip = $_SERVER['REMOTE_ADDR'];
			$url_data = $url . '?secret=' . $secret . '&response=' . $recaptcha . '&remoteip=' . $ip;
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url_data);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$res = curl_exec($curl);
			curl_close($curl);
			$res = json_decode($res);

			if ($res->success) {
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=utf-8\r\n";
				$subject = "Письмо с сайта Total - Заказать обратный звонок";
				$message = '<html><head><title>' . $subject . '</title></head><body>
							<p>Уважаемый, Администратор!</p>
							<p>В раздел "Заказать обратный звонок" поступила новая заявка:</p>
							<strong>Контактное лицо: </strong> ' . $_POST['callmenametotalby'] . '<br>
							<strong>Телефон:</strong> ' . $_POST['callmephonetotalby'] . '<br>';

				$mod = new Callme_Models_Callme();
				$data['name'] = $_POST['callmenametotalby'];
				$data['phone'] = $_POST['callmephonetotalby'];
				if (isset($_POST['callmecommenttotalby'])) {
					$data['comment'] = $_POST['callmecommenttotalby'];
					$headers .= "From: Томавтотрейд - Заказать обратный звонок <no-reply@total.tomsk.ru>\r\n";
					$message .= '<strong>Сообщение:</strong> ' . $_POST['callmecommenttotalby'] . '<br>';
				} else {
					$headers .= "From: Томавтотрейд - Обратная связь <no-reply@total.tomsk.ru>\r\n";
				}
				$mod->saveCallorder($data);

				$message .= '<p>____________________________________________</p></body></html>';
				$mailReplay = Engine_Cms::setupValue('callme');
				$to = explode(',', $mailReplay); //array('turkov.dm@yandex.ru');
				if (!is_array($to)) {
					$to = array($to);
				}
				foreach ($to as $email) {
					mail($email, $subject, $message, mb_convert_encoding($headers, 'windows-1251', mb_detect_encoding($headers)));
				}
			}
		}

		if (strlen($this->_pageId) > 0) {
			$get = new Sitemap_Models_Sitemap();
			$page = $get->getPageById($this->_pageId);
			$this->view->breadCrumbs = array(
				"/" => "Главная",
				$page['url'] => $page['header']
			);
			$this->view->pageTitle = $page['header'];
			$this->view->text = $get->getContent($this->_pageId);
		}
		$makerModel = new Shop_Models_OrderMaker();
		$this->view->makersMain = $makerModel->getMakersForMainPage();
		$_SESSION['UrlAfterAutorize'] = $_SERVER['REQUEST_URI'];
	}

}
