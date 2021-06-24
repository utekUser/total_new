<?php

class Shop_Models_OrderPrices extends Engine_Model_Abstract {

	protected $_dbTableName = 'Shop_Models_DbTable_OrderPrices';
	protected $_formTableName = 'Shop_Form_OrderPrices';
	protected $_orderBy = 'id DESC';

	//Получить товар по id
	public function getPriceByOnecId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`code` = ?', $id);
		$result = $table->fetchRow($select);
		return $result;
	}

	//Есть ли товар по ID 1С
	public function getIssetPriceByOnecId($id) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('`code` = ?', $id);
		$result = $table->fetchRow($select);
		if (is_object($result)) {
			return $result['id'];
		} else {
			return false;
		}
	}

	//Обновление товара
	public function updatePrice($id, $data) {
		$table = $this->getDbTable();
		$set = array(
			'code' => $data['code'],
			'name' => $data['name'],
			'currency' => $data['currency']
		);
		$update = $table->update($set, array('id = ?' => $id));
	}

	//Обновление товара по ID из 1С
	public function updatePriceByOnec($idOnec, $data) {
		$table = $this->getDbTable();
		$set = array(
			'code' => $data['code'],
			'name' => $data['name'],
			'currency' => $data['currency']
		);
		$update = $table->update($set, array('code = ?' => $idOnec));
	}

	//Сохранить товар
	public function savePrice($data) {
		$set = array(
			'code' => $data['code'],
			'name' => $data['name'],
			'currency' => $data['currency']
		);
		$this->getDbTable()->insert($set);
	}

	//Сохранить товар при импорте из 1С
	public function savePriceByOnec($data) {
		$set = array(
			'code' => $data['code'],
			'name' => $data['name'],
			'currency' => $data['currency']
		);
		$this->getDbTable()->insert($set);
	}

}
