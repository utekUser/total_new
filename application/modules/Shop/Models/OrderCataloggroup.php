<?php

class Shop_Models_OrderCataloggroup extends Engine_Model_Abstract {

	protected $_dbTableName = 'Shop_Models_DbTable_OrderCataloggroup';
	protected $_formTableName = 'Shop_Form_OrderCataloggroup';
	protected $_orderBy = 'id DESC';

	public function getGroup() {
		$http = new Engine_Controller_Request_Http();
		$page = $http->getParam('page');

		$table = $this->getDbTable();

		$select = $table->select()
			->where('deleted = ?', 0)
			->order('title ASC');
		$adapter = new Zend_Paginator_Adapter_DbSelect(
			$select
		);

		$paginator = new Engine_Paginator($adapter);
		$paginator->setItemCountPerPage(30);
		$paginator->setCurrentPageNumber($page);

		return $paginator;
	}
	
	public function getManagers() {
		$table = $this->getDbTable();
		$select = $table->select()
			->order('title ASC');
		$result = $table->fetchAll($select);
		return $result;
	}
	
	public function getGroupsForMenuNoDel() {
		$g = $this->getGroupsByParentIdNoDel();
		$groups = array();
		foreach ($g as $value) {
			$groups[$value['link']] = array(
				"title" => $value['title'],
				"id" => $value['onec_id']
			); 
			$parG = $this->getGroupsByParentIdNoDel($value['onec_id']);
			foreach ($parG as $parValue) {
				$groups[$value['link']]["children"][$parValue['link']] = array(
					"title" => $parValue['title'],
					"id" => $parValue['onec_id']					
				);
				$parGG = $this->getGroupsByParentIdNoDel($parValue['onec_id']);
				foreach ($parGG as $parParValue) {
					$groups[$value['link']]["children"][$parValue['link']]["children"][$parParValue['link']] = $parParValue['title'];
				}
			}
		}
		return $groups;
	}
	
	public function getGroupsByParentIdNoDel($parentId = "") {
		$table = $this->getDbTable();		
		$select = $table->select()
			->where('parent_id = ?', $parentId)
			->where('deleted = ?', 0)
			->order('title ASC');
		$result = $table->fetchAll($select);
		return $result;
	}	
	
	public function getCountGroupsByParentIdNoDel($parentId = "") {
		$table = $this->getDbTable();		
		$select = $table->select()
			->where('parent_id = ?', $parentId)
			->where('deleted = ?', 0)
			->order('title ASC');
		$result = $table->fetchAll($select);
		return count($result);
	}	
	
	public function getGroupsForMenu() {
		$g = $this->getGroupsByParentId();
		$groups = array();
		foreach ($g as $value) {
			$groups[$value['link']] = array(
				"title" => $value['title'],
				"id" => $value['onec_id']
			); 
			$parG = $this->getGroupsByParentId($value['onec_id']);
			foreach ($parG as $parValue) {
				$groups[$value['link']]["children"][$parValue['link']] = array(
					"title" => $parValue['title'],
					"id" => $parValue['onec_id']					
				);
				$parGG = $this->getGroupsByParentId($parValue['onec_id']);
				foreach ($parGG as $parParValue) {
					$groups[$value['link']]["children"][$parValue['link']]["children"][$parParValue['link']] = $parParValue['title'];
				}
			}
		}
		return $groups;
	}
	
	public function getGroupsByParentId($parentId = "") {
		$table = $this->getDbTable();		
		$select = $table->select()
			->where('parent_id = ?', $parentId)
			->order('title ASC');
		$result = $table->fetchAll($select);
		return $result;
	}
	
	//Получить группу по link
	public function getGroupByLink($link) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`link` = ?', $link);
		$result = $table->fetchRow($select);
		return $result;
	}
	
	//Получить группу по id
	public function getGroupByOnecId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`onec_id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}
	
	//Есть ли группа по ID 1С
	public function getIssetGroupByOnecId($id) {
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
	public function updateGroup($id, $data) {
        $table  = $this->getDbTable();        
        $set = array (
            'parent_id' => $data['parent_id'],
			'onec_id' => $data['onec_id'],
			'title' => $data['title'],
			'link' => $data['link'],
			'deleted' => $data['deleted']
        );
        $update = $table->update($set, array('id = ?' => $id));
    }
	
	//Обновление группы по ID из 1С
	public function updateGroupByOnec($idOnec, $data) {
        $table  = $this->getDbTable();        
        $set = array (
            'parent_id' => $data['parent_id'],
			'onec_id' => $data['onec_id'],
			'title' => $data['title']
        );
        $update = $table->update($set, array('onec_id = ?' => $idOnec));
    }

	//Сохранить группу
	public function saveGroup($data) {
		$set = array(
			'parent_id' => $data['parent_id'],
			'onec_id' => $data['onec_id'],
			'title' => $data['title'],
			'link' => $data['link'],
			'deleted' => $data['deleted']
		);
		$this->getDbTable()->insert($set);
	}
	
	//Сохранить группу при импорте из 1С
	public function saveGroupByOnec($data) {
		$set = array(
			'parent_id' => $data['parent_id'],
			'onec_id' => $data['onec_id'],
			'title' => $data['title'],
			'link' => "",
			'deleted' => 0
		);
		$this->getDbTable()->insert($set);
	}
}
