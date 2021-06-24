<?php

class Shop_Models_OrderGoodrequisite extends Engine_Model_Abstract {

	protected $_dbTableName = 'Shop_Models_DbTable_OrderGoodrequisite';
	protected $_formTableName = 'Shop_Form_OrderGoodrequisite';
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
	public function getGoodrequisiteById($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}

	//Получить группу по id
	public function getGoodrequisiteByOnecId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`good_id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}
	
	//Есть ли группа по ID 1С
	public function getIssetGoodrequisiteByOnecId($id, $reqName) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`good_id` = ?', $id)
			->where('`requisite_name` = ?', $reqName);
		$result = $table->fetchRow($select);
		if (is_object($result)) {
			return $result['id'];
		} else {
			return false;
		}
	}
	
	//Обновление группы
	public function updateGoodrequisite($id, $data) {
        $table  = $this->getDbTable();        
        $set = array (
            'good_id' => $data['good_id'],
			'requisite_name' => $data['requisite_name'],
			'requisite_value' => $data['requisite_value']
        );
        $update = $table->update($set, array('id = ?' => $id));
    }
	
	//Обновление группы по ID из 1С
	public function updateGoodrequisiteByOnec($idOnec, $data) {
        $table  = $this->getDbTable();        
        $set = array (
            'good_id' => $data['good_id'],
			'requisite_name' => $data['requisite_name'],
			'requisite_value' => $data['requisite_value']
        );
        $update = $table->update($set, array('onec_id = ?' => $idOnec));
    }

	//Сохранить группу
	public function saveGoodrequisite($data) {
		$set = array(
			'good_id' => $data['good_id'],
			'requisite_name' => $data['requisite_name'],
			'requisite_value' => $data['requisite_value']
		);
		$this->getDbTable()->insert($set);
	}
	
	//Сохранить группу при импорте из 1С
	public function saveGoodrequisiteByOnec($data) {
		$set = array(			
			'good_id' => $data['good_id'],
			'requisite_name' => $data['requisite_name'],
			'requisite_value' => $data['requisite_value']
		);
		$this->getDbTable()->insert($set);
	}

}
