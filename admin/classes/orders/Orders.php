<?php

namespace admin\orders;

class Orders extends Dbh {

	protected function getOrders(int $condition=NULL) {
		if (empty($condition)) {
			$whereClause = "";
		} else {
			$whereClause = " WHERE order_condition=?";
		}
		$sql = "SELECT
				orders.order_id, orders.order_code, orders.order_date, orders_condition.condition_condition, shipping.shipping_method, customer.customer_name, customer.customer_sirname, payment.payment_amount, payment_method.paymentMethod_method, payment_status.paymentStatus_status
				FROM orders
				INNER JOIN orders_condition
					ON orders.order_condition=orders_condition.condition_id
				INNER JOIN shipping
					ON orders.order_shipping=shipping.shipping_id
				INNER JOIN customer
					ON orders.order_id=customer.order_id
				INNER JOIN payment
					ON orders.order_id=payment.order_id
				INNER JOIN payment_method
					ON payment.payment_methodId=payment_method.paymentMethod_id
				INNER JOIN payment_status
					ON payment.payment_status=payment_status.paymentStatus_id
				".$whereClause;
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$condition])) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			return false;
		}
	}

	protected function getCustomerOrders(string $email) {
		$sql = "SELECT
				orders.order_id, orders.order_code, orders.order_date, orders_condition.condition_condition, shipping.shipping_method, customer.customer_name, customer.customer_sirname, customer.customer_admin_notes, payment.payment_amount, payment_method.paymentMethod_method, payment_status.paymentStatus_status
				FROM orders
				INNER JOIN orders_condition
					ON orders.order_condition=orders_condition.condition_id
				INNER JOIN shipping
					ON orders.order_shipping=shipping.shipping_id
				INNER JOIN customer
					ON orders.order_id=customer.order_id
				INNER JOIN payment
					ON orders.order_id=payment.order_id
				INNER JOIN payment_method
					ON payment.payment_methodId=payment_method.paymentMethod_id
				INNER JOIN payment_status
					ON payment.payment_status=payment_status.paymentStatus_id
				WHERE customer.customer_email=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt -> execute([$email])) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			header('Location: ?error=get_customers');
		}
	}

	protected function setOrders($ids, $condition) {
		$saveSuccess = false;
		for ($i=0; $i < count($ids); $i++) {
			$sql = "UPDATE orders SET order_condition=? WHERE order_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$condition[$i], $ids[$i]])) {
				$saveSuccess = true;
			}
		}
		if ($saveSuccess === true) {
			return true;
		} else {
			return false;
		} 
	}

	protected function setPaymentStatus($ids, int $status) {
		$paidSuccess = false;
		for ($i=0; $i < count($ids); $i++) { 
			$sql = "UPDATE payment SET payment_status=? WHERE order_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$status, $ids[$i]])) {
				$paidSuccess = true;
			}
		}
		if ($paidSuccess === true) {
			return true;
		} else {
			return false;
		} 
	}

	protected function unsetOrders($ids) {
		$deleteSuccess = false;
		for ($i=0; $i < count($ids); $i++) { 
			$sql = "DELETE orders, customer FROM orders JOIN customer ON orders.order_id = customer.order_id WHERE orders.order_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$ids[$i]])) {
				$deleteSuccess = true;
			}
		}
		if ($deleteSuccess === true) {
			return true;
		} else {
			return false;
		} 
	}

	protected function getOrderDetail(int $id) {
		$sql = "SELECT
				orders.order_id, orders.order_code, orders.order_date, 
				orders_condition.condition_condition, 
				shipping.shipping_method, 
				customer.customer_id, customer.customer_name, customer.customer_company, customer.customer_sirname, customer.customer_email, customer.customer_phone,
				customer_billing.billing_country, customer_billing.billing_street, customer_billing.billing_descNumber, customer_billing.billing_city, customer_billing.billing_zip, 
				customer_shipping.shipping_country, customer_shipping.shipping_street, customer_shipping.shipping_descNumber, customer_shipping.shipping_city, customer_shipping.shipping_zip, 
				payment.payment_amount, payment_method.paymentMethod_method, payment_status.paymentStatus_status				
				FROM orders
				JOIN orders_condition
					ON orders.order_condition=orders_condition.condition_id
				JOIN shipping
					ON orders.order_shipping=shipping.shipping_id
				JOIN customer
					ON orders.order_id=customer.order_id
				JOIN customer_billing
					ON customer.customer_billing=customer_billing.billing_id
				JOIN customer_shipping
					ON customer.customer_shipping=customer_shipping.shipping_id 	
				JOIN payment
					ON orders.order_id=payment.order_id
				JOIN payment_method
					ON payment.payment_methodId=payment_method.paymentMethod_id
				JOIN payment_status
					ON payment.payment_status=payment_status.paymentStatus_id
				WHERE orders.order_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			$result = $stmt->fetch();
			return $result;
		} else {
			header('Location: &error=get_order_data');
		}
	}

	protected function getOrderProducts(int $id) {
		$sql = "SELECT 	products.product_id ,
						products.product_url ,
	                    products.product_code ,
	                    products.product_name ,
	                    products.product_desc ,
	                    products.product_shortDesc ,
	                    products.product_category ,
	                    products.product_sub_category ,
	                    products.product_storage ,
	                    products.product_related ,
	                    products.product_image ,
	                    products.product_discount ,
	                    products.product_price ,
	                    (products.product_price*(1-(products.product_discount/100))) AS price ,
	                    products.product_image ,
	                    orders_products.orders_products_id ,
	                    orders_products.product_id ,
	                    orders_products.quantity ,
	                    orders_products.price ,
	                    orders_products.discount ,
	                    orders_products.costs ,
	                    orders_products.completed ,
	                    products_categories.category_name ,
	                    products_sub_categories.sub_categories_name
                FROM products
                JOIN orders_products
                	ON products.product_id = orders_products.product_id
                JOIN products_categories
                	ON products.product_category = products_categories.category_id
                JOIN products_sub_categories
                	ON products.product_sub_category = products_sub_categories.sub_categories_id
                WHERE orders_products.order_id = ?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			header('Location: &error=get_order_data');
		}
	}

	protected function getComments(int $id) {
		$sql = "SELECT orders_comments.comment_comment, orders_comments.comment_date, users.user_name, users.user_image  
				FROM orders_comments 
				INNER JOIN users
					ON orders_comments.comment_user=users.user_id
				WHERE order_id = ?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			header('Location: &error=get_order_data');
		}
	}

	protected function setOrderDetails($id, $customerName, $customerSirname, $customerCompany, $orderDate, $orderCode, $customerEmail, $customerPhone, $billingCountry, $billingCity, $billingStreet, $billingDescNumber, $billingZip, $shippingCountry, $shippingCity, $shippingStreet, $shippingDescNumber, $shippingZip, $orderCondition, $orderShipping, $paymentMethod, $paymentStatus, $productQuantity, $completedQuantity, $productIds) {
		$sql = "UPDATE orders
				INNER JOIN payment
					ON orders.order_id=payment.order_id	
				INNER JOIN customer
					ON orders.order_id=customer.order_id
				INNER JOIN customer_billing
					ON customer.customer_billing=customer_billing.billing_id
				INNER JOIN customer_shipping
					ON customer.customer_shipping=customer_shipping.shipping_id
				SET orders.order_code=?, orders.order_shipping=?, orders.order_condition=?, orders.order_date=?,
					payment.payment_methodId=?, payment.payment_status=?,
					customer.customer_company=?, customer.customer_name=?, customer.customer_sirname=?, customer.customer_email=?, customer.customer_phone=?,
					customer_billing.billing_country=?, customer_billing.billing_street=?, customer_billing.billing_descNumber=?, customer_billing.billing_city=?, customer_billing.billing_zip=?,
					customer_shipping.shipping_country=?, customer_shipping.shipping_street=?, customer_shipping.shipping_descNumber=?, customer_shipping.shipping_city=?, customer_shipping.shipping_zip=?
				WHERE orders.order_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$orderCode, $orderShipping, $orderCondition, $orderDate, $paymentMethod, $paymentStatus, $customerCompany, $customerName, $customerSirname, $customerEmail, $customerPhone, $billingCountry, $billingStreet, $billingDescNumber, $billingCity, $billingZip, $shippingCountry, $shippingStreet, $shippingDescNumber, $shippingCity, $shippingZip, $id])) {
			$editSuccess = false;
			if (count($productIds) > 0) {
				for ($i=0; $i < count($productIds); $i++) { 
					$sqlProducts = "UPDATE orders_products SET quantity=?, completed=completed+? WHERE order_id=? AND product_id=?";
					$stmtProducts = $this->connect()->prepare($sqlProducts);
					if ($stmtProducts->execute([$productQuantity[$i], $completedQuantity[$i], $id, $productIds[$i]])) {
						$editSuccess = true;
					} else {
						return false;
					}
				}
			} else {
				$editSuccess = true;
			}
			if ($editSuccess == true) {
				if ($this->updatePayment($id) == true) {
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

	protected function setOrderProducts($id, $newProduct, $newProductAmount) {
		$addSuccess = false;
		if (empty($newProduct)) {
			return true;
		} elseif (count($newProduct) > 0) {
			for ($i=0; $i < count($newProduct); $i++) {
				$sql = "INSERT INTO orders_products (order_id, product_id, quantity, price, discount, costs)
						SELECT ?,?,?,product_price, product_discount, product_purchase_price
							FROM products
						WHERE product_id=?";
				$stmt = $this->connect()->prepare($sql);
				if ($stmt->execute([$id, $newProduct[$i], $newProductAmount[$i], $newProduct[$i]])) {
					$addSuccess = true;
				}
			}
			if ($addSuccess == true) {
				if ($this->updatePayment($id) == true) {
				 	return true;
				} else {
				 	return false;
				}
			} else {
				return false;
			}
		}
	}

	protected function updatePayment($id) {
		$totalAmount = $this->getOrderPrice($id);
		$sql = "UPDATE payment SET payment_amount=? WHERE order_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$totalAmount, $id])) {
			return true;
		} else {
			return false;
		}
	}

	protected function setComments($id, $comment) {
		$addComment = false;
		if (empty($comment)) {
			return true;
		} elseif (count($comment) > 0) {
			for ($i=0; $i < count($comment); $i++) {
				if ($comment[$i] !== "") {
					$sql = "INSERT INTO orders_comments (order_id, comment_comment, comment_user) VALUES (?,?,?)";
					$stmt = $this->connect()->prepare($sql);
					if ($stmt->execute([$id, $comment[$i], $_SESSION['userId']])) {
						$addComment = true;
					}
				} else {
					$addComment = true;
				}
			}
			if ($addComment == true) {
				return true;
			} else {
				return false;
			}	
		}
	}

	protected function unSetOrder($id) {
		$sql = "DELETE FROM orders WHERE order_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			return true;
		} else {
			return false;
		}
	}

	protected function getOrderPrice(int $id) {
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

	protected function unSetProducts($id, $ids) {
		$deleteSuccess = false;
		for ($i=0; $i < count($ids); $i++) { 
			$sql = "DELETE FROM orders_products WHERE product_id=? AND order_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$ids[$i], $id])) {
				$deleteSuccess = true;
			}
		}
		if ($deleteSuccess == true) {
			$totalAmount = $this->getOrderPrice($id);
			$sql = "UPDATE payment SET payment_amount=? WHERE order_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$totalAmount, $id])) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	protected function copyOrder(int $id) {
		$sql = "SET @newOrderId = (SELECT MAX(order_id) FROM orders)+1;
				SET @newCustomerId = (SELECT MAX(customer_id) FROM customer)+1;
				SET @billingId = (SELECT customer_billing FROM customer WHERE order_id=?);
				SET @shippingId = (SELECT customer_shipping FROM customer WHERE order_id=?);

				INSERT INTO orders (order_code, order_shipping, order_employee, order_condition, order_date)
				SELECT CONCAT('ONUM',@newOrderId), order_shipping, order_employee, order_condition, current_timestamp()
				FROM orders
				WHERE order_id=?;

				INSERT INTO customer (order_id, customer_company, customer_name, customer_sirname, customer_email, customer_phone, customer_billing, customer_shipping, customer_contactAllow, customer_note)
				SELECT @newOrderId, customer_company, customer_name, customer_sirname, customer_email, customer_phone, @newOrderId, @newOrderId, customer_contactAllow, customer_note
				FROM customer
				WHERE order_id=?;

				INSERT INTO customer_billing
				SELECT @newOrderId, billing_country, billing_street, billing_descNumber, billing_city, billing_zip
				FROM customer_billing
				WHERE billing_id=@billingId;

				INSERT INTO customer_shipping
				SELECT @newOrderId, shipping_country, shipping_street, shipping_descNumber, shipping_city, shipping_zip
				FROM customer_shipping
				WHERE shipping_id=@shippingId;

				INSERT INTO orders_comments (order_id, comment_comment, comment_date, comment_user)
				SELECT @newOrderId, comment_comment, current_timestamp(), comment_user
				FROM orders_comments
				WHERE order_id=?;

				INSERT INTO orders_products (order_id, product_id, quantity, price, discount, costs)
				SELECT @newOrderId, product_id, quantity, price, discount, costs
				FROM orders_products
				WHERE order_id=?;

				INSERT INTO payment (order_id, payment_methodId, payment_amount, payment_date, payment_creditCardNumber, payment_creditCardExpDate, payment_cardHolderName, payment_status)
				SELECT @newOrderId, payment_methodId, payment_amount, current_timestamp(), payment_creditCardNumber, payment_creditCardExpDate, payment_cardHolderName, payment_status
				FROM payment
				WHERE order_id=?;";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id,$id,$id,$id,$id,$id,$id])) {
			$sql = "SELECT MAX(order_id) AS maxID FROM orders";
			if ($stmt = $this->connect()->query($sql)) {
				$result = $stmt->fetch();
				header("Location: ?id=" . $result['maxID'] . "&success");
			} else {
				header("Location: ?id=" . $id . "&error=order_edit");
			}
		} else {
			header("Location: ?id=" . $id . "&error=order_edit");
		}
	}

}