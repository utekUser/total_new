<?php

class Shop_controllers_IndexController extends Core_Controller_Action_User {

	public function init() {
		$this->_redirector = $this->_helper->getHelper('Redirector');
		$this->pageId = $this->_getParam('urlToInt');
		if ($this->pageId) {
			Core_Controller_Action_User::setViewMain('view');
			Core_Controller_Action_User::setDefaultParseUrlAction('view');
		}
	}

	public function indexAction() {
		$propertyModel = new Shop_Models_OrderCatalogproperty();
		$properties = $propertyModel->getFilterProperties();
		$propArr = array();
		foreach ($properties as $key => $value) {
			$propArr[$value['onec_id']] = array();
			$propArr[$value['onec_id']]['name'] = $value['name'];

			$valueModel = new Shop_Models_OrderCatalogpropertyvalue();
			$values = $valueModel->getFilterValues($value['onec_id']);
			foreach ($values as $key1 => $value1) {
				$propArr[$value['onec_id']]['values'][$value1['onec_id']] = $value1['name'];
			}
		}
		$this->view->propArr = $propArr;

		$path = preg_replace('/\/catalog/', '', $_SERVER['REQUEST_URI']);
		$url = explode('?', $path);
		$url = explode('/', $url[0]);
		
		$filterArray = array(
			"lubrications",
			"oils",
			"those-liquids"
		);		
		$this->view->showFilter = false;
		if (in_array($url[1], $filterArray) || is_array($_GET['param'])) {
			$this->view->showFilter = true;
		}
		
		$_SESSION['UrlAfterAutorize'] = $_SERVER['REQUEST_URI'];
		$this->view->itIsCatalog = true;
		if ($url[1] == "good") {
			$this->view->itIsGood = true;

			$getGoodId = explode("-", $path);
			$goodId = explode(".html", $getGoodId[count($getGoodId) - 1]);
			$goodModel = new Shop_Models_OrderGood();
			$this->view->good = $good = $goodModel->getGoodById($goodId[0]);
			
			$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
			$auth_id = $auth->getIdentity();		
			if (isset($auth_id)) {
				$data = array(
					'user_id' => $auth_id,
					'good_id' => $goodId[0]				
				);
				$basketModel = new Account_Models_Basket();
				$inBasket = $basketModel->getBasketByData($data);
			} else {
				$inBasket = "No!";
			}
			$this->view->inBasket = $inBasket;

			$groupGoodModel = new Shop_Models_OrderGoodgroup();
			$groupGood = $groupGoodModel->getGoodgroupByGoodId($good['onec_id']);

			$groupModel = new Shop_Models_OrderCataloggroup();
			$group = $groupModel->getGroupByOnecId($groupGood['group_id']);
			if ($group['parent_id'] != "") {
				$group2 = $groupModel->getGroupByOnecId($group['parent_id']);
			}
			if ($group2['parent_id'] != "") {
				$group3 = $groupModel->getGroupByOnecId($group2['parent_id']);
			}
			if ($group3['parent_id'] != "") {
				$group4 = $groupModel->getGroupByOnecId($group3['parent_id']);
			}			
			$breadCrumbs = array();
			$breadCrumbs["/"] = "Главная";
			$subLink = "/catalog/";			
			if (isset($group4)) {
				$breadCrumbs[$subLink . $group4['link'] . "/"] = $group4['title'];
				$subLink .= $group4['link'] . "/";
			}
			if (isset($group3)) {
				$breadCrumbs[$subLink . $group3['link'] . "/"] = $group3['title'];
				$subLink .= $group3['link'] . "/";
			}
			if (isset($group2)) {
				$breadCrumbs[$subLink . $group2['link'] . "/"] = $group2['title'];
				$subLink .= $group2['link'] . "/";
			}
			if (isset($group)) {
				$breadCrumbs[$subLink . $group['link'] . "/"] = $group['title'];				
			}
			$goodLink = "/catalog/good/" . $this->translit($good['name']) . "-" . $good['id'] . ".html";
			$breadCrumbs[$goodLink] = $good['name'];
			$this->view->goodCategory = $group['title'];
			$this->view->breadCrumbs = $breadCrumbs;
			$this->view->pageTitle = $good['name'];
		} else if ($url[1] == "search") {
			$this->view->itIsSearch = true;
			$breadCrumbs = array();
			$breadCrumbs["/"] = "Главная";
			if (isset($_GET['catalog-search-text'])) {
				$addParam = "&";
				if (isset($_GET['param'])) {
					foreach ($_GET['param'] as $key => $value) {
						if (is_array($value)) {
							foreach ($value as $value1) {
								$addParam .= "param%5B" . $key . "%5D%5B%5D=" . $value1 . "&";
							}
						}
					}
				}
				$breadCrumbs["/catalog/search/?catalog-search-text=" . $_GET['catalog-search-text'] . $addParam] = "Результаты поиска";
				$goodModel = new Shop_Models_OrderGood();
				$this->view->goods = $goodModel->getGoodsBySearchText($_GET['catalog-search-text'], $_GET['param']);
			}
			$this->view->breadCrumbs = $breadCrumbs;
			if ($_GET['catalog-search-text'] != "") {
				$this->view->pageTitle = "Результаты поиска по запросу <strong>&laquo;" . $_GET['catalog-search-text'] . "&raquo;</strong>";
			} else {
				$this->view->pageTitle = "Результаты поиска по запросу";
			}
		} else if ($url[1] == "maker") {
			$this->view->itIsMaker = true;
			$makerModel = new Shop_Models_OrderMaker();
			$this->view->maker = $maker = $makerModel->getMakerByLink($url[2]);
			$breadCrumbs = array();
			$breadCrumbs["/"] = "Главная";
			$breadCrumbs["/catalog/maker/" . $maker['link'] . "/"] = "Компания - &laquo;" . $maker['name'] . "&raquo;";
			$this->view->pageTitle = "Компания - &laquo;" . $maker['name'] . "&raquo;";
			$this->view->breadCrumbs = $breadCrumbs;
		} else {
			$groupModel = new Shop_Models_OrderCataloggroup();
			if ($url[1] == "") {
				$url[1] = "oils";
			}
			if ($url[count($url) - 2] == "") {
				$url[2] = "";
			}
			$group = $groupModel->getGroupByLink($url[count($url) - 2]);
			$goodGroupModel = new Shop_Models_OrderGoodgroup();
			$this->view->goods = $goodGroupModel->getGoodsByGroupId($group['onec_id']);

			$firstGroup = $groupModel->getGroupByLink($url[1]);
			$pageTitle = $firstGroup['title'];
			$breadCrumbs = array();
			$breadCrumbs["/"] = "Главная";
			$subLink = "/catalog/";
			$breadCrumbs[$subLink . $firstGroup['link'] . "/"] = $firstGroup['title'];
			$subLink .= $firstGroup['link'] . "/";

			if (count($url) > 3) {
				$secondGroup = $groupModel->getGroupByLink($url[2]);
				$breadCrumbs[$subLink . $secondGroup['link'] . "/"] = $secondGroup['title'];
				$pageTitle = $secondGroup['title'];
				$subLink .= $secondGroup['link'] . "/";
			}
			if (count($url) > 4) {
				$thirdGroup = $groupModel->getGroupByLink($url[3]);
				$breadCrumbs[$subLink . $thirdGroup['link'] . "/"] = $thirdGroup['title'];
				$pageTitle = $thirdGroup['title'];
				$subLink .= $thirdGroup['link'] . "/";
			}
			if (count($url) > 5) {
				$fourthGroup = $groupModel->getGroupByLink($url[4]);
				$breadCrumbs[$subLink . $fourthGroup['link'] . "/"] = $fourthGroup['title'];
				$pageTitle = $fourthGroup['title'];
				$subLink .= $fourthGroup['link'] . "/";
			}

			$parG = $groupModel->getGroupsByParentIdNoDel($group['onec_id']);
			$groups = array();
			foreach ($parG as $key => $value) {
				$groups[] = array(
					'link' => $value['link'],
					'title' => $value['title'],
					'countGoods' => $goodGroupModel->getCountGoodsByGroupId($value['onec_id']),
					'countGroups' => $groupModel->getCountGroupsByParentIdNoDel($value['onec_id'])
				);
			}
			$this->view->groups = $groups;
			$this->view->breadCrumbs = $breadCrumbs;
			$this->view->pageTitle = $pageTitle;
			$this->view->subLinkBeforeThis = $subLink;
		}
	}

	public function mainajaxAction() {
		$goodModel = new Shop_Models_OrderGood();
		$goodsRandom = $goodModel->getGoodByRandom();
		echo $this->getHtmlGoods($goodsRandom);
		die;
	}
	
	public function searchajaxAction() {
		$goodModel = new Shop_Models_OrderGood();
		$goods = $goodModel->getGoodsBySearchTextAjax($_GET['catalog-search-text']);
		$list = "";
		foreach ($goods as $key => $value) {
			$list .= "\n<li>" . $value['name'] . "</li>";
		}
		echo $list;
		die;
	}
	
	public function getHtmlGoods($goodsRandom) {
		$return = "";
		foreach ($goodsRandom as $good) {
			$return .= '<div class="btn-group good-border hidden-xs">';
			$goodLink = "/catalog/good/" . $this->translit($good['name']) . "-" . $good['id'] . ".html";
			$return .= '<div class="col-sm-12 good-info good">';
			$return .= '<div class="favourites-star">';
			$return .= '<img class="add-favourites" id="add-favourites-' . $good['id'] . '" src="/themes/default/responsiveDesign/images/star2.webp" />';
			$return .= '</div>';
			$return .= '<a href=" ' . $goodLink . '">';
			$imgLink = "/themes/default/responsiveDesign/images/no_photo.webp";
			if ($good['image'] != "") {
				$imgLink = "/public/catalog/" . $good['image'];
			}
			$return .= '<img class="good-img" height="130" alt="' . $good['name'] . '" src="' . $imgLink . '" />';
			$return .= '</a>';
			$return .= '<a href="' . $goodLink . '" class="good-link">' . $good['name'] . '</a>';
			$return .= '<p class="count-text">В наличии: <span class="count-number">' . number_format($good['offer_count'], 0, "", " ") . '</span> шт.</p>';
			$return .= '<p class="price-text"><span class="price-number">' . number_format($good['price'], 0, "", " ") . '</span> руб.</p>';
			$return .= '<div class="to-basket">';
			$return .= '<a class="add-to-basket" id="add-to-basket-' . $good['id'] . '">В корзину</a>';
			$return .= '</div>';
			$return .= '</div>';
			$return .= '</div>';
		}
		foreach ($goodsRandom as $good) {
			$return .= '<div class="good-border visible-xs-block">';			
				$goodLink = "/catalog/good/" . $this->translit($good['name']) . "-" . $good['id'] . ".html";
				$return .= '<div class="col-sm-12 good-info good good-mobile">';
					$return .= '<div class="col-xs-5 padding-l0">';
						$return .= '<div class="favourites-star">';
						$return .= '<img class="add-favourites" id="add-favourites-' . $good['id'] . '" src="/themes/default/responsiveDesign/images/star2.webp" />';
						$return .= '</div>';
						$return .= '<a href=" ' . $goodLink . '">';
						$imgLink = "/themes/default/responsiveDesign/images/no_photo.webp";
						if ($good['image'] != "") {
							$imgLink = "/public/catalog/" . $good['image'];
						}
						$return .= '<img class="good-img" alt="' . $good['name'] . '" src="' . $imgLink . '" />';
						$return .= '</a>';
					$return .= '</div>';
					$return .= '<div class="col-xs-7 padding-lr-0">';
						$return .= '<a href="' . $goodLink . '" class="good-link">' . $good['name'] . '</a>';
						$return .= '<p class="count-text">В наличии: <span class="count-number">' . number_format($good['offer_count'], 0, "", " ") . '</span> шт.</p>';
						$return .= '<p class="price-text"><span class="price-number">' . number_format($good['price'], 0, "", " ") . '</span> руб.</p>';
						$return .= '<div class="to-basket">';
						$return .= '<a class="add-to-basket" id="add-to-basket-' . $good['id'] . '">В корзину</a>';
						$return .= '</div>';
					$return .= '</div>';
				$return .= '</div>';
			$return .= '</div>';
		}
		return $return;
	}

	public function translit($s) {
		$s = (string) $s;
		$s = strip_tags($s);
		$s = str_replace(array("\n", "\r"), " ", $s);
		$s = preg_replace("/\s+/", ' ', $s);
		$s = trim($s);
		$s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s);
		$s = strtr($s, array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => ''));
		$s = preg_replace("/[^0-9a-z-_ ]/i", "", $s);
		$s = str_replace(" ", "-", $s);
		return $s;
	}

	public function desiredAction() {
		if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] != 'xmlhttprequest')) {
			exit;
		}
		$method = $_SERVER['REQUEST_METHOD'];
		switch ($method) {
			case 'POST':
				$request = $this->getRequest();
				$name = $request->getPost('catalog-search-text');
				$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
				$user = $auth->getIdentity();
				$shop = new Shop_Models_DesiredProduct();
				$shop->addProduct($name, $user);
				header('Content-type: application/json');
				echo json_encode(array('status' => 'ok', 'data' => $shop->getProductForJson($user)));
				break;
			case 'GET':
				break;
			case 'PUT':
				break;
			case 'DELETE':
				$url = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
				$desired = $url[3];
				$shop = new Shop_Models_DesiredProduct();
				$shop->deleteProduct($desired);
				header('Content-type: application/json');
				echo json_encode(array('status' => 'ok'));
				break;
		}
		exit;
	}

}
