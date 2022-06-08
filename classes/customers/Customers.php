<?php

namespace customers;

class Customers extends Dbh {

	public function random_str(
	    int $length = 64,
	    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
	): string {
	    if ($length < 1) {
	        throw new \RangeException("Length must be a positive integer");
	    }
	    $pieces = [];
	    $max = mb_strlen($keyspace, '8bit') - 1;
	    for ($i = 0; $i < $length; ++$i) {
	        $pieces []= $keyspace[random_int(0, $max)];
	    }
	    return implode('', $pieces);
	}

	protected function setCustomer($email, $psw, $phone) {
		$psw = password_hash($psw, PASSWORD_DEFAULT);
		$sql = "INSERT INTO registred (registred_name, registred_password, registred_email, registred_phone) VALUES (?,?,?,?)";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$email, $psw, $email, $phone])) {
			$sqlId = "SELECT MAX(registred_id) AS maxId FROM registred";
			if ($stmt = $this->connect()->query($sqlId)) {
				$result = $stmt->fetch();
				$registred_id = $result['maxId'];
				$key = $this->random_str();
				$sqlConfirm = "INSERT INTO registred_confirm (confirm_user_id, confirm_key, confirm_email) VALUES (?,?,?)";
				$stmt = $this->connect()->prepare($sqlConfirm);
				if ($stmt->execute([$registred_id, $key, $email])) {


					//Send e-mail with confirm link ----------------------------------

					$contactForm_subject = 'Potvzení registrace';
					$contactForm_message = 'Pro dokončení registrace klikněte na následující odkaz: www.abrasives.cz/email_confirm.php?email=' . $email . '&key=' . $key;
					$to_email = $email;
					$headers = 'From: stepanvana@abrasives.cz';
					if (mail($to_email, $contactForm_subject, $contactForm_message, $headers)) {
						header('Location: ?success_message#message');
					} else {
						header('Location: ?error_message#message');
					}

					//Send e-mail with confirm link ----------------------------------


					session_start();
					$_SESSION['customerId'] = $registred_id;
					$_SESSION['customerUid'] = $email;
					$_SESSION['customerType'] = 'customer';
					$_SESSION['customerConfirm'] = 0;

					$address = "SELECT customer_billing.billing_country, customer_billing.billing_street, customer_billing.billing_descNumber, customer_billing.billing_city, customer_billing.billing_zip, customer_shipping.shipping_country, customer_shipping.shipping_street, customer_shipping.shipping_descNumber, customer_shipping.shipping_city, customer_shipping.shipping_zip 
								FROM customer
								INNER JOIN customer_billing
									ON customer.customer_billing = customer_billing.billing_id
								INNER JOIN customer_shipping
									ON customer.customer_shipping = customer_shipping.shipping_id
								WHERE customer.customer_email = ?";
					$stmt = $this->connect()->prepare($address);
					if ($stmt->execute([$email])) {
						$resultAddress = $stmt->fetch();
						$sql = "INSERT INTO registred_billing(registred_id, billing_country, billing_street, billing_desc_num, billing_city, billing_zip) VALUES (?,?,?,?,?,?)";
						$stmt = $this->connect()->prepare($sql);
						if ($stmt->execute([$registred_id, $resultAddress['billing_country'], $resultAddress['billing_street'], $resultAddress['billing_descNumber'], $resultAddress['billing_city'], $resultAddress['billing_zip']])) {
							$sql = "INSERT INTO registred_shipping(registred_id, shipping_country, shipping_street, shipping_desc_num, shipping_city, shipping_zip) VALUES (?,?,?,?,?,?)";
							$stmt = $this->connect()->prepare($sql);
							if ($stmt->execute([$registred_id, $resultAddress['shipping_country'], $resultAddress['shipping_street'], $resultAddress['shipping_descNumber'], $resultAddress['shipping_city'], $resultAddress['shipping_zip']])) {
								return true;
							} else {
								return false;
							}
						} else {
							return false;
						}
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else {
				session_destroy();
				unset($_SESSION['customerId']);
				unset($_SESSION['customerUid']);
				unset($_SESSION['customerType']);
				unset($_SESSION['customerConfirm']);
				return false;
			}
		} else {
			session_destroy();
			unset($_SESSION['customerId']);
			unset($_SESSION['customerUid']);
			unset($_SESSION['customerType']);
			unset($_SESSION['customerConfirm']);
			return false;
		}
	}

	protected function validateEmail($email, $key) {
		$sql = "SELECT * FROM registred_confirm WHERE confirm_key=? AND confirm_email=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$key, $email])) {
			$result = $stmt->fetch();
			$id = $result['confirm_user_id'];
			$sqlConfirm = "UPDATE registred SET registred_confirm=1 WHERE registred_id=?";
			$stmt = $this->connect()->prepare($sqlConfirm);
			if ($stmt->execute([$id])) {
				$sqlDelete = "DELETE FROM registred_confirm WHERE confirm_user_id=?";
				$stmt = $this->connect()->prepare($sqlDelete);
				if ($stmt->execute([$id])) {
					session_start();
					if (isset($_SESSION['customerId']) && $_SESSION['customerType'] == 'customer') {
						$_SESSION['customerConfirm'] = 1;
					}
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	protected function authCustomer($uname, $upassword) {
		if (empty(trim($uname)) || empty(trim($upassword))) {
			return false;
		} else {
			$sql = "SELECT * FROM registred WHERE registred_email=?;";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$uname])) {
				$result = $stmt->fetch();
				if ($stmt->rowCount() > 0) {
					if (password_verify($upassword, $result['registred_password'])) {
						session_start();
						$_SESSION['fingerprint'] = md5($_SERVER['HTTP_USER_AGENT'] . 'PHRASE' . $_SERVER['REMOTE_ADDR']);
						if(!isset($_SESSION['start'])) {
							$_SESSION['start'] = time();
						}
						$_SESSION['customerId'] = $result['registred_id'];
						$_SESSION['customerUid'] = $result['registred_email'];
						$_SESSION['customerType'] = 'customer';
						if ($result['registred_confirm'] == 1) {
							$_SESSION['customerConfirm'] = 1;
						} else {
							$_SESSION['customerConfirm'] = 0;
						}
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}

	protected function checkCustomer() {
		if (isset($_SESSION['customerId'])) {
			return $_SESSION['customerId'];
		} else {
			return false;
		}
	}

	protected function unAuthCustomer() {
		session_destroy();
		unset($_SESSION['customerId']);
		unset($_SESSION['customerUid']);
		unset($_SESSION['customerType']);
		unset($_SESSION['customerConfirm']);
		return true;
	}

	protected function getCustomer($email) {
		$sql = "SELECT * FROM registred WHERE registred_email=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$email])) {
			$result = $stmt->fetch();
			return $result;
		} else {
			return false;
		}
	}

	protected function getAddress($id) {
		$sql = "SELECT 
				registred.registred_id, registred.registred_company, registred.registred_name, registred.registred_sirname, registred.registred_email, registred.registred_phone,
				registred_billing.billing_country, registred_billing.billing_street, registred_billing.billing_desc_num, registred_billing.billing_city, registred_billing.billing_zip,
				registred_shipping.shipping_country, registred_shipping.shipping_street, registred_shipping.shipping_desc_num, registred_shipping.shipping_city, registred_shipping.shipping_zip
				FROM registred
				JOIN registred_billing
					ON registred.registred_id = registred_billing.registred_id
				JOIN registred_shipping
					ON registred.registred_id = registred_shipping.registred_id
				WHERE registred.registred_id = ?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			$result = $stmt->fetch();
			return $result;
		} else {
			return false;
		}
	}

	protected function updateCustomer($name, $sirname, $company, $phone, $newPsw, $oldPsw, $id) {
		if (empty($newPsw)) {
			$sql = "UPDATE registred SET registred_name=?, registred_sirname=?, registred_company=?, registred_phone=? WHERE registred_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$name, $sirname, $company, $phone, $id])) {
				header('Location: ?successs');
			} else {
				header('Location: ?error');
			}
		} else {
			$sql = "SELECT * FROM registred WHERE registred_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$id])) {
				$pwd = $stmt->fetch();
			} else {
				header('Location: ?error');
			}
			$pwdCheck = password_verify($oldPsw, $pwd['registred_password']);
			if ($pwdCheck == false) {
				header('Location: ?error=wrong_password');
			} elseif ($pwdCheck == true) {
				$sql = "UPDATE registred SET registred_password=? WHERE registred_id=?";
				$stmt = $this->connect()->prepare($sql);
				$hashed_password = password_hash($newPsw, PASSWORD_DEFAULT);
				if ($stmt->execute([$hashed_password, $id])) {
					$sqlUpd = "UPDATE registred SET registred_name=?, registred_sirname=?, registred_company=?, registred_phone=? WHERE registred_id=?";
					$stmt = $this->connect()->prepare($sqlUpd);
					if ($stmt->execute([$name, $sirname, $company, $phone, $id])) {
						header("Location: ?success");
					} else {
						header('Location: ?error');
					}
				} else {
					header('Location: ?error');
				}
			}
		}
	}

	protected function setAddress($billingCountry, $billingCity, $billingZip, $billingStreet, $billingDescNum, $shippingCountry, $shippingCity, $shippingZip, $shippingStreet, $shippingDescNum, $id) {
		$sql = "INSERT INTO registred_billing(registred_id, billing_country, billing_street, billing_desc_num, billing_city, billing_zip) VALUES (?,?,?,?,?,?)";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id, $billingCountry, $billingStreet, $billingDescNum, $billingCity, $billingZip])) {
			$sql = "INSERT INTO registred_shipping(registred_id, shipping_country, shipping_street, shipping_desc_num, shipping_city, shipping_zip) VALUES (?,?,?,?,?,?)";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$id, $shippingCountry, $shippingStreet, $shippingDescNum, $shippingCity, $shippingZip])) {
				header("Location: ?success");
			} else {
				header('Location: ?error2');
			}
		} else {
			header('Location: ?error1');
		}
	}

	protected function updateAddress($billingCountry, $billingCity, $billingZip, $billingStreet, $billingDescNum, $shippingCountry, $shippingCity, $shippingZip, $shippingStreet, $shippingDescNum, $id) {
		$sql = "UPDATE registred_billing SET billing_country=?, billing_street=?, billing_desc_num=?, billing_city=?, billing_zip=? WHERE registred_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$billingCountry, $billingStreet, $billingDescNum, $billingCity, $billingZip, $id])) {
			$sql = "UPDATE registred_shipping SET shipping_country=?, shipping_street=?, shipping_desc_num=?, shipping_city=?, shipping_zip=? WHERE registred_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$shippingCountry, $shippingStreet, $shippingDescNum, $shippingCity, $shippingZip, $id])) {
				header("Location: ?success");
			} else {
				header('Location: ?error');
			}
		} else {
			header('Location: ?error');
		}
	}

	protected function unSetAddress($id) {
		$sql = "DELETE FROM registred_billing WHERE registred_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			$sql = "DELETE FROM registred_shipping WHERE registred_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$id])) {
				header("Location: ?success");
			} else {
				header('Location: ?error');
			}
		} else {
			header('Location: ?error');
		}
	}

	protected function addReview($id, $email, $name, $rating, $review) {
		$sql = "INSERT INTO reviews(product_id, review_email, review_name, review_rating, review_text) VALUES (?,?,?,?,?)";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id, $email, $name, $rating, $review])) {
			header("Location: ?success");
		} else {
			header('Location: ?error');
		}
	}

	protected function unSetReview($id) {
		$sql = "DELETE FROM reviews WHERE review_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			header("Location: ?success");
		} else {
			header('Location: ?error');
		}
	}

}