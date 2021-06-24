<?php

class Shop_Form_OrderOfferwarehouse extends Engine_Form {

	public function init() {
		$this->setTableName('shop_offer_warehouse');
		$this->setTableComment('Склады товаров');

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
			'Text', 'offer_id', array(
			'label' => 'ID Предложения',
			'dbField' => array(
				'type' => 'VARCHAR(40)'
			),
			)
		);

		$this->addElement(
			'Text', 'warehouse_id', array(
			'label' => 'Склад ID',
			'dbField' => array(
				'type' => 'VARCHAR(40)'
			),
			)
		);
		
		$this->addElement(
			'Text', 'count', array(
			'label' => 'Количество товара',
			'dbField' => array(
				'type' => 'INT(8)'
			),
			)
		);		
		
	}

}
