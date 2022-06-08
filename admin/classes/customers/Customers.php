<?php

namespace admin\customers;

class Customers extends Dbh {

	protected function getCustomers(int $id=NULL) {
		$sql = "SELECT 
				customer.customer_id, COUNT(customer.order_id) AS totalOrders, customer.customer_company, customer.customer_name, customer.customer_sirname, customer.customer_email, customer.customer_phone,
				customer_billing.billing_country, customer_billing.billing_street, customer_billing.billing_descNumber, customer_billing.billing_city, customer_billing.billing_zip,
				customer_shipping.shipping_country, customer_shipping.shipping_street, customer_shipping.shipping_descNumber, customer_shipping.shipping_city, customer_shipping.shipping_zip
				FROM customer
				INNER JOIN customer_billing
					ON customer.customer_billing = customer_billing.billing_id
				INNER JOIN customer_shipping
					ON customer.customer_shipping = customer_shipping.shipping_id
				GROUP BY customer.customer_email";
		if ($stmt = $this->connect()->query($sql)) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			header('Location: ?error=get_customers');
		}
	}

	protected function unSetCustomers($ids) {
		$delete = false;
		for ($i=0; $i < count($ids); $i++) { 
			$sql = "DELETE customer, orders FROM customer JOIN orders ON customer.order_id = orders.order_id WHERE customer_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$ids[$i]])) {
				$delete = true;
			}
		}
		if ($delete == true) {
			header("Location: ?success");
		} else {
			header('Location: ?error=customers_edit');
		}
	}

	protected function getInfoCustomer($email) {
		$sql = "SELECT customer_id, customer_name, customer_sirname, customer_phone, customer_email, customer_company FROM customer WHERE customer_email=? GROUP BY customer_name, customer_sirname, customer_phone, customer_email, customer_company";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$email])) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			header('Location: ?error=get_customers');
		}
	}

	protected function getBillingCustomer($email) {
		$sql = "SELECT customer_billing FROM customer WHERE customer_email=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$email])) {
			$result = $stmt->fetchAll();
			$result = array_column($result, 'customer_billing');
			$sql = "SELECT billing_id, billing_country, billing_street, billing_descNumber, billing_city, billing_zip FROM customer_billing WHERE billing_id IN(";
			foreach ($result as $val) {
				$params[] = "?";
				$binds[] = $val;
			}
			$stmt = $this->connect()->prepare($sql . join(", ", $params) . ") GROUP BY billing_country, billing_street, billing_descNumber, billing_city, billing_zip");
			$i = 0;
			foreach ($binds as $bind) {
				$stmt->bindValue(++$i, $bind);
			}
			if ($stmt->execute()) {
				$result1 = $stmt->fetchAll();
				return $result1;
			} else {
				header('Location: ?error=get_customers');
			}
		}
	}

	protected function getShippingCustomer($email) {
		$sql = "SELECT customer_shipping FROM customer WHERE customer_email=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$email])) {
			$result = $stmt->fetchAll();
			$result = array_column($result, 'customer_shipping');
			$sql = "SELECT shipping_id, shipping_country, shipping_street, shipping_descNumber, shipping_city, shipping_zip FROM customer_shipping WHERE shipping_id IN(";
			foreach ($result as $val) {
				$params[] = "?";
				$binds[] = $val;
			}
			$stmt = $this->connect()->prepare($sql . join(", ", $params) . ") GROUP BY shipping_country, shipping_street, shipping_descNumber, shipping_city, shipping_zip");
			$i = 0;
			foreach ($binds as $bind) {
				$stmt->bindValue(++$i, $bind);
			}
			if ($stmt->execute()) {
				$result1 = $stmt->fetchAll();
				return $result1;
			} else {
				header('Location: ?error=get_customers');
			}
		}
	}

	protected function getRatingSettings() {
		$sql = "SELECT * FROM rating_settings";
		if ($stmt = $this->connect()->query($sql)) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			header('Location: ?error=get_data');
		}
	}

	protected function setRatingSettings($ratingSpending, $ratingPurchase, $ratingStorno, $ratingStornoPercentual, $ratingNumber, $ratingAutoStorno) {
		$sql = "UPDATE rating_settings SET rating_number=?, rating_spending=?, rating_purchase=?, rating_storno=?, rating_storno_percentual=?, rating_auto_storno=? WHERE rating_id=1";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$ratingNumber, $ratingSpending, $ratingPurchase, $ratingStorno, $ratingStornoPercentual, $ratingAutoStorno])) {
			header("Location: ?success");
		} else {
			header('Location: ?error=settings_edit');
		}
	}

	protected function setCustomer($customerName, $customerSirname, $customerCompany, $customerPhone, $billingCountry, $billingCity, $billingZip, $billingStreet, $billingDescNumber, $shippingCountry, $shippingCity, $shippingZip, $shippingStreet, $shippingDescNumber, $customerNote, $email, $customerIds, $billingIds, $shippingIds) {
		$personalSuccess = false;
		for ($i=0; $i < count($customerName); $i++) { 
			$sql = "UPDATE customer SET customer_company=?, customer_name=?, customer_sirname=?, customer_phone=? WHERE customer_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$customerCompany[$i], $customerName[$i], $customerSirname[$i], $customerPhone[$i], $customerIds[$i]])) {
				$sql = "UPDATE customer SET customer_admin_notes=? WHERE customer_email=?";
				$stmt = $this->connect()->prepare($sql);
				if ($stmt->execute([$customerNote, $email])) {
					$personalSuccess = true;
				} else {
					$personalSuccess = false;
				}
			} else {
				$personalSuccess = false;
				exit();
			}
		}
		if ($personalSuccess == true) {
			$billingSuccess = false;
			for ($i=0; $i < count($billingCountry); $i++) { 
				$sql = "UPDATE customer_billing SET billing_country=?, billing_street=?, billing_descNumber=?, billing_city=?, billing_zip=? WHERE billing_id=?";
				$stmt = $this->connect()->prepare($sql);
				if ($stmt->execute([$billingCountry[$i], $billingStreet[$i], $billingDescNumber[$i], $billingCity[$i], $billingZip[$i], $billingIds[$i]])) {
					$billingSuccess = true;
				} else {
					$billingSuccess = false;
				}
			}
		}
		if ($billingSuccess == true) {
			$shippingSuccess = false;
			for ($i=0; $i < count($shippingCountry); $i++) { 
				$sql = "UPDATE customer_shipping SET shipping_country=?, shipping_street=?, shipping_descNumber=?, shipping_city=?, shipping_zip=? WHERE shipping_id=?";
				$stmt = $this->connect()->prepare($sql);
				if ($stmt->execute([$shippingCountry[$i], $shippingStreet[$i], $shippingDescNumber[$i], $shippingCity[$i], $shippingZip[$i], $shippingIds[$i]])) {
					$shippingSuccess = true;
				} else {
					$shippingSuccess = false;
					exit();
				}
			}
		}
		if ($personalSuccess == true && $billingSuccess == true && $shippingSuccess == true) {
			header("Location: ?customer=" . $email . "&success");
		} else {
			header('Location: ?error=customers_edit');
		}
	}

	protected function getSpendings($email) {
		$sql = "SELECT SUM(payment.payment_amount) AS suma
				FROM orders
				JOIN payment
					ON orders.order_id = payment.order_id
				JOIN customer
					ON orders.order_id = customer.order_id
				WHERE customer.customer_email=? AND orders.order_condition IN (1,2,3,4)";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$email])) {
			$result = $stmt->fetch();
			return $result;
		} else {
			header('Location: ?error=get_customers');
		}
	}

}