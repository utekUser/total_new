<?php

class Shop_Controllers_AdminShopCatalogController extends Core_Controller_Action_Admin {

	public function xml_attribute($object, $attribute) {
		if (isset($object[$attribute])) {
			return (string) $object[$attribute];
		}
	}

	public function init() {
		$request = $this->getRequest();
		if ($request->getQuery('import') && $request->getQuery('import') == 1) {
			Engine_Controller_Action::setViewMain('import');
			Engine_Controller_Action::setDefaultParseUrlAction('import');
		}
		if ($request->isPost()) {

//echo "lol"; die;
			if ($request->getPost('_update')) {
				$updateType = $request->getPost('outFileAction');

				$path = APPLICATION_PATH . DS . 'temporary/catalog/';
				$xml = APPLICATION_PATH . DS . 'temporary/catalog/temp.xml';

				if (file_exists($xml)) {
					$xml = simplexml_load_file($xml);
					if (isset($xml->Классификатор->Группы)) {
						foreach ($xml->Классификатор->Группы->Группа as $key => $value) {
							$this->insertGroup($value, "");
						}
						
						/*$propertyModel = new Shop_Models_OrderCatalogproperty();						
						$propertyModel->deleteAllProperties();	
						echo "lol"; die;*/
						foreach ($xml->Классификатор->Свойства->Свойство as $key => $value) {
							$this->insertProperty($value);
						}
						foreach ($xml->Каталог->Товары->Товар as $key => $value) {
							$this->insertGood($value);
							echo $value->Ид . "<br>";
						}
					}
					if (isset($xml->ПакетПредложений->ТипыЦен)) {
						foreach ($xml->ПакетПредложений->ТипыЦен->ТипЦены as $key => $value) {
							$this->insertPricetype($value);
						}
						foreach ($xml->ПакетПредложений->Склады->Склад as $key => $value) {
							$this->insertStock($value);
						}
						foreach ($xml->ПакетПредложений->Предложения->Предложение as $key => $value) {
							$this->insertOffer($value);
							echo $value->Ид. "<br>";
						}
					}
				}
			}
			$formFile = new Shop_Form_CatalogFile();
			if ($formFile->isValid($request->getPost())) {
				$file = $formFile->file->getFileInfo();
				$ext = ltrim(strrchr($file['file']['name'], '.'), '.');

				$newName = APPLICATION_PATH . DS . 'temporary/catalog/' . 'temp.' . $ext;

				if (file_exists($newName)) {
					unlink($newName);
				}

				$formFile->file->addFilter('Rename', $newName);
				$formFile->file->receive();
			} else {
				$error = $formFile->getMessages();
				print_r($error);
			}

			if ($file = $_FILES['file']['tmp_name']) {
				
			}

			$this->_redirect('/admin/shop/catalog/?import=1');
		}
	}

	public function insertGroup($value, $parentId) {
		$data = array();
		$data['parent_id'] = $parentId;
		$data['onec_id'] = $value->Ид;
		$data['title'] = $value->Наименование;
		$groupModel = new Shop_Models_OrderCataloggroup();
		if ($groupModel->getIssetGroupByOnecId($data['onec_id'])) {
			$groupModel->updateGroupByOnec($data['onec_id'], $data);
		} else {
			$groupModel->saveGroupByOnec($data);
		}
		$paparentId = $value->Ид;
		if (isset($value->Группы)) {
			foreach ($value->Группы->Группа as $key1 => $value1) {
				$this->insertGroup($value1, $paparentId);
			}
		}
	}

	public function insertProperty($value) {
		$data = array();
		$data['onec_id'] = $value->Ид;
		$data['name'] = $value->Наименование;
		$data['type'] = $value->ТипЗначений;
		$propertyModel = new Shop_Models_OrderCatalogproperty();
		if ($propertyModel->getIssetPropertyByOnecId($data['onec_id'])) {			
			/*$propertyModel->deletePropertyById($data['onec_id']);
			echo "lol"; die;*/
			$propertyModel->updatePropertyByOnec($data['onec_id'], $data);
		} else {
			$propertyModel->savePropertyByOnec($data);
		}
		foreach ($value->ВариантыЗначений->Справочник as $key1 => $value1) {
			$this->insertPropertyValue($value1, $data['onec_id']);
		}
	}

	public function insertPropertyValue($value, $parentId) {
		$data = array();
		$data['parent_id'] = $parentId;
		$data['onec_id'] = $value->ИдЗначения;
		$data['name'] = $value->Значение;
		$propertyValueModel = new Shop_Models_OrderCatalogpropertyvalue();
		if ($propertyValueModel->getIssetPropertyValueByOnecId($data['onec_id'])) {
			$propertyValueModel->updatePropertyValueByOnec($data['onec_id'], $data);
		} else {
			$propertyValueModel->savePropertyValueByOnec($data);
		}
	}

	public function insertGood($value) {
		$data = array();
		$data['article'] = $value->Артикул;
		$data['onec_id'] = $value->Ид;
		$data['name'] = $value->Наименование;
		$data['image'] = $value->Картинка;
		$data['country'] = $value->Страна;
		//$data['description'] = $value->Описание;
		$data['trademark'] = $value->ТорговаяМарка;
		$data['tax'] = $value->СтавкиНалогов->СтавкаНалога[0]->Ставка;
		$data['weight'] = $value->Вес;

		$goodModel = new Shop_Models_OrderGood();
		if ($goodModel->getIssetGoodByOnecId($data['onec_id'])) {
			$goodModel->updateGoodByOnec($data['onec_id'], $data);
		} else {
			$goodModel->saveGoodByOnec($data);
		//}

		if (isset($value->Группы)) {
			$goodGroupModel = new Shop_Models_OrderGoodgroup();
			//$goodGroupModel->deleteGoodgroupByGoodId($data['onec_id']);
			if (!$goodGroupModel->getIssetGoodgroupByOnecId($data['onec_id'], $value->Группы->Ид)) {
				$dataGroup = array();
				$dataGroup['good_id'] = $data['onec_id'];
				$dataGroup['group_id'] = $value->Группы->Ид;
				$goodGroupModel->saveGoodgroupByOnec($dataGroup);
			}
		}

		if (isset($value->Изготовитель)) {
			$goodMakerModel = new Shop_Models_OrderGoodmaker();
			if (!$goodMakerModel->getIssetGoodmakerByOnecId($data['onec_id'], $value->Изготовитель->Ид)) {
				$dataMaker = array();
				$dataMaker['good_id'] = $data['onec_id'];
				$dataMaker['onec_id'] = $value->Изготовитель->Ид;
				$dataMaker['name'] = $value->Изготовитель->Наименование;
				$goodMakerModel->saveGoodmakerByOnec($dataMaker);
			}
		}

		if (isset($value->ЗначенияСвойств)) {
			foreach ($value->ЗначенияСвойств->ЗначенияСвойства as $key1 => $value1) {
				$goodPropertyModel = new Shop_Models_OrderGoodproperty();
				if (!$goodPropertyModel->getIssetGoodpropertyByOnecId($data['onec_id'], $value1->Ид)) {
					$dataMaker = array();
					$dataMaker['good_id'] = $data['onec_id'];
					$dataMaker['onec_id'] = $value1->Ид;
					$dataMaker['name'] = $value1->Значение;
					$goodPropertyModel->saveGoodpropertyByOnec($dataMaker);
				}
			}
		}

		if (isset($value->ЗначенияРеквизитов)) {
			foreach ($value->ЗначенияРеквизитов->ЗначениеРеквизита as $key1 => $value1) {
				$goodPropertyRequisite = new Shop_Models_OrderGoodrequisite();
				if (!$goodPropertyRequisite->getIssetGoodrequisiteByOnecId($data['onec_id'], $value1->Наименование)) {
					$dataRequisite = array();
					$dataRequisite['good_id'] = $data['onec_id'];
					$dataRequisite['requisite_name'] = $value1->Наименование;
					$dataRequisite['requisite_value'] = $value1->Значение;
					$goodPropertyRequisite->saveGoodrequisiteByOnec($dataRequisite);
				}
			}
		}
		}
	}

	public function insertPricetype($value) {
		$data = array();
		$data['code'] = $value->Ид;
		$data['name'] = $value->Наименование;
		$data['currency'] = $value->Валюта;
		$priceModel = new Shop_Models_OrderPrices();
		if ($priceModel->getIssetPriceByOnecId($data['code'])) {
			$priceModel->updatePriceByOnec($data['code'], $data);
		} else {
			$priceModel->savePriceByOnec($data);
		}
	}

	public function insertStock($value) {
		$data = array();
		$data['id_onec'] = $value->Ид;
		$data['stock_name'] = $value->Наименование;
		$stockModel = new Shop_Models_OrderStock();
		if ($stockModel->getIssetStockByOnecId($data['id_onec'])) {
			$stockModel->updateStockByOnec($data['id_onec'], $data);
		} else {
			$stockModel->saveStockByOnec($data);
		}
	}

	public function insertOffer($value) {
		$data = array();
		$data['onec_id'] = $value->Ид;
		$data['article'] = $value->Артикул;
		$data['name'] = $value->Наименование;
		$data['weight'] = $value->Вес;
		$data['count'] = $value->Количество;
		$offerModel = new Shop_Models_OrderOffer();
		if ($offerModel->getIssetOfferByOnecId($data['onec_id'])) {
			$offerModel->updateOfferByOnec($data['onec_id'], $data);
		} else {
			$offerModel->saveOfferByOnec($data);
		}

		if (isset($value->Цены)) {
			foreach ($value->Цены->Цена as $key1 => $value1) {
				$dataOfferPrice = array();
				$dataOfferPrice['offer_id'] = $data['onec_id'];
				$dataOfferPrice['price_id'] = $value1->ИдТипаЦены;
				$dataOfferPrice['price_view'] = $value1->Представление;
				$dataOfferPrice['price'] = $value1->ЦенаЗаЕдиницу;
				$dataOfferPrice['currency'] = $value1->Валюта;
				$dataOfferPrice['unit'] = $value1->Единица;
				$dataOfferPrice['coef'] = $value1->Коэффициент;
				$offerPrice = new Shop_Models_OrderOfferprice();
				if ($offerPrice->getIssetOfferpriceByOnecId($data['onec_id'], $value1->ИдТипаЦены)) {
					$offerPrice->updateOfferpriceByOnec($data['onec_id'], $dataOfferPrice);
				} else {
					$offerPrice->saveOfferpriceyOnec($dataOfferPrice);
				}
			}
		}
		foreach ($value->Склад as $key1 => $value1) {
			$dataOfferStock = array();
			$dataOfferStock['offer_id'] = $data['onec_id'];
			$dataOfferStock['warehouse_id'] = $value1['ИдСклада'];
			$dataOfferStock['count'] = $value1['КоличествоНаСкладе'];
			$offerStock = new Shop_Models_OrderOfferwarehouse();
			if ($offerStock->getIssetOfferwarehouseByOnecId($data['onec_id'], $dataOfferStock['warehouse_id'])) {
				$offerStock->updateOfferwarehouseByOnec($data['onec_id'], $dataOfferStock);
			} else {
				$offerStock->saveOfferwarehouseByOnec($dataOfferStock);
			}
		}
	}

	public function indexAction() {
		
	}

	public function importAction() {
		
	}

}
