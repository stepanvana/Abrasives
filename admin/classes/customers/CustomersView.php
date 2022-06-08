<?php

namespace admin\customers;

class CustomersView extends Customers {

	public function showCustomers() {
		$result = $this->getCustomers();
		return $result;
	}

	public function showInfoCustomer($email) {
		$result = $this->getInfoCustomer($email);
		return $result;
	}

	public function showBillingCustomer($email) {
		$result = $this->getBillingCustomer($email);
		return $result;
	}

	public function showShippingCustomer($email) {
		$result = $this->getShippingCustomer($email);
		return $result;
	}

	public function showRatingSettings() {
		$result = $this->getRatingSettings();
		return $result;
	}

	public function showSpendings($email) {
		$result = $this->getSpendings($email);
		return $result;
	}

}