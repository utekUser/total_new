<?php

class Shop_Models_OrderOfferprice extends Engine_Model_Abstract {

	protected $_dbTableName = 'Shop_Models_DbTable_OrderOfferprice';
	protected $_formTableName = 'Shop_Form_OrderOfferprice';
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

	//Получить менеджера по id
	public function getOfferpriceById($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}

	//Получить группу по id
	public function getOfferpriceByOnecId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`onec_id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}

	//Есть ли группа по ID 1С
	public function getIssetOfferpriceByOnecId($id, $priceId) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`offer_id` = ?', $id)
			->where('`price_id` = ?', $priceId);
		$result = $table->fetchRow($select);
		if (is_object($result)) {
			return $result['id'];
		} else {
			return false;
		}
	}

	//Обновление группы
	public function updateOfferprice($id, $data) {
		$table = $this->getDbTable();
		$set = array(
			'offer_id' => $data['offer_id'],
			'price_id' => $data['price_id'],
			'price_view' => $data['price_view'],
			'price' => $data['price'],
			'currency' => $data['currency'],
			'unit' => $data['unit'],
			'coef' => $data['coef']
		);
		$update = $table->update($set, array('id = ?' => $id));
	}

	//Обновление группы по ID из 1С
	public function updateOfferpriceByOnec($idOnec, $data) {
		$table = $this->getDbTable();
		$set = array(
			'offer_id' => $data['offer_id'],
			'price_id' => $data['price_id'],
			'price_view' => $data['price_view'],
			'price' => $data['price'],
			'currency' => $data['currency'],
			'unit' => $data['unit'],
			'coef' => $data['coef']
		);
		$update = $table->update($set, array(
			'offer_id = ?' => $idOnec,
			'price_id = ?' => $data['price_id']
		));
	}

	//Сохранить группу
	public function saveOfferprice($data) {
		$set = array(
			'offer_id' => $data['offer_id'],
			'price_id' => $data['price_id'],
			'price_view' => $data['price_view'],
			'price' => $data['price'],
			'currency' => $data['currency'],
			'unit' => $data['unit'],
			'coef' => $data['coef']
		);
		$this->getDbTable()->insert($set);
	}

	//Сохранить группу при импорте из 1С
	public function saveOfferpriceyOnec($data) {
		$set = array(
			'offer_id' => $data['offer_id'],
			'price_id' => $data['price_id'],
			'price_view' => $data['price_view'],
			'price' => $data['price'],
			'currency' => $data['currency'],
			'unit' => $data['unit'],
			'coef' => $data['coef']
		);
		$this->getDbTable()->insert($set);
	}

}
