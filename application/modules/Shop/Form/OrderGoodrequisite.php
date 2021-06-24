<?php

class Shop_Form_OrderGoodrequisite extends Engine_Form {

	public function init() {
		$this->setTableName('shop_good_requisite');
		$this->setTableComment('Значения реквизитов');

		$this->setPrimary('id');
		$this->addElement(
			'Text', 'id', array(
			'label' => 'ID',
			'dbField' => array(
				'type' => 'int(10) unsigned',
				'default' => "NOT NULL",
				'autoIncrement' => true
			),
			'ignore' => true
			)
		);

		$this->addElement(
			'Text', 'parent_id', array(
			'label' => 'ID Товара',
			'dbField' => array(
				'type' => 'VARCHAR(40)'
			),
			)
		);

		$this->addElement(
			'Text', 'requisite_name', array(
			'label' => 'Название Реквизита',
			'dbField' => array(
				'type' => 'VARCHAR(256)'
			),
			)
		);
		
		$this->addElement(
			'Text', 'requisite_value', array(
			'label' => 'Значение Реквизита',
			'dbField' => array(
				'type' => 'VARCHAR(512)'
			),
			)
		);
		
	}

}
