<?php

class Shop_Form_OrderCatalogproperty extends Engine_Form {

	public function init() {
		$this->setTableName('shop_catalog_property');
		$this->setTableComment('Свойства классификатора');

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
			'dbField' => array(
				'type' => 'VARCHAR(40)'
			),
			)
		);

		$this->addElement(
			'Text', 'name', array(
			'label' => 'Имя справочника'
			)
		);
		
		$this->addElement(
			'Text', 'type', array(
			'label' => 'Тип значений'
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
