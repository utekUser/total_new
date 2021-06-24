<?php

class Shop_Models_OrderCatalogproperty extends Engine_Model_Abstract {

	protected $_dbTableName = 'Shop_Models_DbTable_OrderCatalogproperty';
	protected $_formTableName = 'Shop_Form_OrderCatalogproperty';
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

	public function getFilterProperties() {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`id` != ?', 1)
			->order('name ASC');
		$result = $table->fetchAll($select);
		return $result;
	}
	
	//Получить менеджера по id
	public function getPropertyById($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}

	//Получить группу по id
	public function getPropertyByOnecId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`onec_id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}
	
	//Есть ли группа по ID 1С
	public function getIssetPropertyByOnecId($id) {
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
	
	public function deleteAllProperties() {
		$this->getDbTable()->update(array('deleted' => 1), '');
	}
	
	//Обновление группы
	public function deletePropertyById($id) {		
        $table  = $this->getDbTable();        
        $set = array (
            'deleted' => 1
        );
        $update = $table->update($set, array('id = ?' => $id));
    }
	
	//Обновление группы
	public function updateProperty($id, $data) {
        $table  = $this->getDbTable();        
        $set = array (
            'onec_id' => $data['onec_id'],
			'name' => $data['name'],
			'type' => $data['type']
        );
        $update = $table->update($set, array('id = ?' => $id));
    }
	
	//Обновление группы по ID из 1С
	public function updatePropertyByOnec($idOnec, $data) {
        $table  = $this->getDbTable();        
        $set = array (
            'onec_id' => $data['onec_id'],
			'name' => $data['name'],
			'type' => $data['type']
        );
        $update = $table->update($set, array('onec_id = ?' => $idOnec));
    }

	//Сохранить группу
	public function saveProperty($data) {
		$set = array(
			'onec_id' => $data['onec_id'],
			'name' => $data['name'],
			'type' => $data['type']			
		);
		$this->getDbTable()->insert($set);
	}
	
	//Сохранить группу при импорте из 1С
	public function savePropertyByOnec($data) {
		$set = array(			
			'onec_id' => $data['onec_id'],
			'name' => $data['name'],
			'type' => $data['type']
		);
		$this->getDbTable()->insert($set);
	}

}
