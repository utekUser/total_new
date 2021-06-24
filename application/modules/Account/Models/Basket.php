<?php

class Account_Models_Basket extends Engine_Model_Abstract {

	protected $_dbTableName = 'Account_Models_DbTable_Basket';
	protected $_formTableName = 'account_basket';
	protected $_orderBy = 'id DESC';

	public function deleteIfCountNull($data) {
		$set = array(
			'deleted' => 1
		);
		$this->getDbTable()->update($set, array(
			"user_id = ?" => $data['user_id'],
			"deleted = ?" => 0,
			"count = ?" => 0
		));
	}
	
	public function countToNull($data) {
		$set = array(
			'count' => 0
		);
		$this->getDbTable()->update($set, array(
			"user_id = ?" => $data['user_id'],
			"good_id = ?" => $data['good_id']
		));
	}

	public function repeatBasket($data) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('user_id = ?', $data['user_id'])
			->where('good_id = ?', $data['good_id'])
			->where('count = ?', $data['count'])
			->where('deleted = ?', 0);
		$result = $table->fetchAll($select);
		if (count($result) > 0) {
			
		} else {
			$set = array(
				'user_id' => $data['user_id'],
				'good_id' => $data['good_id'],
				'count' => $data['count'],
				'added_date' => $data['added_date'],
				'deleted' => 0
			);
			$table->insert($set);
		}
	}

	public function basketAdd($data) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('user_id = ?', $data['user_id'])
			->where('good_id = ?', $data['good_id'])
			->where('deleted = ?', 0);
		$result = $table->fetchAll($select);
		if (count($result) > 0) {
			$set = array('deleted' => 1);
			$this->getDbTable()->update($set, array(
				"user_id = ?" => $data['user_id'],
				"good_id = ?" => $data['good_id']
			));
		} else {
			$select = $table->select()
				->where('user_id = ?', $data['user_id'])
				->where('good_id = ?', $data['good_id'])
				->where('deleted = ?', 1);
			$result = $table->fetchAll($select);
			if (count($result) > 0) {
				$set = array(
					'count' => 1,
					'added_date' => $data['added_date'],
					'deleted' => 0
				);
				$this->getDbTable()->update($set, array(
					"user_id = ?" => $data['user_id'],
					"good_id = ?" => $data['good_id']
				));
			} else {
				$set = array(
					'user_id' => $data['user_id'],
					'good_id' => $data['good_id'],
					'count' => 1,
					'added_date' => $data['added_date'],
					'deleted' => 0
				);
				$table->insert($set);
			}
		}
	}

	public function getBasketByData($data) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('user_id = ?', $data['user_id'])
			->where('good_id = ?', $data['good_id'])
			->where('deleted = ?', 0);
		$result = $table->fetchAll($select);
		if (count($result) > 0) {
			return "Yes!";
		} else {
			return "No!";
		}
	}

	public function getAllBasket($data) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('user_id = ?', $data['user_id'])
			->where('deleted = ?', 0);
		$result = $table->fetchAll($select);
		return count($result);
	}

	public function getAllBasketCount($data) {
		$registry = Engine_Api::getInstance();
		$db = $registry->getContainer()->db;
		$this->_tablePrefix = $registry->getContainer()->tablePrefix;
		$userPriceType = "4f69c3fc-71ad-43b8-9928-c28f1b502292";

		$select = $db->select()
			->from(
				array('d' => $this->_tablePrefix . 'account_basket'), array('d.count AS basket_count'))
			->joinLeft(
				array('a' => $this->_tablePrefix . 'view_goods_wc_wp'), 'd.good_id = a.id', array('a.price')
			)
			->where("a.price_id = ?", $userPriceType)
			->where("d.user_id = ?", $data['user_id'])
			->where("d.deleted = ?", 0)
			->order('a.price ASC');
		$result = $db->fetchAll($select);

		$resSumm = 0;
		foreach ($result as $key => $value) {
			$resSumm += $value['basket_count'] * $value['price'];
		}
		return $resSumm;
	}

	public function getPriceWithDiscount($data, $addrId) {
		$allPrice = 0;
		$itemsInBasket = $this->getAllBasketGoods($data);
		$goods1c = array();
		foreach ($itemsInBasket as $value) {
			$goods1c[] = $value['article'];
		}
		$shopExchange = new Shop_Models_ShopExchange();
		$goodsSale = $shopExchange->getPrice($goods1c, $addrId);
		$res = "";
		foreach ($itemsInBasket as $key => $item) {
			$priceItem = $item['price'];
			foreach ($goodsSale as $key => $value) {
				if ($item['article'] == $value->Product->ID) {
					$priceItem = $value->Price;
				}
			}
			$icP = $priceItem * $item['basket_count'];
			$allPrice += $icP;
		}
		return $allPrice;
	}

	public function getAllBasketGoods($data) {
		$registry = Engine_Api::getInstance();
		$db = $registry->getContainer()->db;
		$this->_tablePrefix = $registry->getContainer()->tablePrefix;
		$userPriceType = "4f69c3fc-71ad-43b8-9928-c28f1b502292";

		$select = $db->select()
			->from(
				array('d' => $this->_tablePrefix . 'account_basket'), array('d.count AS basket_count'))
			->joinLeft(
				array('a' => $this->_tablePrefix . 'view_goods_wc_wp'), 'd.good_id = a.id', array('a.id', 'a.article', 'a.good_id', 'a.image', 'a.name', 'a.price')
			)
			->where("a.price_id = ?", $userPriceType)
			->where("d.user_id = ?", $data['user_id'])
			->where("d.deleted = ?", 0)
			->group('a.id')
			->order('a.price ASC');
		$result = $db->fetchAll($select);
		//echo "<pre>"; print_r($result); die;
		return $result;
	}

	public function oneMinus($data) {
		$table = $this->getDbTable();
		$select = $table->select()
			->where('user_id = ?', $data['user_id'])
			->where('good_id = ?', $data['good_id'])
			->where('deleted = ?', 0);
		$result = $table->fetchAll($select);

		if ($result[0]['count'] == 1) {
			return $result[0]['count'];
		} else {
			$data1 = array(
				'count' => new Zend_Db_Expr('count - 1')
			);
			$table->update($data1, array('id = ?' => $result[0]['id']));
			return $result[0]['count'] - 1;
		}
	}

	public function onePlus($data) {
		/* $modelGood = new Shop_Models_OrderGood();
		  $onecId = $modelGood->getOnecIdById($data['good_id']);
		  $modelStock = new Shop_Models_OrderStock();
		  $countInStock = $modelStock->getGoodCountInStocks($onecId); */
		$modelGood = new Shop_Models_OrderGood();
		$article = $modelGood->getArticleById($data['good_id']);
		$shopExchange = new Shop_Models_ShopExchange();
		$countInStock = $shopExchange->getTotalQuantity($article);

		$table = $this->getDbTable();
		$select = $table->select()
			->where('user_id = ?', $data['user_id'])
			->where('good_id = ?', $data['good_id'])
			->where('deleted = ?', 0);
		$result = $table->fetchAll($select);

		if ($result[0]['count'] == $countInStock) {
			return "over";
		} else {
			$data1 = array(
				'count' => new Zend_Db_Expr('count + 1')
			);
			$table->update($data1, array('id = ?' => $result[0]['id']));
			return $result[0]['count'] + 1;
		}
	}

	public function oneDelete($data) {
		$table = $this->getDbTable();
		$data1 = array(
			'deleted' => 1
		);
		$table->update($data1, array(
			'user_id = ?' => $data['user_id'],
			'good_id = ?' => $data['good_id'],
		));
		return "Yes!";
	}

	public function clearBasket($data) {
		$table = $this->getDbTable();
		$data1 = array(
			'deleted' => 1
		);
		$table->update($data1, array(
			'user_id = ?' => $data['user_id'],
		));
		return "Yes!";
	}

}
