<?php

class Shop_Models_OrderMaker extends Engine_Model_Abstract {

	protected $_dbTableName = 'Shop_Models_DbTable_OrderMaker';
	protected $_formTableName = 'Shop_Form_OrderMaker';
	protected $_orderBy = 'id DESC';

	public function getMaker() {
		$http = new Engine_Controller_Request_Http();
		$page = $http->getParam('page');

		$table = $this->getDbTable();

		$select = $table->select()
			->where('deleted = ?', 0)
			->order('id ASC');
		$adapter = new Zend_Paginator_Adapter_DbSelect(
			$select
		);

		$paginator = new Engine_Paginator($adapter);
		$paginator->setItemCountPerPage(30);
		$paginator->setCurrentPageNumber($page);

		return $paginator;
	}
	
	public function getMakersForMainPage() {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`deleted` = ?', 0)
			->order('id ASC')
			->limit('5');
		$result = $table->fetchAll($select);
		return $result;
	}
	
	//Получить производителя по link
	public function getMakerByLink($link) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`link` = ?', $link);
		$result = $table->fetchRow($select);
		return $result;
	}

}
