<?php

class Shop_Models_OrderGoodproperty extends Engine_Model_Abstract {

	protected $_dbTableName = 'Shop_Models_DbTable_OrderGoodproperty';
	protected $_formTableName = 'Shop_Form_OrderGoodproperty';
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

	//Получить свойство товара по id
	public function getGoodpropertyById($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}

	//Получить свойство товара по id
	public function getGoodpropertyByOnecId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`onec_id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}
	
	//Есть ли свойство товара по ID 1С
	public function getIssetGoodpropertyByOnecId($id, $oneCId) {
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
	
	//Обновление свойство товара
	public function updateGoodproperty($id, $data) {
        $table  = $this->getDbTable();        
        $set = array (
            'good_id' => $data['good_id'],
			'onec_id' => $data['onec_id'],
			'name' => $data['name']
        );
        $update = $table->update($set, array('id = ?' => $id));
    }
	
	//Обновление свойство товара по ID из 1С
	public function updateGoodpropertyByOnec($idOnec, $data) {
        $table  = $this->getDbTable();        
        $set = array (
            'good_id' => $data['good_id'],
			'onec_id' => $data['onec_id'],
			'name' => $data['name']
        );
        $update = $table->update($set, array('onec_id = ?' => $idOnec));
    }

	//Сохранить свойство товара
	public function saveGoodproperty($data) {
		$set = array(
			'good_id' => $data['good_id'],
			'onec_id' => $data['onec_id'],
			'name' => $data['name']
		);
		$this->getDbTable()->insert($set);
	}
	
	//Сохранить свойство товара при импорте из 1С
	public function saveGoodpropertyByOnec($data) {
		$set = array(			
			'good_id' => $data['good_id'],
			'onec_id' => $data['onec_id'],
			'name' => $data['name']
		);
		$this->getDbTable()->insert($set);
	}

}
