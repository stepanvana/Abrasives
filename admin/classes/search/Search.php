<?php

namespace admin\search;

class Search extends Dbh {

	protected function getOrders(string $search) {
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
				WHERE orders.order_code=? OR customer.customer_sirname=? OR customer.customer_email=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$search, $search, $search])) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			header('Location: ?error=get_data');
		}
	}

	protected function getProducts(string $search) {
		$sql = "SELECT products.product_id, products.product_code, products.product_name, products.product_price, products.product_storage, products_categories.category_name
				FROM products
				INNER JOIN products_categories
					ON products.product_category = products_categories.category_id
				WHERE products.product_code=? OR products.product_name=? OR products_categories.category_name=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$search, $search, $search])) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			header('Location: ?error=get_data');
		}
	}
	
	protected function getCustomers(string $search) {
		$sql = "SELECT 
				customer.customer_id, COUNT(customer.order_id) AS totalOrders, customer.customer_company, customer.customer_name, customer.customer_sirname, customer.customer_email, customer.customer_phone,
				customer_billing.billing_country, customer_billing.billing_street, customer_billing.billing_descNumber, customer_billing.billing_city, customer_billing.billing_zip,
				customer_shipping.shipping_country, customer_shipping.shipping_street, customer_shipping.shipping_descNumber, customer_shipping.shipping_city, customer_shipping.shipping_zip
				FROM customer
				INNER JOIN customer_billing
					ON customer.customer_billing = customer_billing.billing_id
				INNER JOIN customer_shipping
					ON customer.customer_shipping = customer_shipping.shipping_id
				WHERE customer.customer_email=? OR customer.customer_sirname=? OR customer.customer_company=?
				GROUP BY customer.customer_email";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$search, $search, $search])) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			header('Location: ?error=get_data');
		}
	}
	

}