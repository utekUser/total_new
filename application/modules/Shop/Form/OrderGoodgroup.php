<?php

class Shop_Form_OrderGoodgroup extends Engine_Form {

	public function init() {
		$this->setTableName('shop_good_group');
		$this->setTableComment('Группы товаров');

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
			'Text', 'good_id', array(
			'label' => 'ID Товара',
			'dbField' => array(
				'type' => 'VARCHAR(40)'
			),
			)
		);

		$this->addElement(
			'Text', 'group_id', array(
			'label' => 'ID Группы',
			'dbField' => array(
				'type' => 'VARCHAR(40)'
			),
			)
		);
		
	}

}
