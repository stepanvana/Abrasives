<?php

namespace admin\statistics;

class Statistics extends Dbh {

	protected function getDataByDate($from=NULL, $to=NULL) {
		if ($from!==NULL && $to!==NULL) {
			$whereClause = " WHERE orders.order_date BETWEEN (?) AND (?) AND orders.order_condition <> 5 ";
			$sql = "SELECT 
					orders.order_date, DAY(orders.order_date) AS dayGraph, MONTH(orders.order_date) AS monthGraph, SUM(orders_products.quantity*orders_products.price) AS income, SUM((orders_products.quantity*orders_products.price)-(orders_products.quantity*orders_products.costs)) AS earnings, SUM(orders_products.quantity) AS quantity, COUNT(DISTINCT(orders.order_id)) AS numberOrders
					FROM orders
					JOIN payment
						ON orders.order_id = payment.order_id
					JOIN orders_products
						ON orders.order_id = orders_products.order_id
					".$whereClause."
					GROUP BY DAY(orders.order_date)";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$from, $to])) {
				$result = $stmt->fetchAll();
				return $result;
			} else {
				header('Location: ?error=get_data');
			}
		} else {
			$sql = "SELECT 
					orders.order_date, DAY(orders.order_date) AS dayGraph, MONTH(orders.order_date) AS monthGraph, SUM(orders_products.quantity*orders_products.price) AS income, SUM((orders_products.quantity*orders_products.price)-(orders_products.quantity*orders_products.costs)) AS earnings, SUM(orders_products.quantity) AS quantity, COUNT(DISTINCT(orders.order_id)) AS numberOrders
					FROM orders
					JOIN payment
						ON orders.order_id = payment.order_id
					JOIN orders_products
						ON orders.order_id = orders_products.order_id
					WHERE NOT orders.order_condition = 5
					GROUP BY DAY(orders.order_date)";
			if ($stmt = $this->connect()->query($sql)) {
				$result = $stmt->fetchAll();
				return $result;
			} else {
				header('Location: ?error=get_data');
			}
		}
	}

	protected function getDataOrders($from=NULL, $to=NULL) {
		if ($from!==NULL && $to!==NULL) {
			$whereClause = " WHERE orders.order_date BETWEEN (?) AND (?)";
		} else {
			$whereClause = "";
		}
		$sql = "SELECT order_date, 
				DATE_FORMAT(order_date, '%Y') as 'year',
				DATE_FORMAT(order_date, '%m') as 'month',
				DATE_FORMAT(order_date, '%d') as 'day',
				COUNT(order_id) as 'total',
				SUM(if(order_condition = '5', 1, 0)) AS 'totalStorno'
				FROM orders
				".$whereClause."
				GROUP BY DATE_FORMAT(order_date, '%Y%m%d')";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$from, $to])) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			header('Location: ?error=get_data');
		}
	}

	protected function getDateProducts($from=NULL, $to=NULL) {
		if ($from!==NULL && $to!==NULL) {
			$whereClause = " WHERE orders.order_date BETWEEN (?) AND (?) AND orders.order_condition <> 5 ";
		} else {
			$whereClause = " WHERE NOT orders.order_condition = 5 ";
		}
		$sql = "SELECT
				COUNT(DISTINCT(orders.order_id)) AS totalOrders,
				SUM(orders_products.quantity) AS sumProducts,
				DAY(orders.order_date) AS dayGraph,
				MONTH(orders.order_date) AS monthGraph,
				orders.order_date
				FROM orders
				JOIN orders_products
					ON orders.order_id=orders_products.order_id
				".$whereClause."
				GROUP BY DATE_FORMAT(orders.order_date, '%Y%m%d')";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$from, $to])) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			header('Location: ?error=get_data');
		}
	}

	protected function getIdProducts($from=NULL, $to=NULL) {
		if ($from!==NULL && $to!==NULL) {
			$whereClause = " WHERE orders.order_date BETWEEN (?) AND (?) AND orders.order_condition <> 5 ";
		} else {
			$whereClause = " WHERE NOT orders.order_condition = 5 ";
		}
		$sql = "SELECT
				orders_products.product_id,
				SUM(orders_products.quantity) AS sumProducts,
				products.product_name,
				products.product_code,
				SUM(orders_products.quantity*orders_products.price) AS income,
				orders_products.price
				FROM orders_products
				JOIN products
					ON orders_products.product_id=products.product_id
				JOIN orders
					ON orders_products.order_id=orders.order_id
				".$whereClause."
				GROUP BY orders_products.product_id";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$from, $to])) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			header('Location: ?error=get_data');
		}
	}

	protected function getLatestOrders() {
		$sql = "SELECT 
				orders.order_id, orders.order_code, orders.order_condition, orders.order_date, payment.payment_amount, orders_condition.condition_condition
				FROM orders 
				JOIN payment 
					ON orders.order_id=payment.order_id
				JOIN orders_condition
					ON orders.order_condition=orders_condition.condition_id
				ORDER BY orders.order_date DESC LIMIT 5";
		if ($stmt = $this->connect()->query($sql)) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			return false;
		}
	}

}