<?php
class Shop_Form_OrderCatalogStruct extends Engine_Form {
    public function init() {
        $this->setTableName('shop_catalog_struct');
        $this->setTableComment('Структура каталога');
        
        $this->setPrimary('id');
        $this->addElement(
            'Text',
            'id',
            array(
                'label' => 'ID элемента структуры',
                'dbField' => array(
                    'type'  => 'int(10) unsigned',
                    'default'  => "NOT NULL",
                    'autoIncrement' => true
                ),
                'ignore' => true
            )
        );

		$options = array();
		$table = new Shop_Models_OrderCatalogStruct();
		$select = $table->getCatalogStruct();
		foreach ($select as $value) {
			$options[$value->id] = $value->struct_name;
		}
		$this->addElement(
            'select',
            'struct_root',
            array(
                'label' => 'Корневой элемент',
				'multiOptions' => array(
					'' => 'Выберите элемент',
					'0' => 'Корень'
				),
				'dbField' => array(
					'type' => 'int(10) unsigned',
					'default' => "NOT NULL default '0'"
				),
            )
        );
		$this->struct_root->addMultiOptions($options);
		
		$this->addElement(
            'Text',
            'struct_name',
            array(
                'label' => 'Название структуры',
				'dbField' => array(
                    'type'  => 'varchar(512)',
                    'default'  => "NOT NULL"
                ),
            )
        );
		
		$this->addElement(
            'Text',
            'struct_link',
            array(
                'label' => 'Ссылка структуры',
				'dbField' => array(
                    'type'  => 'varchar(512)',
                    'default'  => "NOT NULL"
                ),
            )
        );
		
		$this->addElement(
            'Text',
            'order',
            array(
                'label' => 'Порядок',
				'dbField' => array(
                    'type'  => 'int(10)',
                    'default'  => "1"
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