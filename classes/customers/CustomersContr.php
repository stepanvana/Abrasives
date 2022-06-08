<?php

namespace customers;

class CustomersContr extends Customers {

	public function registerCustomer($email, $psw, $psw_confirm, $phone) {
		if (empty(trim($email)) || empty(trim($psw)) || empty(trim($psw_confirm)) || empty(trim($phone))) {
			header('Location: ?error_message=wrong_input');
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			header('Location: ?error_message=wrong_email');
		} elseif ($psw !== $psw_confirm) {
			header('Location: ?error_message=wrong_psw');
		} else {
			$result = $this->setCustomer($email, $psw, $phone);
			return $result;	
		}		
	}

	public function confirmEmail($email, $key) {
		$result = $this->validateEmail($email, $key);
		return $result;	
	}

	public function saveCustomer($post, $id) {
		$name = $post['customerName'];
		$sirname = $post['customerSirname'];
		$company = $post['customerCompany'];
		$phone = $post['customerPhone'];
		$newPsw = $post['customerNewPsw'];
		$oldPsw = $post['customerOldPsw'];
		$this->updateCustomer($name, $sirname, $company, $phone, $newPsw, $oldPsw, $id);
	}

	public function createAddress($post, $id) {
		$billingCountry = $post['billingCountry'];
		$billingCity = $post['billingCity'];
		$billingZip = $post['billingZip'];
		$billingStreet = $post['billingStreet'];
		$billingDescNum = $post['billingDescNum'];
		$shippingCountry = $post['shippingCountry'];
		$shippingCity = $post['shippingCity'];
		$shippingZip = $post['shippingZip'];
		$shippingStreet = $post['shippingStreet'];
		$shippingDescNum = $post['shippingDescNum'];
		$this->setAddress($billingCountry, $billingCity, $billingZip, $billingStreet, $billingDescNum, $shippingCountry, $shippingCity, $shippingZip, $shippingStreet, $shippingDescNum, $id);
	}

	public function saveAddress($post, $id) {
		$billingCountry = $post['billingCountry'];
		$billingCity = $post['billingCity'];
		$billingZip = $post['billingZip'];
		$billingStreet = $post['billingStreet'];
		$billingDescNum = $post['billingDescNum'];
		$shippingCountry = $post['shippingCountry'];
		$shippingCity = $post['shippingCity'];
		$shippingZip = $post['shippingZip'];
		$shippingStreet = $post['shippingStreet'];
		$shippingDescNum = $post['shippingDescNum'];
		$this->updateAddress($billingCountry, $billingCity, $billingZip, $billingStreet, $billingDescNum, $shippingCountry, $shippingCity, $shippingZip, $shippingStreet, $shippingDescNum, $id);
	}

	public function deleteAddress($id) {
		$this->unSetAddress($id);
	}

	public function sendReview($id, $email, $name, $post) {
		$rating = $post['rating'];
		$review = $post['review'];
		$this->addReview($id, $email, $name, $rating, $review);
	}

	public function deleteReview($id) {
		$this->unSetReview($id);
	}

}