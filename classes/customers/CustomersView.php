<?php

namespace customers;

class CustomersView extends Customers {

	public function isCustomerLogged() {
		$isLogged = $this->checkCustomer();
		return $isLogged;
	}

	public function loginCustomer($uname, $upassword) {
		$result = $this->authCustomer($uname, $upassword);
		return $result;
	}

	public function logOutCustomer() {
		$result = $this->unAuthCustomer();
		return $result;
	}

	public function showCustomer($email) {
		$result = $this->getCustomer($email);
		return $result;
	}

	public function showAddress($id) {
		$result = $this->getAddress($id);
		return $result;
	}

}