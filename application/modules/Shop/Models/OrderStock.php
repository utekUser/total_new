<?php

class Shop_Models_OrderStock extends Engine_Model_Abstract {

	protected $_dbTableName = 'Shop_Models_DbTable_OrderStock';
	protected $_formTableName = 'Shop_Form_OrderStock';
	protected $_orderBy = 'id DESC';

	public function getStock() {
		$http = new Engine_Controller_Request_Http();
		$page = $http->getParam('page');

		$table = $this->getDbTable();
		$select = $table->select()
			//->where('deleted = ?', 0)
			->order('stock_name ASC');
		$adapter = new Zend_Paginator_Adapter_DbSelect(
			$select
		);

		$paginator = new Engine_Paginator($adapter);
		$paginator->setItemCountPerPage(30);
		$paginator->setCurrentPageNumber($page);
		return $paginator;
	}

	//Получить менеджера по id
	public function getStockById($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}

	public function getStocks() {
		$table = $this->getDbTable();
		$select = $table->select()
			->order('order ASC');
		$result = $table->fetchAll($select);
		return $result;
	}

	public function getStocksByGoodId($goodId) {
		$registry = Engine_Api::getInstance();
		$db = $registry->getContainer()->db;
		$this->_tablePrefix = $registry->getContainer()->tablePrefix;
		$userPriceType = "4f69c3fc-71ad-43b8-9928-c28f1b502292";

		$select = $db->select()
			->from(
				array('d' => $this->_tablePrefix . 'shop_warehouse'), array('d.stock_name AS stock_name'))
			->joinLeft(
				array('a' => $this->_tablePrefix . 'shop_offer_warehouse'), 'd.id_onec = a.warehouse_id', array('a.count as count')
			)
			->where("a.offer_id = ?", $goodId)
			->order('a.count ASC');
		$result = $db->fetchAll($select);
		//echo "<pre>"; print_r($result); die;
		return $result;
	}

	public function getGoodCountInStocks($goodId) {
		$registry = Engine_Api::getInstance();
		$db = $registry->getContainer()->db;
		$this->_tablePrefix = $registry->getContainer()->tablePrefix;

		$select = $db->select()
			->from(
				array('d' => $this->_tablePrefix . 'shop_offer_warehouse'), array('d.count AS count'))
			->where("d.offer_id = ?", $goodId)
			->order('d.count ASC');
		$result = $db->fetchAll($select);

		$goodCount = 0;
		foreach ($result as $val) {
			$goodCount += $val['count'];
		}
		return $goodCount;
	}

	/**
	 * Оформление нового заказа
	 *
	 * @param array $data
	 */
	public function saveStock($data) {
		$set = array(
			'id_onec' => $data['id_onec'],
			'stock_name' => $data['stock_name'],
			'order' => $data['order'],
			'deleted' => $data['deleted'],
		);
		$this->getDbTable()->insert($set);
	}

	//Получить товар по id
	public function getStockByOnecId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`id_onec` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}

	//Есть ли товар по ID 1С
	public function getIssetStockByOnecId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`id_onec` = ?', $id);
		$result = $table->fetchRow($select);
		if (is_object($result)) {
			return $result['id'];
		} else {
			return false;
		}
	}

	//Обновление товара по ID из 1С
	public function updateStockByOnec($idOnec, $data) {
		$table = $this->getDbTable();
		$set = array(
			'id_onec' => $data['id_onec'],
			'stock_name' => $data['stock_name']
		);
		$update = $table->update($set, array('id_onec = ?' => $idOnec));
	}

	//Сохранить товар при импорте из 1С
	public function saveStockByOnec($data) {
		$set = array(
			'id_onec' => $data['id_onec'],
			'stock_name' => $data['stock_name']
		);
		$this->getDbTable()->insert($set);
	}

}
