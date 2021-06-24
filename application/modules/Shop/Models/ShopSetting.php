<?php

class Shop_Models_ShopSetting extends Engine_Model_Abstract {

	protected $_dbTableName = 'Shop_Models_DbTable_ShopSetting';

	public function getSettingById($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('isdeleted = 0')
			->where('id = ?', $id);
		return $table->fetchRow($select);
	}

	public function updateSetting($id, $data) {			
		return $this->getDbTable()->update(
			$data, array('id' => $id)
		);
	}
	
}
