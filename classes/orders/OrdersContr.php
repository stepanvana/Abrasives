<?php

namespace orders;

class OrdersContr extends Orders {

	public function createBillingAddress(string $billingCountry, string $billingStreet, string $billingDescNumber, string $billingCity, string $billingZip) {
		$resultBilling = $this->setBillingAddress($billingCountry, $billingStreet, $billingDescNumber, $billingCity, $billingZip);
		return $resultBilling;
	}

	public function createShippingAddress(string $shippingCountry, string $shippingStreet, string $shippingDescNumber, string $shippingCity, string $shippingZip) {
		$resultShipping = $this->setShippingAddress($shippingCountry, $shippingStreet, $shippingDescNumber, $shippingCity, $shippingZip);
		return $resultShipping;
	}

	public function createCustomer(string $company, string $name, string $sirname, string $email, string $phone, int $contactAllow, string $note) {
		$resultCustomer = $this->setCustomer($company, $name, $sirname, $email, $phone, $contactAllow, $note);
		return $resultCustomer;
	}

	public function createOrder(string $shipping) {
		$resultOrder = $this->setOrder($shipping);
		return $resultOrder;
	}

	public function createOrdersProducts() {
		$resultOrdersProducts = $this->setOrdersProducts();
		return $resultOrdersProducts;
	}

	public function createPayment(int $paymentMethod, int $creditCardNumber=NULL, int $creditCardExpDate=NULL, int $cardHolderName=NULL) {
		$resultPayment = $this->setPayment($paymentMethod, $creditCardNumber, $creditCardExpDate, $cardHolderName);
		return $resultPayment;
	}

}