<?php

class Callme_Models_Callme extends Engine_Model_Abstract {

	protected $_dbTableName = 'Callme_Models_DbTable_Callme';
	protected $_formTableName = 'Callme_Form_Callme';
	protected $_formTable = 'Callme_Form_Callme';
	protected $_orderBy = 'date';

	public function getAllCallmes() {
		$http = new Engine_Controller_Request_Http();
		$page = $http->getParam('page');
		$table = $this->getDbTable();
		$select = $table->select()
			->order('date DESC');
		$adapter = new Zend_Paginator_Adapter_DbSelect($select);
		$paginator = new Engine_Paginator($adapter);
		$paginator->setItemCountPerPage(25);
		$paginator->setCurrentPageNumber($page);
		return $paginator;
	}

	public function saveCallorder($data, $id = null) {
		if (null === $id) { //вставка новой записи
			$this->getDbTable()->insert($data);
		} else { //для существующей записи
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}

}

?>