<?php
class Shop_Form_ShopSetting extends Engine_Form {
    public function init() {
        $this->setTableName('shop_settings');
        $this->setTableComment('Настройки');
        
        $this->setPrimary('id');
        $this->addElement(
            'Text',
            'id',
            array(
                'label' => 'ID настройки',
                'field' => array(
                    'type'  => 'int(10) unsigned',
                    'dbFefault'  => "NOT NULL",
                    'autoIncrement' => true
                ),
                'ignore' => true        
            )
        );
        
		$this->addElement(
            'Text',
            'textfield',
            array(
                'label' => 'Название'
            )
        );
		
		$this->addElement(
            'Date',
            'datetime',
            array(
                'label' => 'Время'
            )
        );        
        		
		$this->addElement(
            'Checkbox',
            'isdeleted',
            array(
                'label' => 'Удалён',
                'checked' => false
            )
        );
    }
}