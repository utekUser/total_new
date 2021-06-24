<?php
class Shop_Models_OrderCatalogStruct extends Engine_Model_Abstract {
    protected $_dbTableName = 'Shop_Models_DbTable_OrderCatalogStruct';    
    protected $_formTableName = 'Shop_Form_OrderCatalogStruct';    
    protected $_orderBy = 'id DESC';
    
    
    public function getCatalogStruct() {
        $http = new Engine_Controller_Request_Http();
        $page = $http->getParam('page');
        
        $table  = $this->getDbTable();        
        $select = $table->select()
            ->where('deleted = ?', 0)
            ->order('struct_name ASC');
        $adapter = new Zend_Paginator_Adapter_DbSelect(
            $select
        );
        
        $paginator = new Engine_Paginator($adapter);
        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($page);        
        return $paginator;
    }
	
	//Получить менеджера по id
    public function getCatalogStructById($id) {
        $table  = $this->getDbTable();        
        $select = $table->select()
                        ->where('`id` = ?', $id);
        $result = $table->fetchRow($select);
        return $result;    
    }
	
	public function getCatalogStructs() {
        $table  = $this->getDbTable();        
        $select = $table->select()
                        ->order('order ASC');        
        $result = $table->fetchAll($select);
        return $result; 
    }
    
	/**
     * Оформление нового заказа
     *
     * @param array $data
     */
	public function saveCatalogStruct($data) {
        $set = array(
            'struct_root' => $data['struct_root'],
            'struct_name' => $data['struct_name'],
            'struct_link' => $data['struct_link'],
            'order' => $data['order'],
            'deleted' => $data['deleted'],
        );
        $this->getDbTable()->insert($set);
    }    
    
}