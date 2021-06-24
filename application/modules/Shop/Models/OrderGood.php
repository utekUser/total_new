<?php

class Shop_Models_OrderGood extends Engine_Model_Abstract {

	protected $_dbTableName = 'Shop_Models_DbTable_OrderGood';
	protected $_formTableName = 'Shop_Form_OrderGood';
	protected $_orderBy = 'id DESC';

	public function getGoods() {
		$http = new Engine_Controller_Request_Http();
		$page = $http->getParam('page');

		$table = $this->getDbTable();

		$select = $table->select()
			->where('deleted = ?', 0)
			->order('id DESC');
		$adapter = new Zend_Paginator_Adapter_DbSelect(
			$select
		);

		$paginator = new Engine_Paginator($adapter);
		$paginator->setItemCountPerPage(30);
		$paginator->setCurrentPageNumber($page);

		return $paginator;
	}
	
	public function getGoodsByQuery($searchGroup = null) {
		$http = new Engine_Controller_Request_Http();
		$page = $http->getParam('page');

		$table = $this->getDbTable();

		$select = $table->select()
			->where('deleted = ?', 0)
			->order('id DESC');
		$adapter = new Zend_Paginator_Adapter_DbSelect(
			$select
		);

		$paginator = new Engine_Paginator($adapter);
		$paginator->setItemCountPerPage(30);
		$paginator->setCurrentPageNumber($page);

		return $paginator;
	}

	//Получить список товаров по разделу каталога
	public function getGoodsBySearchText($searchText, $params = null) {
		$http = new Engine_Controller_Request_Http();
        $page = $http->getParam('page');   
		
		$registry = Engine_Api::getInstance();
		$db = $registry->getContainer()->db;
		$this->_tablePrefix = $registry->getContainer()->tablePrefix;

		$userPriceType = "4f69c3fc-71ad-43b8-9928-c28f1b502292";
		
		
		if (!isset($params)) {							
			$select = $db->select()
				->from(
					array('a' => $this->_tablePrefix . 'view_goods_wc_wp'), array('a.id', 'a.name', 'a.price', 'a.offer_count', 'a.image'));				
		} else {
			$ii = 1;
			foreach ($params as $key => $value) {
				if ($ii == 1) {
					$select = $db->select()
						->from(
							array('1d' => $this->_tablePrefix . 'shop_good_property'), array('1d.name AS prop_name'));
				} else {
					$select->joinLeft(
						array($ii. 'd' => $this->_tablePrefix . 'shop_good_property'), '1d.good_id = ' . $ii . 'd.good_id', array('name AS prop_name')
					);
				}
				$whereProp = "";
				$whereProp = $ii . "d.onec_id = '" . $key . "' AND (";
				if (is_array($value)) {
					foreach ($value as $value1) {
						$whereProp .= $ii . "d.name = '" . $value1 . "' OR ";
					}						
				}
				$whereProp = substr($whereProp, 0, strlen($whereProp) - 3) . ")";
				$select->where($whereProp);
				$ii += 1;
			}
			$select->joinLeft(
				array('a' => $this->_tablePrefix . 'view_goods_wc_wp'), '1d.good_id = a.good_id', array('a.id', 'a.name', 'a.price', 'a.offer_count', 'a.image')
			);
		}	
		$select->where("a.price_id = ?", $userPriceType);
		if (strlen($searchText) > 0) {
			$select->where("(a.article LIKE '%" . $searchText . "%' OR a.name LIKE '%" . $searchText . "%')");
		}
		$select->order('a.price ASC');
		
		/*SELECT a.id, a.name, a.price, a.offer_count, a.image, 1d.name as name_prop 
		FROM `total_view_goods_wc_wp` 
		left join total_shop_good_property as 1d ON a.good_id = 1d.good_id
		WHERE (a.price_id = '4f69c3fc-71ad-43b8-9928-c28f1b502292')
		AND (1d.onec_id = '7ecedb66-d9ee-11e9-af70-2c4d5457fd19' AND (1d.name = 'f7e7f082-d9f2-11e9-af70-2c4d5457fd19' ))*/
		//echo "<pre>";		print_r($select); die;
		/*$result = $db->fetchAll($select);
		return $result;*/
		
		$adapter = new Zend_Paginator_Adapter_DbSelect(
            $select
        );        
        $paginator = new Engine_Paginator($adapter);
        $paginator->setItemCountPerPage(16);
        $paginator->setCurrentPageNumber($page);
		return $paginator;		
	}
	
	//Получить список товаров по разделу каталога
	public function getGoodsBySearchTextAjax($searchText) {
		$http = new Engine_Controller_Request_Http();
        $page = $http->getParam('page');   
		
		$registry = Engine_Api::getInstance();
		$db = $registry->getContainer()->db;
		$this->_tablePrefix = $registry->getContainer()->tablePrefix;

		$select = $db->select()
			->distinct()
			->from(
				array('a' => $this->_tablePrefix . 'shop_good'), array('name')
			)
			->where("(a.article LIKE '%" . $searchText . "%' OR a.name LIKE '%" . $searchText . "%')")
			->where("a.deleted = 0")
			->order("a.name ASC")
			->limit(10); 			
		
		$result = $db->fetchAll($select);
		return $result;	
	}
	
	//Получить товар по id
	public function getGoodById($id) {
		$registry = Engine_Api::getInstance();
		$db = $registry->getContainer()->db;
		$this->_tablePrefix = $registry->getContainer()->tablePrefix;
		$userPriceType = "4f69c3fc-71ad-43b8-9928-c28f1b502292";

		/*$select = $db->select()
			->from(
				array('a' => $this->_tablePrefix . 'shop_good'), array('a.*')
			)	
			->joinLeft(
				array('c' => $this->_tablePrefix . 'shop_offer'), 'a.onec_id = c.onec_id', array('count AS offer_count')
			)
			->joinLeft(
				array('d' => $this->_tablePrefix . 'shop_offer_price'), 'c.onec_id = d.offer_id', array('price AS price')
			)			
			->where("a.id = ?", $id)
			->where("d.price_id = ?", $userPriceType)
			->where("a.deleted = 0");*/
		
		$select = $db->select()
			->from(
				array('a' => $this->_tablePrefix . 'view_goods_wc'), array('a.*')
			)
			->where("a.id = ?", $id)
			->where("a.price_id = ?", $userPriceType);
		
		$result = $db->fetchRow($select);
		return $result;
	}

	/*CREATE VIEW total_view_goods
	AS
	SELECT a.*, d.price_id AS price_id, d.price AS price
	FROM total_shop_good AS a
	LEFT JOIN total_shop_offer_price as d
	ON a.onec_id = d.offer_id
	WHERE a.deleted = '0'
	ORDER BY RAND()
	LIMIT 5*/
	
	//Получить товары рандомно для главной страницы
	public function getGoodByRandom() {
		$registry = Engine_Api::getInstance();
		$db = $registry->getContainer()->db;
		$this->_tablePrefix = $registry->getContainer()->tablePrefix;
		$userPriceType = "4f69c3fc-71ad-43b8-9928-c28f1b502292";

		$limitRand = rand(50, 2500);
		$select = $db->select()
			->from(
				array('a' => $this->_tablePrefix . 'shop_good'), array('a.id', 'a.name', 'a.image')
			)
			->joinLeft(
				array('c' => $this->_tablePrefix . 'shop_offer'), 'a.onec_id = c.onec_id', array('c.count AS offer_count')
			)
			->joinLeft(
				array('d' => $this->_tablePrefix . 'shop_offer_price'), 'a.onec_id = d.offer_id', array('price AS price')
			)
			->where("d.price_id = ?", $userPriceType)	
			->where("a.deleted = 0")
			//->order("RAND()")
			->limit(5, $limitRand);
		
		/*$select = $db->select()
			->from(
				array('a' => $this->_tablePrefix . 'view_goods_wc_wp'), array('a.*')
			)
			->where("a.price_id = ?", $userPriceType)
			->limit(5, $limitRand);*/
		
		/*
		$select = $db->select()
			->from(
				array('a' => $this->_tablePrefix . 'view_goods'), array('a.*')
			)
			->where("a.price_id = ?", $userPriceType)
			//->order("RAND(100)")
			->limit(5, $limitRand);*/

		$result = $db->fetchAll($select);		
		return $result;
	}
	
	//Получить товар по id
	public function getOnecIdById($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result['onec_id'];
	}
	
	//Получить товар по id
	public function getOnecIdByArticleId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`article` = ?', $id);
		$result = $table->fetchRow($select);		
		return $result['id'];
	}
	
	//Получить артикул по id
	public function getArticleById($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result['article'];
	}
	
	//Получить товар по id
	public function getGoodByOnecId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`onec_id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}
	
	//Есть ли товар по ID 1С
	public function getIssetGoodByOnecId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`onec_id` = ?', $id);
		$result = $table->fetchRow($select);
		if (is_object($result)) {
			return $result['id'];
		} else {
			return false;
		}
	}
	
	//Обновление товара
	public function updateGood($id, $data) {
        $table  = $this->getDbTable();        
        $set = array (
            'article' => $data['article'],
            'onec_id' => $data['onec_id'],
			'name' => $data['name'],
			'image' => $data['image'],
			'country' => $data['country'],
			'description' => $data['description'],
			'trademark' => $data['trademark'],
			'tax' => $data['tax'],
			'weight' => $data['weight'],
			'deleted' => $data['deleted']
        );
        $update = $table->update($set, array('id = ?' => $id));
    }
	
	//Обновление товара по ID из 1С
	public function updateGoodByOnec($idOnec, $data) {
        $table  = $this->getDbTable();        
        $set = array (
            'article' => $data['article'],
            'onec_id' => $data['onec_id'],
			'name' => $data['name'],
			'image' => $data['image'],
			'country' => $data['country'],
			'description' => $data['description'],
			'trademark' => $data['trademark'],
			'tax' => $data['tax'],
			'weight' => $data['weight']
        );
        $update = $table->update($set, array('onec_id = ?' => $idOnec));
    }

	//Сохранить товар
	public function saveGood($data) {
		$set = array(
			'article' => $data['article'],
            'onec_id' => $data['onec_id'],
			'name' => $data['name'],
			'image' => $data['image'],
			'country' => $data['country'],			
			'trademark' => $data['trademark'],
			'tax' => $data['tax'],
			'weight' => $data['weight'],
			'deleted' => $data['deleted']
		);
		$this->getDbTable()->insert($set);
	}
	
	//Сохранить товар при импорте из 1С
	public function saveGoodByOnec($data) {
		$set = array(			
			'article' => $data['article'],
            'onec_id' => $data['onec_id'],
			'name' => $data['name'],
			'image' => $data['image'],
			'country' => $data['country'],			
			'trademark' => $data['trademark'],
			'tax' => $data['tax'],
			'weight' => $data['weight']
		);
		$this->getDbTable()->insert($set);
	}

}
