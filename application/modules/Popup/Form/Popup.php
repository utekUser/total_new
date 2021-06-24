<?php

class Popup_Form_Popup extends Engine_Form {

	/**
	 * Инициализация
	 *
	 */
	public function init() {
		$this->setTableName('popupwindow'); // Имя таблицы в БД без префикса
		$this->setTableComment('Всплывающие окна'); // Описание таблицы в БД

		$this->setPrimary('id');
		$this->addElement(
			'Text', 'id', array(
			'label' => 'ID заказа',
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
			'label' => 'Имя',
			'dbField' => array(
				'type' => 'varchar(256)',
				'default' => "NOT NULL default NULL"
			),
			)
		);

		$this->addElement(
			'Date', 'begindate', array(
			'label' => 'Дата начала'
			)
		);
		
		$this->addElement(
			'Date', 'enddate', array(
			'label' => 'Дата окончания'
			)
		);

		$this->addElement(
			'Text', 'url', array(
			'label' => 'Ссылка'
			)
		);

		$options = array();
		$select = array(
			"1" => "На главной",
			"2" => "Для физических лиц при входе в кабинет",
			"3" => "Для юридических лиц при входе в кабинет"
		);
		foreach ($select as $key => $value) {
			$options[$key] = $value;
		}
		$this->addElement(
			'select', 'section_id', array(
			'label' => 'Раздел',
			'multiOptions' => array('' => 'Выберите раздел'),
			'required' => true,
			'dbField' => array(
				'type' => 'int(10) unsigned',
				'default' => "NOT NULL default '0'"
			)
			)
		);
		$this->section_id->addMultiOptions($options);

		$this->addElement(
			'File', 'file', array(
			'destination' => 'public/popup',
			'label' => 'Картинка всплывающая',
			'validators' => array(
				'extension' => 'jpg,png'
			),
			'required' => true
			)
		);		
	}

}
