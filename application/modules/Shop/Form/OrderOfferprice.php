<?php

class Shop_Form_OrderOfferprice extends Engine_Form {

	public function init() {
		$this->setTableName('shop_offer_price');
		$this->setTableComment('Цены товаров');

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
			'Text', 'price_id', array(
			'label' => 'Ид Типа Цены',
			'dbField' => array(
				'type' => 'VARCHAR(40)'
			),
			)
		);

		$this->addElement(
			'Text', 'price_view', array(
			'label' => 'Представление',
			'dbField' => array(
				'type' => 'VARCHAR(64)'
			),
			)
		);
		
		$this->addElement(
			'Text', 'price', array(
			'label' => 'Цена За Единицу',
			'dbField' => array(
				'type' => 'int(10)'
			),
			)
		);
		
		$this->addElement(
			'Text', 'currency', array(
			'label' => 'Валюта',
			'dbField' => array(
				'type' => 'VARCHAR(8)'
			),
			)
		);
		
		$this->addElement(
			'Text', 'unit', array(
			'label' => 'Единица',
			'dbField' => array(
				'type' => 'VARCHAR(16)'
			),
			)
		);
		
		$this->addElement(
			'Text', 'coef', array(
			'label' => 'Коэффициент',
			'dbField' => array(
				'type' => 'VARCHAR(8)'
			),
			)
		);
	}

}
