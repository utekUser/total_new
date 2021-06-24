<?php

class User_Models_UserAddress extends Engine_Model_Abstract {

	protected $_dbTableName = 'User_Models_DbTable_UserAddress';
	protected $_formTableName = 'User_Form_UserAddress';
	
	public function saveAddr($texts, $id = null) {
		$data = array(
			'user_id' => $texts['user_id'],
			'address' => $texts['address']
		);		
		$this->getDbTable()->insert($data);
		return $this->getDbTable()->getAdapter()->lastInsertId();
	}

	public function updateAddr($id, $texts) {
		$table = $this->getDbTable();
		$date = array(
			'address' => $texts['address']
		);
		$result = $table->update($date, array('id = ?' => $id));
	}
	
	public function deleteAddr($id) {
		$table = $this->getDbTable();
		$data = array(
			'deleted' => 1
		);
		$result = $table->update($data, array('id = ?' => $id));
	}
	
	public function unDeleteAddr($id) {
		$table = $this->getDbTable();
		$data = array(
			'deleted' => 0
		);
		$result = $table->update($data, array('id = ?' => $id));
	}
	
	
	public function getUserAddr($userId) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`user_id` = ?', $userId)
			->where('`deleted` = ?', 0)
			->order('id ASC');
		$result = $table->fetchAll($select);
		return $result;
	}
		
}
