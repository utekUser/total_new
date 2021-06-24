<?php

class Shop_Models_OrderCatalogpropertyvalue extends Engine_Model_Abstract {

	protected $_dbTableName = 'Shop_Models_DbTable_OrderCatalogpropertyvalue';
	protected $_formTableName = 'Shop_Form_OrderCatalogpropertyvalue';
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

	public function getFilterValues($parentId) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`parent_id` = ?', $parentId)
			->order('name ASC');
		$result = $table->fetchAll($select);
		return $result;
	}
	
	//Получить менеджера по id
	public function getPropertyValueById($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}

	//Получить группу по id
	public function getPropertyValueByOnecId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`onec_id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}
	
	//Есть ли группа по ID 1С
	public function getIssetPropertyValueByOnecId($id) {
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
	public function updatePropertyValue($id, $data) {
        $table  = $this->getDbTable();        
        $set = array (
            'parent_id' => $data['parent_id'],
            'onec_id' => $data['onec_id'],
			'name' => $data['name'],
			'deleted' => $data['deleted']
        );
        $update = $table->update($set, array('id = ?' => $id));
    }
	
	//Обновление группы по ID из 1С
	public function updatePropertyValueByOnec($idOnec, $data) {
        $table  = $this->getDbTable();        
        $set = array (
            'parent_id' => $data['parent_id'],
            'onec_id' => $data['onec_id'],
			'name' => $data['name']
        );
        $update = $table->update($set, array('onec_id = ?' => $idOnec));
    }

	//Сохранить группу
	public function savePropertyValue($data) {
		$set = array(
			'parent_id' => $data['parent_id'],
			'onec_id' => $data['onec_id'],
			'name' => $data['name'],
			'deleted' => $data['deleted']
		);
		$this->getDbTable()->insert($set);
	}
	
	//Сохранить группу при импорте из 1С
	public function savePropertyValueByOnec($data) {
		$set = array(			
			'parent_id' => $data['parent_id'],
			'onec_id' => $data['onec_id'],
			'name' => $data['name']
		);
		$this->getDbTable()->insert($set);
	}

}
