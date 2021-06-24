<?php

class Shop_Controllers_AdminShopSettingsUpdatesettingController extends Core_Controller_Action_Admin {

	public function init() {
		$this->_redirector = $this->_helper->getHelper('Redirector');
	}

	public function indexAction() {
		$settingModel = new Shop_Models_ShopSetting();
		if (isset($_GET['datetime'])) {
			$data = array(
				'datetime' => $_GET['datetime']
			);			
			$result = $settingModel->updateSetting(2, $data);
		} elseif (isset($_GET['textfield'])) {
			$data = array(
				'textfield' => $_GET['textfield']
			);
			$result = $settingModel->updateSetting(1, $data);
		}		
		if ($result != 0) {
			echo "yes";
		} else {
			echo "no";
		}
		die;
		exit;
	}

}
