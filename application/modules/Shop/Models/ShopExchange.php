<?php

class Shop_Models_ShopExchange extends Engine_Model_Abstract {
	/*
	 * http://82.117.166.162/Cereus/ws/IS_OnlineStore_RMH.1cws?wsdl
	 * 'login' => "IS_Account",
	 * 'password' => "OCs0P1S4"
	 */
	/*
	 * http://82.117.166.162/Cereus50Test/ws/Is_OnlineStore_RMH.1cws?wsdl
	 * 'login' => "IS_Account",
	 * 'password' => "123"
	 */

	/*protected $_url = 'http://82.117.166.162/Cereus50Test/ws/Is_OnlineStore_RMH.1cws?wsdl';
	protected $_login = 'IS_Account';
	protected $_password = 'OCs0P1S4';*/
	protected $_url = 'http://82.117.166.162/Cereus/ws/Is_OnlineStore_RMH.1cws?wsdl';
	protected $_login = 'IS_Account';
	protected $_password = 'OCs0P1S4';

	public function getPrice($goods, $addrId) {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$client = new SoapClient($this->_url, array(
				'login' => $this->_login,
				'password' => $this->_password
			));
			foreach ($goods as $value) {
				$products1C["Product"][] = array(
					"ID" => $value
				);
			}
			$dataTo1C = array(
				"InputData" => array(
					"Customer" => array(
						"ID" => $auth_id,
					),
					"Address_ID" => $addrId,
					"ArrayOfProducts" => $products1C
				)
			); //print_r($dataTo1C); die;
			$result = $client->GetPricesOfProduct($dataTo1C);
			return $result->return->Strings_Prices->String;
		} else {
			return "No!";
		}
	}

	public function updateAddr1C($authId, $addrId, $addr, $isAct) {
		$client = new SoapClient($this->_url, array(
			'login' => $this->_login,
			'password' => $this->_password
		));
		$dataTo1C = array(
			"InputData" => array(
				"Customer" => array(
					"ID" => $authId
				),
				"ArrayOfAddresses" => array(
					"Adress" => array(
						"ID" => $addrId,
						"Name" => $addr,
						"Active" => $isAct
					)
				),
			)
		);
		$result = $client->UpdateAdress($dataTo1C);
	}

	public function registrationRequest($id, $post, $addressArr) {
		$client = new SoapClient($this->_url, array(
			'login' => $this->_login,
			'password' => $this->_password
		));
		$dataTo1C = array(
			"InputData" => array(
				"ID" => $id,
				"Name" => $post['name'],
				"INN" => $post['inn'],
				"Email" => $post['email'],
				"PhoneNumber" => $post['phone'],
				"IP" => ($post['ip'] == "1" ? "true" : "false"),
				"ArrayOfAddresses" => $addressArr,
				"DateTimeOfRequest" => date("YmdHis")
			)
		);
		$result = $client->RequestForRegistrationOfCustomer($dataTo1C);
	}

	public function getBalance($productId) {
		$client = new SoapClient($this->_url, array(
			'login' => $this->_login,
			'password' => $this->_password
		));

		$goodModel = new Shop_Models_OrderGood();
		$good = $goodModel->getGoodById($productId);
		$products1C["Product"][] = array(
			"ID" => $good['article']
		);
		$dataTo1C = array(
			"InputData" => array(
				"ArrayOfProducts" => $products1C
			)
		);
		return $client->GetBalanceOfProducts($dataTo1C);
	}

	public function getTotalQuantity($article) {
		$client = new SoapClient($this->_url, array(
			'login' => $this->_login,
			'password' => $this->_password
		));
		$products1C["Product"][] = array(
			"ID" => $article
		);
		$dataTo1C = array(
			"InputData" => array(
				"ArrayOfProducts" => $products1C
			)
		);
		$result = $client->GetBalanceOfProducts($dataTo1C);
		return $result->return->Strings_Balance->String->TotalQuantity;
	}

	public function getQuantityByWarehouses($article) {
		$client = new SoapClient($this->_url, array(
			'login' => $this->_login,
			'password' => $this->_password
		));
		$products1C["Product"][] = array(
			"ID" => $article
		);
		$dataTo1C = array(
			"InputData" => array(
				"ArrayOfProducts" => $products1C
			)
		);
		$result = $client->GetBalanceOfProducts($dataTo1C);
		$quantWarh = array();
		if (isset($result->return->Error)) {
			$finishData .= '<p>' . $result->return->Error->Description . "</p>";
		} else {
			if (is_object($result->return->Strings_Balance->String)) {
				if (is_array($result->return->Strings_Balance->String->Strings_Storehouse->String)) {
					foreach ($result->return->Strings_Balance->String->Strings_Storehouse->String as $value) {
						if ($value->IsRemoteStorehouse == 1) {
							$quantWarh['far'] = $value->Quantity;
						} else {
							$quantWarh['near'] = $value->Quantity;
						}							
					}
					/*$quantWarh['near'] = $result->return->Strings_Balance->String->Strings_Storehouse->String[0]->Quantity;
					$quantWarh['far'] = $result->return->Strings_Balance->String->Strings_Storehouse->String[1]->Quantity;*/
				} else {
					if ($result->return->Strings_Balance->String->Strings_Storehouse->String->IsRemoteStorehouse == 1) {
						$quantWarh['far'] = $result->return->Strings_Balance->String->Strings_Storehouse->String->Quantity;
					} else {
						$quantWarh['near'] = $result->return->Strings_Balance->String->Strings_Storehouse->String->Quantity;
					}
				}
			}
		}
		return $quantWarh;
	}

	public function getBalanceByText($productId) {
		$client = new SoapClient($this->_url, array(
			'login' => $this->_login,
			'password' => $this->_password
		));

		$goodModel = new Shop_Models_OrderGood();
		$good = $goodModel->getGoodById($productId);
		$products1C["Product"][] = array(
			"ID" => $good['article']
		);
		//echo $good['article'];		print_r($result); die;
		$dataTo1C = array(
			"InputData" => array(
				"ArrayOfProducts" => $products1C
			)
		);
		$result = $client->GetBalanceOfProducts($dataTo1C);
		//print_r($result); die;
		$finishData = "";		
		if (isset($result->return->Error)) {
			$finishData .= '<p>' . $result->return->Error->Description . "</p>";
		} else {
			//print_r($result->return); die;
			if (is_object($result->return->Strings_Balance->String)) {
				if (is_array($result->return->Strings_Balance->String->Strings_Storehouse->String)) {
					foreach ($result->return->Strings_Balance->String->Strings_Storehouse->String as $value) {
						if ($value->IsRemoteStorehouse == 1) {
							$quantWarh['far'] = $value->Quantity;
							$finishData .= '<p>' . $value->Quantity . " шт. (Дальний склад)</p>";
						} else {
							$quantWarh['near'] = $value->Quantity;
							$finishData .= '<p>' . $value->Quantity . " шт. (Ближний склад)</p>";
						}							
					}
					/*$finishData .= '<p>' . $result->return->Strings_Balance->String->Strings_Storehouse->String[0]->Quantity . " шт. (Ближний склад)</p>";
					$finishData .= '<p>' . $result->return->Strings_Balance->String->Strings_Storehouse->String[1]->Quantity . " шт. (Дальний склад)</p>";*/
				} else {
					if ($result->return->Strings_Balance->String->Strings_Storehouse->String->IsRemoteStorehouse == 1) {
						$finishData .= '<p>' . $result->return->Strings_Balance->String->Strings_Storehouse->String->Quantity . " шт. (Дальний склад)</p>";
					} else {
						$finishData .= '<p>' . $result->return->Strings_Balance->String->Strings_Storehouse->String->Quantity . " шт. (Ближний склад)</p>";
					}
				}
			} else {
				$finishData .= '<div class="no-data"><p>Нет данных</p><p>Выберите другой товар</p></div>';
				$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
				$basketModel = new Account_Models_Basket();
				$data = array(
					'user_id' => $auth->getIdentity(),
					'good_id' => $good['id']
				);
				$basketModel->countToNull($data);
			}
		}
		return $finishData;
	}

	public function sendOrder($orderId, $orderData, $items) {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
		$auth_id = $auth->getIdentity();
		if (isset($auth_id)) {
			$client = new SoapClient($this->_url, array(
				'login' => $this->_login,
				'password' => $this->_password
			));

			$goodsByWarehouse = $this->getItemsByWarehouse($items, $orderData['address_id']);
			if (is_array($goodsByWarehouse['near'])) {
				if (count($goodsByWarehouse['near']) > 0) {
					foreach ($goodsByWarehouse['near'] as $key => $item) {
						$products1C['String'][] = array(
							"Product" => array(
								"ID" => $item['article']
							),
							"IsRemoteStorehouse" => "false",
							"Quantity" => $item['basket_count'],
							"Sum" => $item['price']
						);
					}
				}
			}
			if (is_array($goodsByWarehouse['far'])) {
				if (count($goodsByWarehouse['far']) > 0) {
					foreach ($goodsByWarehouse['far'] as $key => $item) {
						$products1C['String'][] = array(
							"Product" => array(
								"ID" => $item['article']
							),
							"IsRemoteStorehouse" => "true",
							"Quantity" => $item['basket_count'],
							"Sum" => $item['price']
						);
					}
				}
			}

			$expressDelivery = "false";
			$settingModel = new Shop_Models_ShopSetting();
			$sumToday = $settingModel->getSettingById(1);
			$timeToday = $settingModel->getSettingById(2);

			if (strtotime($orderData['date']) > strtotime($timeToday['datetime'])) {
				if (($orderData['total_sum'] > $sumToday['textfield']) && (count($goodsByWarehouse['far']) == 0)) {
					$expressDelivery = "true";
				} else {
					$orderData['date'] = date("Y-m-d H:i:s", strtotime("+1 days", strtotime($orderData['date'])));
				}
			}

			$dataTo1C = array(
				"InputData" => array(
					"Customer" => array(
						"ID" => $auth_id,
					),
					"OrderNumber" => $orderId,
					"TimeOfOrder" => date("YmdHis", strtotime($orderData['date'])),
					"Address_ID" => $orderData['address_id'],					
					"CashPayment" => ($orderData['payment_type'] == "1" ? "true" : "false"),
					"StringsOfTable" => $products1C,
					"ExpressDelivery" => $expressDelivery,
					"pickup" => ($orderData['delivery_type'] == "1" ? "true" : "false")
				)	
			);
			//echo "<pre>" .$orderData['delivery_type']; print_r($dataTo1C); die;
			//echo "<pre>";			print_r($dataTo1C); die;
			return $result = $client->CreateNewDocumentAccount($dataTo1C);
		} else {
			return "No!";
		}
	}

	public function getItemsByWarehouse($items, $firstAddrId) {
		$retArr = array();
		$goods1c = array();
		foreach ($items as $value) {
			$goods1c[] = $value['article'];
		}
		$return = array(
			"near" => array(),
			"far" => array()
		);
		foreach ($items as $key => $good) {
			$warhG = $this->getQuantityByWarehouses($good['article']);
			if (isset($warhG['near'])) {
				if ($good['basket_count'] <= $warhG['near']) {
					$return['near'][] = $good;
				} else {
					$farCount = $good['basket_count'] - $warhG['near'];
					$good['basket_count'] = $warhG['near'];
					$return['near'][] = $good;
					$good['basket_count'] = $farCount;
					$return['far'][] = $good;
				}
			} else {
				$return['far'][] = $good;
			}
		}
		return $return;
	}

}
