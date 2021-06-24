<?php

class Slides_Models_Slides extends Engine_Model_Abstract {

	protected $_dbTableName = 'Slides_Models_DbTable_Slides';
	protected $_formTableName = 'Slides_Form_Slides';
	protected $_formTable = 'Slides_Form_Slides';
	protected $_orderBy = 'pos';

	public function getAllSlides() {
		$http = new Engine_Controller_Request_Http();
		$page = $http->getParam('page');
		$table = $this->getDbTable();
		$select = $table->select()
			->order('pos ASC');
		$adapter = new Zend_Paginator_Adapter_DbSelect($select);
		$paginator = new Engine_Paginator($adapter);
		$paginator->setItemCountPerPage(25);
		$paginator->setCurrentPageNumber($page);
		return $paginator;
	}

	public function getActiveSlides() {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('display = 1')
			->where('current_timestamp() > `begindate`')
			->where('current_timestamp() < `enddate`')
			->order('pos ASC');
		return $table->fetchAll($select);
	}
	
	public function getSlides() {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('display = 1')
			->order('pos ASC');
		return $table->fetchAll($select);
	}

	public function saveSlide($data) {
		$table = $this->getDbTable();
		$maxPos = $table->fetchAll($table->select()->order('pos DESC'));
		//echo $maxPos["0"]['pos']; die;
		$maxP = (count($maxPos) > 0 ? $maxPos["0"]['pos'] : 0);
        $set = array(
            'pos' => $maxP + 1,
            'name' => $data['name'],
            'text' => $data['text'],
            'url' => $data['url'],            
            'display' => $data['display'],
            'begindate' => $data['begindate'],
            'enddate' => $data['enddate'],
			'file' => "",
			'filemobile' => ""
        );
        return $table->insert($set);
    }
	
	public function updateSlide($data) {
        $set = array(
            'pos' => $data['pos'],
            'name' => $data['name'],
            'text' => $data['text'],
            'url' => $data['url'],            
            'display' => $data['display'],
            'begindate' => $data['begindate'],
            'enddate' => $data['enddate'],
        );
        return $this->getDbTable()->update($set, array(
            "id = ?" => $data['id'],
        ));
    }
	
	public function changeFilesInSlide($data) {        
        $set = array(
            'file' => $data['file'],
            'filemobile' => $data['filemobile'],
        );
        $this->getDbTable()->update($set, array(
            "id = ?" => $data['id'],
        ));
    }
	
	public function changeFileInSlide($data) {        
        $set = array(
            'file' => $data['file'],
        );
        $this->getDbTable()->update($set, array(
            "id = ?" => $data['id'],
        ));
    }
	
	public function changeModFileInSlide($data) {        
        $set = array(
            'filemobile' => $data['filemobile'],
        );
        $this->getDbTable()->update($set, array(
            "id = ?" => $data['id'],
        ));
    }	
	
}

?>