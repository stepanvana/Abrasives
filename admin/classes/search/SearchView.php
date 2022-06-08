<?php

namespace admin\search;

class searchView extends Search {

	public function showOrders(string $search) {
		$result = $this->getOrders($search);
		return $result;
	}

	public function showProducts(string $search) {
		$result = $this->getProducts($search);
		return $result;
	}

	public function showCustomers(string $search) {
		$result = $this->getCustomers($search);
		return $result;
	}

}