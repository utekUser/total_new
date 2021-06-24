<?php

class Shop_Models_OrderOffer extends Engine_Model_Abstract {

	protected $_dbTableName = 'Shop_Models_DbTable_OrderOffer';
	protected $_formTableName = 'Shop_Form_OrderOffer';
	protected $_orderBy = 'id DESC';

	public function getOffers() {
		$http = new Engine_Controller_Request_Http();
		$page = $http->getParam('page');

		$table = $this->getDbTable();

		$select = $table->select()
			//->where('deleted = ?', 0)
			->order('name ASC');
		$adapter = new Zend_Paginator_Adapter_DbSelect(
			$select
		);

		$paginator = new Engine_Paginator($adapter);
		$paginator->setItemCountPerPage(30);
		$paginator->setCurrentPageNumber($page);

		return $paginator;
	}

	//Получить менеджера по id
	public function getOfferById($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}

	//Получить группу по id
	public function getOfferByOnecId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`onec_id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}

	//Есть ли группа по ID 1С
	public function getIssetOfferByOnecId($id) {
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

	//Обновление группы
	public function updateOffer($id, $data) {
		$table = $this->getDbTable();
		$set = array(
			'onec_id' => $data['onec_id'],
			'article' => $data['article'],
			'name' => $data['name'],
			'weight' => $data['weight'],
			'count' => $data['count'],
			'deleted' => $data['deleted']
		);
		$update = $table->update($set, array('id = ?' => $id));
	}

	//Обновление группы по ID из 1С
	public function updateOfferByOnec($idOnec, $data) {
		$table = $this->getDbTable();
		$set = array(
			'onec_id' => $data['onec_id'],
			'article' => $data['article'],
			'name' => $data['name'],
			'weight' => $data['weight'],
			'count' => $data['count']
		);
		$update = $table->update($set, array('onec_id = ?' => $idOnec));
	}

	//Сохранить группу
	public function saveOffer($data) {
		$set = array(
			'onec_id' => $data['onec_id'],
			'article' => $data['article'],
			'name' => $data['name'],
			'weight' => $data['weight'],
			'count' => $data['count'],
			'deleted' => $data['deleted']
		);
		$this->getDbTable()->insert($set);
	}

	//Сохранить группу при импорте из 1С
	public function saveOfferByOnec($data) {
		$set = array(
			'onec_id' => $data['onec_id'],
			'article' => $data['article'],
			'name' => $data['name'],
			'weight' => $data['weight'],
			'count' => $data['count']
		);
		$this->getDbTable()->insert($set);
	}

}
