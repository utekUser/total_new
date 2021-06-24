<?php

class Shop_Models_OrderOfferwarehouse extends Engine_Model_Abstract {

	protected $_dbTableName = 'Shop_Models_DbTable_OrderOfferwarehouse';
	protected $_formTableName = 'Shop_Form_OrderOfferwarehouse';
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
	public function getOfferwarehouseById($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}

	//Получить группу по id
	public function getOfferwarehouseByOnecId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`offer_id` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}
	
	//Есть ли группа по ID 1С
	public function getIssetOfferwarehouseByOnecId($id, $stockId) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`offer_id` = ?', $id)
			->where('`warehouse_id` = ?', $stockId);
		$result = $table->fetchRow($select);
		if (is_object($result)) {
			return $result['id'];
		} else {
			return false;
		}
	}
	
	//Обновление группы
	public function updateOfferwarehouse($id, $data) {
        $table  = $this->getDbTable();        
        $set = array (
            'offer_id' => $data['offer_id'],
			'warehouse_id' => $data['warehouse_id'],
			'count' => $data['count']
        );
        $update = $table->update($set, array('id = ?' => $id));
    }
	
	//Обновление группы по ID из 1С
	public function updateOfferwarehouseByOnec($idOnec, $data) {
        $table  = $this->getDbTable();        
        $set = array (            
			'count' => $data['count']
        );
        $update = $table->update($set, array(
			'offer_id = ?' => $idOnec,
			'warehouse_id = ?' => $set['warehouse_id']));
    }

	//Сохранить группу
	public function saveOfferwarehouse($data) {
		$set = array(
			'offer_id' => $data['offer_id'],
			'warehouse_id' => $data['warehouse_id'],
			'count' => $data['count']
		);
		$this->getDbTable()->insert($set);
	}
	
	//Сохранить группу при импорте из 1С
	public function saveOfferwarehouseByOnec($data) {
		$set = array(			
			'offer_id' => $data['offer_id'],
			'warehouse_id' => $data['warehouse_id'],
			'count' => $data['count']
		);
		$this->getDbTable()->insert($set);
	}

}
