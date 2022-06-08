<?php

namespace admin\customers;

class CustomersContr extends Customers {

	public function deleteCustomers($ids) {
		$this->unSetCustomers($ids);
	}

	public function saveRatingSettings($ratingSpending, $ratingPurchase, $ratingStorno, $ratingStornoPercentual, $ratingNumber, $ratingAutoStorno) {
		$this->setRatingSettings($ratingSpending, $ratingPurchase, $ratingStorno, $ratingStornoPercentual, $ratingNumber, $ratingAutoStorno);
	}

	public function saveCustomer($customerName, $customerSirname, $customerCompany, $customerPhone, $billingCountry, $billingCity, $billingZip, $billingStreet, $billingDescNumber, $shippingCountry, $shippingCity, $shippingZip, $shippingStreet, $shippingDescNumber, $customerNote, $email, $customerIds, $billingIds, $shippingIds) {
		$this->setCustomer($customerName, $customerSirname, $customerCompany, $customerPhone, $billingCountry, $billingCity, $billingZip, $billingStreet, $billingDescNumber, $shippingCountry, $shippingCity, $shippingZip, $shippingStreet, $shippingDescNumber, $customerNote, $email, $customerIds, $billingIds, $shippingIds);
	}

}