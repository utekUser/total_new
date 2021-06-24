<?php
class Texts_Models_Texts extends Engine_Model_Abstract {
    protected $_dbTableName = 'Texts_Models_DbTable_Texts';    
    protected $_formTableName = 'Texts_Form_Texts';    
    protected $_orderBy = 'pos DESC';
    
	public function getAllTexts() {
		$http = new Engine_Controller_Request_Http();
		$page = $http->getParam('page');
		$table = $this->getDbTable();
		$select = $table->select()
			->order('pos DESC');
		$adapter = new Zend_Paginator_Adapter_DbSelect($select);
		$paginator = new Engine_Paginator($adapter);
		$paginator->setItemCountPerPage(25);
		$paginator->setCurrentPageNumber($page);
		return $paginator;
	}
	
    public function getContent($id) {
        $table  = $this->getDbTable();        
        $select = $table->select()
                        ->where('`id` = ?', $id)
                        ->where('`display` = 1')
                        ->limit('1');                        
        $result = $table->fetchRow($select);        
        if ($result) {
            return $result['text'];    
        } else {
            return false;     
        }
    }
}