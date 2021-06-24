<?php

class Account_Models_Favourites extends Engine_Model_Abstract {

    protected $_dbTableName = 'Account_Models_DbTable_Favourites';
    protected $_formTableName = 'account_favourites';
    protected $_orderBy = 'id DESC';

    public function favouritesAdd($data) {		
		$table = $this->getDbTable();
		$select = $table->select()
			->where('user_id = ?', $data['user_id'])				
			->where('good_id = ?', $data['good_id'])
			->where('deleted = ?', 0);
		$result = $table->fetchAll($select);	
		if (count($result) > 0) {
			$set = array('deleted' => 1);
			$this->getDbTable()->update($set, array(
				"user_id = ?" => $data['user_id'],
				"good_id = ?" => $data['good_id']
			));
		} else {
			$select = $table->select()
				->where('user_id = ?', $data['user_id'])				
				->where('good_id = ?', $data['good_id'])
				->where('deleted = ?', 1);
			$result = $table->fetchAll($select);	
			if (count($result) > 0) {
				$set = array(
					'added_date' => $data['added_date'],
					'deleted' => 0
				);
				$this->getDbTable()->update($set, array(
					"user_id = ?" => $data['user_id'],
					"good_id = ?" => $data['good_id']
				));
			} else {
				$set = array(
					'user_id' => $data['user_id'],
					'good_id' => $data['good_id'],
					'added_date' => $data['added_date'],
					'deleted' => 0
				);
				$table->insert($set);
			}
		}
    }
	
	public function getFavouritesByData($data) {
		$table = $this->getDbTable();
		//var_dump($data); die;
		$select = $table->select()
			->where('user_id = ?', $data['user_id'])				
			->where('good_id = ?', $data['good_id'])
			->where('deleted = ?', 0);
		$result = $table->fetchAll($select);			
		if (count($result) > 0) {
			return "Yes!";
		} else {
			return "No!";
		}
	}
	
	public function getFavouritesToUserPage($data) {
		$registry = Engine_Api::getInstance();
		$db = $registry->getContainer()->db;
		$this->_tablePrefix = $registry->getContainer()->tablePrefix;
		$select = $db->select()
			->from(
				array('d' => $this->_tablePrefix . 'account_favourites'), array('d.good_id AS fav_good_id'))
			->joinLeft(
				array('a' => $this->_tablePrefix . 'shop_good'), 'd.good_id = a.id', array('a.name')
			)
			->where('d.user_id = ?', $data['user_id'])
			->where('d.deleted = ?', 0)
			->order('d.added_date DESC')			
			->limit(2);
		$result = $db->fetchAll($select);
		return $result;	
	}
	
	public function getAllFavouritesByUser($data) {
		$http = new Engine_Controller_Request_Http();
        $page = $http->getParam('page');   
		
		$registry = Engine_Api::getInstance();
		$db = $registry->getContainer()->db;
		$this->_tablePrefix = $registry->getContainer()->tablePrefix;

		$userPriceType = "4f69c3fc-71ad-43b8-9928-c28f1b502292";

		$select = $db->select()
			->from(
				array('d' => $this->_tablePrefix . 'account_favourites'), array('d.good_id AS fav_good_id'))
			->joinLeft(
				array('a' => $this->_tablePrefix . 'view_goods_wc_wp'), 'd.good_id = a.id', array('a.id', 'a.name', 'a.price', 'a.offer_count', 'a.image')
			)
			->where("a.price_id = ?", $userPriceType)
			->where("d.user_id = ?", $data['user_id'])
			->where("d.deleted = ?", 0)
			->order('a.price ASC');
			//echo "<pre>"; print_r($select); die;	
		$adapter = new Zend_Paginator_Adapter_DbSelect(
            $select
        );        
        $paginator = new Engine_Paginator($adapter);
        $paginator->setItemCountPerPage(16);
        $paginator->setCurrentPageNumber($page);
		return $paginator;
	}

}
