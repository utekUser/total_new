<?php

class Shop_Models_OrderGoodmaker extends Engine_Model_Abstract {

	protected $_dbTableName = 'Shop_Models_DbTable_OrderGoodmaker';
	protected $_formTableName = 'Shop_Form_OrderGoodmaker';
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

	//Получить изготовителя по id
	public function getGoodmakerById($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}

	//Получить изготовителя по id
	public function getGoodmakerByOnecId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`onec_id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}
	
	//Есть ли изготовитель товара по ID 1С
	public function getIssetGoodmakerByOnecId($id, $oneCId) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`good_id` = ?', $id)
			->where('`onec_id` = ?', $oneCId);
		$result = $table->fetchRow($select);
		if (is_object($result)) {
			return $result['id'];
		} else {
			return false;
		}
	}
	
	//Обновление изготовителя
	public function updateGoodmaker($id, $data) {
        $table  = $this->getDbTable();        
        $set = array (
            'good_id' => $data['good_id'],
			'onec_id' => $data['onec_id'],
			'name' => $data['name'],
			'deleted' => $data['deleted']
        );
        $update = $table->update($set, array('id = ?' => $id));
    }
	
	//Обновление изготовителя по ID из 1С
	public function updateGoodmakerByOnec($idOnec, $data) {
        $table  = $this->getDbTable();        
        $set = array (
            'good_id' => $data['good_id'],
			'onec_id' => $data['onec_id'],
			'name' => $data['name']
        );
        $update = $table->update($set, array('onec_id = ?' => $idOnec));
    }

	//Сохранить изготовителя
	public function saveGoodmaker($data) {
		$set = array(
			'good_id' => $data['good_id'],
			'onec_id' => $data['onec_id'],
			'name' => $data['name'],
			'deleted' => $data['deleted']
		);
		$this->getDbTable()->insert($set);
	}
	
	//Сохранить изготовителя при импорте из 1С
	public function saveGoodmakerByOnec($data) {
		$set = array(			
			'good_id' => $data['good_id'],
			'onec_id' => $data['onec_id'],
			'name' => $data['name']
		);
		$this->getDbTable()->insert($set);
	}

}
