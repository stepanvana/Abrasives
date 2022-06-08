<?php

namespace admin\orders;

class OrdersContr extends Orders {

	public function saveOrders($ids, $condition) {
		$result = $this->setOrders($ids, $condition);
		return $result;
	}

	public function paidOrders($ids, int $status) {
		$result = $this->setPaymentStatus($ids, $status);
		return $result;
	}

	public function deleteOrders($ids) {
		$result = $this->unsetOrders($ids);
		return $result;
	}

	public function saveOrderDetails($id, $customerName, $customerSirname, $customerCompany, $orderDate, $orderCode, $customerEmail, $customerPhone, $billingCountry, $billingCity, $billingStreet, $billingDescNumber, $billingZip, $shippingCountry, $shippingCity, $shippingStreet, $shippingDescNumber, $shippingZip, $orderCondition, $orderShipping, $paymentMethod, $paymentStatus, $productQuantity, $completedQuantity, $productIds) {
		$result = $this->setOrderDetails($id, $customerName, $customerSirname, $customerCompany, $orderDate, $orderCode, $customerEmail, $customerPhone, $billingCountry, $billingCity, $billingStreet, $billingDescNumber, $billingZip, $shippingCountry, $shippingCity, $shippingStreet, $shippingDescNumber, $shippingZip, $orderCondition, $orderShipping, $paymentMethod, $paymentStatus, $productQuantity, $completedQuantity, $productIds);
		return $result;
	}

	public function addOrderProducts($id, $newProduct, $newProductAmount) {
		$result = $this->setOrderProducts($id, $newProduct, $newProductAmount);
		return $result;
	}

	public function addComments($id, $comment) {
		$result = $this->setComments($id, $comment);
		return $result;
	}

	public function deleteOrder($id) {
		$result = $this->unSetOrder($id);
		return $result;
	}

	public function deleteProducts($id, $ids) {
		$result = $this->unSetProducts($id, $ids);
		return $result;
	}

	public function duplicateOrder(int $id) {
		$result = $this->copyOrder($id);
		return $result;
	}

}