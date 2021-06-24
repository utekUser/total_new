<?php

class Shop_Form_OrderGoodmaker extends Engine_Form {

	public function init() {
		$this->setTableName('shop_good_maker');
		$this->setTableComment('Изготовитель товаров');

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
			'Text', 'onec_id', array(
			'label' => '1С ID',
			'dbField' => array(
				'type' => 'VARCHAR(40)'
			),
			)
		);
		
		$this->addElement(
			'Text', 'name', array(
			'label' => 'Наименование',
			'dbField' => array(
				'type' => 'VARCHAR(256)'
			),
			)
		);
		
	}

}
