<?php

namespace admin\orders;

class OrdersView extends Orders {

	public function showOrders(int $condition=NULL) {
		$result = $this->getOrders($condition);
		return $result;
	}

	public function showOrderDetail(int $id) {
		$result = $this->getOrderDetail($id);
		return $result;
	}

	public function showOrderProducts(int $id) {
		$result = $this->getOrderProducts($id);
		return $result;
	}
	
	public function showComments(int $id) {
		$result = $this->getComments($id);
		return $result;
	}

	public function showCustomerOrders(string $email) {
		$result = $this->getCustomerOrders($email);
		return $result;
	}

}