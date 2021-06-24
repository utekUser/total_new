<?php

class Shop_Form_OrderGood extends Engine_Form {

	public function init() {
		$this->setTableName('shop_good');
		$this->setTableComment('Товары');

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
			'Text', 'article', array(
			'label' => 'Артикул',
			'dbField' => array(
				'type' => 'VARCHAR(40)'
			),
			)
		);

		$this->addElement(
			'Text', 'onec_id', array(
			'label' => 'ID Товара',
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
		
		$this->addElement(
			'Text', 'image', array(
			'label' => 'Картинка',
			'dbField' => array(
				'type' => 'VARCHAR(256)'
			),
			)
		);
		
		$this->addElement(
			'Text', 'country', array(
			'label' => 'Страна',
			'dbField' => array(
				'type' => 'VARCHAR(128)'
			),
			)
		);
		
		$this->addElement(
			'Text', 'description', array(
			'label' => 'Описание',
			'dbField' => array(
				'type' => 'TEXT'
			),
			)
		);
		
		$this->addElement(
			'Text', 'trademark', array(
			'label' => 'Торговая Марка',
			'dbField' => array(
				'type' => 'VARCHAR(256)'
			),
			)
		);
		
		$this->addElement(
			'Text', 'tax', array(
			'label' => 'Ставка Налога',
			'dbField' => array(
				'type' => 'VARCHAR(8)'
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
