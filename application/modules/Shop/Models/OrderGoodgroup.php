<?php

class Shop_Models_OrderGoodgroup extends Engine_Model_Abstract {

	protected $_dbTableName = 'Shop_Models_DbTable_OrderGoodgroup';
	protected $_formTableName = 'Shop_Form_OrderGoodgroup';
	protected $_orderBy = 'id DESC';

	public function getManager() {
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
	public function getGoodsgroupByGroupId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`group_id` = ?', $id);
		$result = $table->fetchAll($select);
		return $result;
	}
	
	//Получить список товаров по разделу каталога
	public function getCountGoodsByGroupId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`group_id` = ?', $id);
		$result = $table->fetchAll($select);
		return count($result);
	}

	//Получить список товаров по разделу каталога
	public function getGoodsByGroupId($groupId) {
		$http = new Engine_Controller_Request_Http();
        $page = $http->getParam('page');   
		
		$registry = Engine_Api::getInstance();
		$db = $registry->getContainer()->db;
		$this->_tablePrefix = $registry->getContainer()->tablePrefix;

		$userPriceType = "4f69c3fc-71ad-43b8-9928-c28f1b502292";

		/*$select = $db->select()
			->from(
				array('a' => $this->_tablePrefix . 'shop_good_group'), array('*')
			)
			->joinLeft(
				array('b' => $this->_tablePrefix . 'shop_good'), 'a.good_id = b.onec_id', array('*')
			)
			/*->joinLeft(
				array('c' => $this->_tablePrefix . 'shop_offer'), 'b.onec_id = c.onec_id', array('count AS offer_count')
			)*
			->joinLeft(
				array('d' => $this->_tablePrefix . 'shop_offer_price'), 'b.onec_id = d.offer_id', array('price AS price')
			)
			->order('b.name ASC')
			->where('a.group_id = ?', $groupId)
			->where('d.price_id = ?', $userPriceType)
			->where('b.deleted = 0');
			//->limit($limit); 
		*/
		/*$result = $db->fetchAll($select);
		return $result;*/
		
		$select = $db->select()
			->from(
				array('a' => $this->_tablePrefix . 'view_goods_wc_wp'), array('a.id', 'a.name', 'a.price', 'a.offer_count', 'a.image')
			)
			->where("a.group_id = ?", $groupId)
			->where("a.price_id = ?", $userPriceType);
		$select->order('a.price ASC');
		
		$adapter = new Zend_Paginator_Adapter_DbSelect(
            $select
        );        
        $paginator = new Engine_Paginator($adapter);
        $paginator->setItemCountPerPage(16);
        $paginator->setCurrentPageNumber($page);
		return $paginator;		
	}
	
	/*CREATE VIEW total_view_goods_wc_wp
	AS
	SELECT a.good_id, a.group_id, b.*, c.count AS offer_count, d.price_id AS price_id, d.price AS price
	FROM total_shop_good_group AS a

	LEFT JOIN total_shop_good as b
	ON a.good_id = b.onec_id

LEFT JOIN total_shop_offer as c
	ON b.onec_id = c.onec_id

LEFT JOIN total_shop_offer_price as d
	ON b.onec_id = d.offer_id

	WHERE b.deleted = '0'
ORDER BY b.name ASC*/
	
	//Получить список товаров по разделу каталога
	public function getGoodsByGroupIdWithDel($groupId) {
		$http = new Engine_Controller_Request_Http();
        $page = $http->getParam('page');   
		
		$registry = Engine_Api::getInstance();
		$db = $registry->getContainer()->db;
		$this->_tablePrefix = $registry->getContainer()->tablePrefix;

		$userPriceType = "4f69c3fc-71ad-43b8-9928-c28f1b502292";

		$select = $db->select()
			->from(
				array('a' => $this->_tablePrefix . 'shop_good_group'), array('*')
			)
			->joinLeft(
				array('b' => $this->_tablePrefix . 'shop_good'), 'a.good_id = b.onec_id', array('*')
			)
			->order('b.name ASC')
			->where('a.group_id = ?', $groupId);
			//->limit($limit); 
		
		/*$result = $db->fetchAll($select);
		return $result;*/
		
		$adapter = new Zend_Paginator_Adapter_DbSelect(
            $select
        );        
        $paginator = new Engine_Paginator($adapter);
        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($page);
		return $paginator;		
	}

	//Получить группу товара по id
	public function getGoodgroupByGoodId($goodId) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`good_id` = ?', $goodId);
		$result = $table->fetchRow($select);
		return $result;
	}
	
	//Получить группу товара по id
	public function getGoodgroupById($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}

	//Получить группу товара по id
	public function getGoodgroupByOnecId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`good_id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}

	//Есть ли группа товара по ID 1С
	public function getIssetGoodgroupByOnecId($id, $groupId) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`good_id` = ?', $id)
			->where('`group_id` = ?', $groupId);
		$result = $table->fetchRow($select);
		if (is_object($result)) {
			return $result['id'];
		} else {
			return false;
		}
	}

	//Обновление группы товара
	public function updateGoodgroup($id, $data) {
		$table = $this->getDbTable();
		$set = array(
			'good_id' => $data['good_id'],
			'group_id' => $data['group_id']
		);
		$update = $table->update($set, array('id = ?' => $id));
	}

	//Обновление группы товара по ID из 1С
	public function updateGoodgroupByOnec($idOnec, $data) {
		$table = $this->getDbTable();
		$set = array(
			'good_id' => $data['good_id'],
			'group_id' => $data['group_id']
		);
		$update = $table->update($set, array('onec_id = ?' => $idOnec));
	}

	//Сохранить группу товара
	public function saveGoodgroup($data) {
		$set = array(
			'good_id' => $data['good_id'],
			'group_id' => $data['group_id']
		);
		$this->getDbTable()->insert($set);
	}

	//Сохранить группу товара при импорте из 1С
	public function saveGoodgroupByOnec($data) {
		$set = array(
			'good_id' => $data['good_id'],
			'group_id' => $data['group_id']
		);
		$this->getDbTable()->insert($set);
	}

	//Удалить группу товара по ID товара
	public function deleteGoodgroupByGoodId($goodId) {
		$del = array(
			'`good_id` = ?' => $goodId
		);
		$this->getDbTable()->delete($del);
	}

}
