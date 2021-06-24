<?php

class User_Form_UserAddress extends Engine_Form {

	public function init() {
		$this->setTableName('user_address');
		$this->setTableComment('Адреса пользователя');

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

		$options = array();
		$table = new User_Models_UserUser();
		$select = $table->getUsers();
		foreach ($select as $value) {
			$options[$value->id] = $value->login;
		}
		$this->addElement(
			'select', 'user_id', array(
			'label' => 'Пользователь',
			'multiOptions' => array('' => 'Выберите пользователя'),
			'dbField' => array(
				'type' => 'int(10) unsigned',
				'default' => "NOT NULL default '0'"
			)
			)
		);
		$this->user_id->addMultiOptions($options);

		$this->addElement(
			'Text', 'address', array(
			'label' => 'Адрес точки',
			'required' => false,
			'placeholder' => 'Адрес точки'
			)
		);
		
		$this->addElement(
			'Select', 'deleted', array(
			'label' => 'Удалён',
			'dbField' => array(
				'type' => 'tinyint(3) unsigned',
				'default' => "NOT NULL default '0'"
			))
		);
	}

}
