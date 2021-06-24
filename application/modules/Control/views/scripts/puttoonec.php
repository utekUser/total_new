<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-lr-0 catalog-page">	
	<?php
	foreach ($this->users as $val) {
		$modelAddress = new User_Models_UserAddress();
		$addrArr = $modelAddress->getUserAddr($val['id']);
		if (is_object($addrArr)) {
			if (count($addrArr) > 0) {
				/* $modelInfo = new User_Models_UserInfo();
				  $info = $modelInfo->getUserInfo($val['id']);

				  $data = array(
				  "name" => $info['name'],
				  "inn" => trim($info['inn']),
				  "email" => $val['email'],
				  "phone" => $info['phone'],
				  "ip" => $info['ip']
				  );
				  $address1C["Adress"] = array();
				  foreach ($addrArr as $key => $value) {
				  $address1C["Adress"][] = array(
				  "ID" => $value['id'],
				  "Name" => $value['address'],
				  "Active" => true
				  );
				  }

				  echo "<pre>";
				  print_r($data);
				  print_r($address1C);
				  echo "</pre>";

				  $shopExchange = new Shop_Models_ShopExchange();
				  $result = $shopExchange->registrationRequest($val['id'], $data, $address1C); */
			} else {
				$modelInfo = new User_Models_UserInfo();
				$info = $modelInfo->getUserInfo($val['id']);
				$data = array(
					"name" => $info['name'],
					"inn" => trim($info['inn']),
					"email" => $val['email'],
					"phone" => $info['phone'],
					"ip" => $info['ip']
				);

				$modelAddress = new User_Models_UserAddress();
				$idA = $modelAddress->saveAddr(array(
					"user_id" => $val['id'],
					"address" => $info['address']
				));

				$address1C["Adress"] = array(
					"ID" => $idA,
					"Name" => $info['address'],
					"Active" => true
				);

				echo "<pre>";
				print_r($data);
				print_r($address1C);
				echo "</pre>";

				$shopExchange = new Shop_Models_ShopExchange();
				$result = $shopExchange->registrationRequest($val['id'], $data, $address1C);
			}
		}
	}
	/* $modelAddress = new User_Models_UserAddress();
	  foreach ($this->addrArr as $userId => $value) {
	  foreach ($value as $addr) {
	  $modelAddress->saveAddr(array(
	  "user_id" => $userId,
	  "address" => $addr
	  ));
	  }
	  } */
	?>	
</div>