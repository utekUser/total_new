<?php
class Slides_Form_Slides extends Engine_Form {
	
	protected $_dbTable = 'slides';
	
    public function init() {
        $this->setTableName('slides');
        $this->setTableComment('Слайды');
        
        $this->setPrimary('id');
        $this->addElement(
            'Text',
            'id',
            array(
                'label' => 'Id',
                'dbField' => array(
                    'type'  => 'tinyint(3) unsigned',
                    'default'  => "NOT NULL",
                    'autoIncrement' => true
                ),
                'ignore' => true
            )
        );    
        
        $this->setPosition('pos');
        $this->addElement(
            'Hidden',
            'pos',
            array(
                'label' => 'Позиция',
                'dbField' => array(
                    'type'     => 'tinyint(3) unsigned',
                    'default'  => "NOT NULL default '0'"
                ),
                'ignore' => true
            )
        );
        
        
        $this->addElement(
            'Text',
            'name',
            array(
                'label' => 'Название'
            )
        );
        
        $this->addElement(
            'TinyMce',
            'text',
            array(
                'label' => 'Текст'
            )
        );
        
        $this->addElement(
            'Text',
            'url',
            array(
                'label' => 'Ссылка'
            )
        );
        
		$this->addElement(
            'Date',
            'begindate',
            array(
                'label' => 'Дата начала показа'
            )
        );
        
		$this->addElement(
            'Date',
            'enddate',
            array(
                'label' => 'Дата окончания показа'
            )
        );
        
		
        $this->addElement(
            'File',
            'file',
            array(
                'destination' => 'public/slides',
                'label' => 'Прикрепленный файл',
                'validators' => array(
                    'extension' => 'jpg,png,webp'
                ),
                'required' => true
            )
        );
		
		$this->addElement(
            'File',
            'filemobile',
            array(
                'destination' => 'public/slides/mobile',
                'label' => 'Слайд мобильной версии',
                'validators' => array(
                    'extension' => 'jpg,png'
                ),
                'required' => false
            )
        );
        
        $this->addElement(
            'Checkbox',
            'display',
            array(
                'label' => 'Отображать'
            )
        );
    }
}