<?php

class Shop_Form_OrderCataloggroup extends Engine_Form {

	public function init() {
		$this->setTableName('shop_catalog_group');
		$this->setTableComment('Группы классификатора');

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
			'label' => 'Родительский ID',
			'readonly' => true,	
			'dbField' => array(
				'type' => 'VARCHAR(40)'
			),
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
			'Text', 'title', array(
			'label' => 'Имя группы'
			)
		);
		
		$this->addElement(
			'Text', 'link', array(
			'label' => 'Ссылка'
			)
		);
		
		$this->addElement(
            'File',
            'file',
            array(
                'destination' => '/public/shop/cataloggroup',
                'label' => 'Прикрепленный файл',
                'validators' => array(
                    'extension' => 'jpg,png,webp'
                ),
                'required' => false
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
