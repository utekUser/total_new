<?php

class Shop_Form_OrderMaker extends Engine_Form {

	public function init() {
		$this->setTableName('shop_maker');
		$this->setTableComment('Производители');

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
			'Text', 'name', array(
			'label' => 'Наименование',
			'dbField' => array(
				'type' => 'VARCHAR(256)'
			),
			)
		);

		$this->addElement(
			'Text', 'link', array(
			'label' => 'Ссылка',
			'dbField' => array(
				'type' => 'VARCHAR(256)'
			),
			)
		);

		$this->addElement(
			'Text', 'linkto', array(
			'label' => 'Адрес вcтраиваемого поиска',
			'dbField' => array(
				'type' => 'VARCHAR(256)'
			),
			)
		);

		$this->addElement(
			'Text', 'onec_id', array(
			'label' => 'ID производителя в справочнике',
			'dbField' => array(
				'type' => 'VARCHAR(40)'
			),
			)
		);

		$this->addElement(
            'File',
            'image',
            array(
                'destination' => '/public/shop/maker',
                'label' => 'Логотип',
                'validators' => array(
                    'extension' => 'jpg,png,webp'
                ),
                'required' => false
            )
        );
		
		$this->addElement(
            'File',
            'image_hover',
            array(
                'destination' => '/public/shop/maker',
                'label' => 'Логотип при наведении',
                'validators' => array(
                    'extension' => 'jpg,png,webp'
                ),
                'required' => false
            )
        );

		$this->addElement(
			'TinyMce', 'short', array(
			'label' => 'Краткое описание',
			'dbField' => array(
				'type' => 'TEXT'
			),
			)
		);

		$this->addElement(
			'TinyMce', 'description', array(
			'label' => 'Описание',
			'dbField' => array(
				'type' => 'TEXT'
			),
			)
		);

		$this->addElement(
			'Checkbox', 'deleted', array(
			'dbField' => array(
				'type' => 'tinyint(3) unsigned',
				'default' => "0"
			),
			'label' => 'Удалён'
			)
		);
	}

}
