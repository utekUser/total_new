<?php

class Shop_Form_OrderGoodproperty extends Engine_Form {

	public function init() {
		$this->setTableName('shop_good_property');
		$this->setTableComment('Значения свойств');

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
			'Text', 'property_id', array(
			'label' => 'ID свойства',
			'dbField' => array(
				'type' => 'VARCHAR(40)'
			),
			)
		);
		
		$this->addElement(
			'Text', 'property_name', array(
			'label' => 'Значение свойства',
			'dbField' => array(
				'type' => 'VARCHAR(40)'
			),
			)
		);
		
	}

}
