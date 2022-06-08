<?php

namespace orders;

class Orders extends Dbh {

	public $lastId;
	public $orderId;

	function __construct() {
		$sqlLastId = "SELECT MAX(customer_id) FROM customer";
		if ($stmtLastId = $this->connect()->query($sqlLastId)) {
			$id = $stmtLastId->fetch();
			if ($id==NULL) {
				$this->lastId = 0;
			} else {
				$this->lastId = implode(" ", $id);
			}
		} else {
			return false;
		}

		$sqlOrderId = "SELECT MAX(order_id) FROM orders";
		if ($stmtOrderId = $this->connect()->query($sqlOrderId)) {
			$orderId = $stmtOrderId->fetch();
			if ($orderId==NULL) {
				$this->orderId = 0;
			} else {
				$this->orderId = implode(" ", $orderId);
			}
		} else {
			return false;
		}
	}

	protected function countOrderAmount(int $id) {
		$amountSuccess = false;
		$totalAmount = 0;
		$sqlAmount = "SELECT quantity, price, discount FROM orders_products WHERE order_id=?";
		$stmtAmount = $this->connect()->prepare($sqlAmount);
		if ($stmtAmount->execute([$id])) {
			$resultAmount = $stmtAmount->fetchAll();
			foreach ($resultAmount as $row) {
				$totalAmount = $totalAmount + ($row['quantity']*$row['price']);
				$amountSuccess = true;
			}
			if ($amountSuccess == true) {
				return $totalAmount;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	protected function setCustomer(string $company, string $name, string $sirname, string $email, string $phone, int $contactAllow, string $note) {
		if (empty(trim($name)) || empty(trim($sirname)) || empty(trim($email)) || empty(trim($phone))) {
			return false;
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return false;
		} else {
			$sql = "SELECT * FROM registred WHERE registred_email=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$email])) {
				$result = $stmt->fetch();
				if (!empty($result)) {
					$registred = $result['registred_id'];
				} else {
					$registred = NULL;
				}
			}
			$sql = "INSERT INTO customer (order_id, customer_registred, customer_company, customer_name, customer_sirname, customer_email, customer_phone, customer_billing, customer_shipping, customer_contactAllow, customer_note) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
			$stmt = $this->connect()->prepare($sql);
			$customerId = $this->lastId + 1;
			if ($stmt->execute([$this->orderId, $registred, $company, $name, $sirname, $email, $phone, $customerId, $customerId, $contactAllow, $note])) {
				$this->lastId = $this->lastId + 1;
				return true;
			} else {
				return false;
			}	
		}
	}

	protected function setBillingAddress(string $billingCountry, string $billingStreet, string $billingDescNumber, string $billingCity, string $billingZip) {
		if (empty(trim($billingCountry)) || empty(trim($billingStreet)) || empty(trim($billingDescNumber)) || empty(trim($billingCity)) || empty(trim($billingZip))) {
			return false;
		} else {
			$sql = "INSERT INTO customer_billing (billing_id, billing_country, billing_street, billing_descNumber, billing_city, billing_zip) VALUES (?,?,?,?,?,?)";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$this->lastId, $billingCountry, $billingStreet, $billingDescNumber, $billingCity, $billingZip])) {
				return true;
			} else {
				return false;
			}	
		}
	}

	protected function setShippingAddress(string $shippingCountry=NULL, string $shippingStreet=NULL, string $shippingDescNumber=NULL, string $shippingCity=NULL, string $shippingZip=NULL) {
		$sql = "INSERT INTO customer_shipping (shipping_id, shipping_country, shipping_street, shipping_descNumber, shipping_city, shipping_zip) VALUES (?,?,?,?,?,?)";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$this->lastId, $shippingCountry, $shippingStreet, $shippingDescNumber, $shippingCity, $shippingZip])) {
			return true;
		} else {
			return false;
		}
	}

	protected function setOrder(string $shipping) {
		$sql = "INSERT INTO orders (order_code, order_shipping, order_employee) VALUES (?,?,?)";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute(["TBA", $shipping, 1])) {
			$this->orderId = $this->orderId + 1;
			$orderCode = "ONUM".$this->orderId;
			$sqlCode = "UPDATE orders SET order_code=? WHERE order_id=?";
			$stmtCode = $this->connect()->prepare($sqlCode);
			if ($stmtCode->execute([$orderCode, $this->orderId])) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	protected function setOrdersProducts() {
		if(isset($_SESSION['shopping_cart'])) {
			$sql = "INSERT INTO orders_products (order_id, product_id, quantity, price, discount, costs) VALUES (?,?,?,?,?,?)";
            $stmt = $this->connect()->prepare($sql);
            $doesproductsexists = false;
            foreach ($_SESSION['shopping_cart'] as $key => $product) {
                $doesproductsexists = true;
                $stmt->execute([$this->orderId, $product['id'], $product['quantity'], $product['price'], $product['discount'], $product['costs']]);

                $sqlStorage = "UPDATE products SET product_storage = (product_storage-?) WHERE product_id = ?";
				$stmtStorage = $this->connect()->prepare($sqlStorage);
				if (!$stmtStorage->execute([$product['quantity'], $product['id']])) {
					$doesproductsexists = false;
				}
				$sqlStorage = "UPDATE products SET product_sold = (product_sold+?) WHERE product_id = ?";
				$stmtStorage = $this->connect()->prepare($sqlStorage);
				if (!$stmtStorage->execute([$product['quantity'], $product['id']])) {
					$doesproductsexists = false;
				}
            }
            if ($doesproductsexists == true) {
            	return true;
            } else {
            	return false;
            }
		} else {
			return false;
		}
	}

	protected function setPayment(int $paymentMethod, int $creditCardNumber=NULL, int $creditCardExpDate=NULL, int $cardHolderName=NULL) {
		$amount = $this->countOrderAmount($this->orderId);
		$sql = "INSERT INTO payment (order_id, payment_methodId, payment_amount, payment_creditCardNumber, payment_creditCardExpDate, payment_cardHolderName) VALUES (?,?,?,?,?,?)";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$this->orderId, $paymentMethod, $amount, $creditCardNumber, $creditCardExpDate, $cardHolderName])) {
			return true;
		} else {
			return false;
		}
	}

}