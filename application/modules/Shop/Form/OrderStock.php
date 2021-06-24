<?php
class Shop_Form_OrderStock extends Engine_Form {
    public function init() {
        $this->setTableName('shop_warehouse');
        $this->setTableComment('Склады');
        
        $this->setPrimary('id');
        $this->addElement(
            'Text',
            'id',
            array(
                'label' => 'ID склада',
                'dbField' => array(
                    'type'  => 'int(10) unsigned',
                    'default'  => "NOT NULL",
                    'autoIncrement' => true
                ),
                'ignore' => true
            )
        );

		$this->addElement(
            'Text',
            'id_onec',			
            array(
                'label' => 'Идентификатор 1С',
				'readonly' => true,
				'dbField' => array(
                    'type'  => 'varchar(64)',
                    'default'  => "NOT NULL"
                ),
            )
        );
		
		$this->addElement(
            'Text',
            'stock_name',
            array(
                'label' => 'Название склада',
				'dbField' => array(
                    'type'  => 'varchar(512)',
                    'default'  => "NOT NULL"
                ),
            )
        );
		
    }
}