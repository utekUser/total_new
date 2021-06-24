<?php

class Popup_Models_Popup extends Engine_Model_Abstract {

	protected $_dbTableName = 'Popup_Models_DbTable_Popup';
	protected $_formTableName = 'Popup_Form_Popup';
	protected $_formTable = 'Popup_Form_Popup';
	protected $_orderBy = 'begindate';

	public function getAllPopups() {
		$http = new Engine_Controller_Request_Http();
		$page = $http->getParam('page');
		$table = $this->getDbTable();
		$select = $table->select()
			->order('begindate DESC');
		$adapter = new Zend_Paginator_Adapter_DbSelect($select);
		$paginator = new Engine_Paginator($adapter);
		$paginator->setItemCountPerPage(25);
		$paginator->setCurrentPageNumber($page);
		return $paginator;
	}

	public function savePopup($data, $id = null) {
		if (null === $id) { //вставка новой записи
			$this->getDbTable()->insert($data);
		} else { //для существующей записи
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}

	public function getActivePopups($type) {
		$table = $this->getDbTable();
        $select = $table->select()
                ->where('section_id = ?', $type)
                ->where('begindate <= ?', date("Y-m-d H:i:s"))
                ->where('enddate > ?', date("Y-m-d H:i:s"))
                ->order('begindate DESC');
		//echo "<pre>";	print_r($select); die;
        $result = $table->fetchAll($select);
		return $result;
	}
}

?>