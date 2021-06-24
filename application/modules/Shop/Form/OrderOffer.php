<?php

class Shop_Form_OrderOffer extends Engine_Form {

	public function init() {
		$this->setTableName('shop_offer');
		$this->setTableComment('Предложения товаров');

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
			'Text', 'onec_id', array(
			'label' => '1С ID',
			'readonly' => true,
			'dbField' => array(
				'type' => 'VARCHAR(40)'
			),
			)
		);

		$this->addElement(
			'Text', 'article', array(
			'label' => 'Артикул',
			'dbField' => array(
				'type' => 'VARCHAR(100)'
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
		
		$this->addElement(
			'Text', 'weight', array(
			'label' => 'Вес',
			'dbField' => array(
				'type' => 'VARCHAR(32)'
			),
			)
		);
		
		$this->addElement(
			'Text', 'count', array(
			'label' => 'Количество',
			'dbField' => array(
				'type' => 'VARCHAR(16)'
			),
			)
		);
				
		$this->addElement(
            'Checkbox',
            'deleted',
            array(
				'dbField' => array(
                    'type'  => 'tinyint(3) unsigned',
					'default'  => "0"
                ),
                'label' => 'Удалён'
            )
        );
	}

}
