<?php

namespace users;

class UsersContr extends Users {

	public function createNewMessage($contactForm_name, $contactForm_email, $contactForm_subject, $contactForm_message, $ip_contact) {
		$result = $this->setNewMessage($contactForm_name, $contactForm_email, $contactForm_subject, $contactForm_message, $ip_contact);
		return $result;
	}

	public function createNewSub($email_sub, $ip_sub) {
		$result = $this->setNewSub($email_sub, $ip_sub);
		return $result;
	}

	//INDEX PAGE
	/*$productObj = new ProductsContr();
	$productObj->createProducts("$firstName", "$lastName", ...);*/

}