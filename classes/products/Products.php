<?php

namespace products;

class Products extends Dbh {

	protected function getBestSellingProducts($category=NULL, $subcategory=NULL, $orderBy=NULL) {
		if (!is_null($orderBy)) {
			$sql = "SELECT products.product_id, products.product_url, products.product_sold, products.product_name, products.product_price, products.product_category, products.product_image, products_categories.category_name, products.product_discount, (products.product_price*(1-(products.product_discount/100))) AS price
					FROM products
					JOIN products_categories
						ON products.product_category = products_categories.category_id
					WHERE products.product_price > 0 AND products.product_visibility = 1
					ORDER BY products." . $orderBy . " DESC LIMIT 4";
			if ($stmt = $this->connect()->query($sql)) {
				$result = $stmt->fetchAll();
				return $result;
			} else {
				return false;
			}
		} else {
			if (!is_null($category) && is_null($subcategory)) {
				$sql = "SELECT products.product_id, products.product_url, products.product_sold, products.product_name, products.product_price, products.product_category, products.product_image, products_categories.category_name, products.product_discount, (products.product_price*(1-(products.product_discount/100))) AS price
						FROM products
						JOIN products_categories
							ON products.product_category = products_categories.category_id
						JOIN products_sub_categories
							ON products.product_sub_category = products_sub_categories.sub_categories_id
						WHERE products.product_price > 0 AND products.product_visibility = 1 AND products_categories.category_url=?
						ORDER BY products.product_sold DESC LIMIT 6";
				$stmt = $this->connect()->prepare($sql);
				if ($stmt->execute([$category])) {
					$result = $stmt->fetchAll();
					return $result;
				} else {
					return false;
				}
			} elseif (!is_null($category) && !is_null($subcategory)) {
				$sql = "SELECT products.product_id, products.product_url, products.product_sold, products.product_name, products.product_price, products.product_category, products.product_image, products_categories.category_name, products.product_discount, (products.product_price*(1-(products.product_discount/100))) AS price
						FROM products
						JOIN products_categories
							ON products.product_category = products_categories.category_id
						JOIN products_sub_categories
							ON products.product_sub_category = products_sub_categories.sub_categories_id
						WHERE products.product_price > 0 AND products.product_visibility = 1 AND products_categories.category_url=? AND products_sub_categories.sub_categories_url=?
						ORDER BY products.product_sold DESC LIMIT 6";
				$stmt = $this->connect()->prepare($sql);
				if ($stmt->execute([$category, $subcategory])) {
					$result = $stmt->fetchAll();
					return $result;
				} else {
					return false;
				}
			} else {
				$sql = "SELECT products.product_id, products.product_url, products.product_sold, products.product_name, products.product_price, products.product_category, products.product_image, products_categories.category_name, products.product_discount, (products.product_price*(1-(products.product_discount/100))) AS price
						FROM products
						JOIN products_categories
							ON products.product_category = products_categories.category_id
						WHERE products.product_price > 0 AND products.product_visibility = 1
						ORDER BY products.product_sold DESC LIMIT 6";
				if ($stmt = $this->connect()->query($sql)) {
					$result = $stmt->fetchAll();
					return $result;
				} else {
					return false;
				}	
			}	
		}
	}

	protected function getProducts($category=NULL, $subcategory=NULL, $sort=NULL) {
		if ($sort=="nejnovejsi") {
			$orderBy = " ORDER BY products.product_id ASC";
		} elseif ($sort=="nejprodavanejsi") {
			$orderBy = " ORDER BY products.product_sold DESC";
		} elseif ($sort=="nejlevnejsi") {
			$orderBy = " ORDER BY price ASC";
		} elseif ($sort=="nejdrazsi") {
			$orderBy = " ORDER BY price DESC";
		} else {
			$orderBy = "";
		}
		if (!is_null($category) && is_null($subcategory)) {
			$sql = "SELECT products.product_id, products.product_url, products.product_sold, products.product_name, products.product_price, products.product_category, products.product_image, products_categories.category_name, products.product_discount, (products.product_price*(1-(products.product_discount/100))) AS price
					FROM products
					JOIN products_categories
						ON products.product_category = products_categories.category_id
					JOIN products_sub_categories
						ON products.product_sub_category = products_sub_categories.sub_categories_id
					WHERE products.product_price>0 AND products.product_visibility=1 AND products_categories.category_url=?
					$orderBy";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$category])) {
				$result = $stmt->fetchAll();
				return $result;
			} else {
				return false;
			}
		} elseif (!is_null($category) && !is_null($subcategory)) {
			$sql = "SELECT products.product_id, products.product_url, products.product_sold, products.product_name, products.product_price, products.product_category, products.product_image, products_categories.category_name, products.product_discount, (products.product_price*(1-(products.product_discount/100))) AS price
					FROM products
					JOIN products_categories
						ON products.product_category = products_categories.category_id
					JOIN products_sub_categories
						ON products.product_sub_category = products_sub_categories.sub_categories_id
					WHERE products.product_price>0 AND products.product_visibility=1 AND products_categories.category_url=? AND products_sub_categories.sub_categories_url=?
					$orderBy";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$category, $subcategory])) {
				$result = $stmt->fetchAll();
				return $result;
			} else {
				return false;
			}
		} else {
			$sql = "SELECT products.product_id, products.product_url, products.product_sold, products.product_name, products.product_price, products.product_category, products.product_image, products_categories.category_name, products.product_discount, (products.product_price*(1-(products.product_discount/100))) AS price
					FROM products
					JOIN products_categories
						ON products.product_category = products_categories.category_id
					JOIN products_sub_categories
						ON products.product_sub_category = products_sub_categories.sub_categories_id
					WHERE products.product_price>0 AND products.product_visibility=1
					$orderBy";
			if ($stmt = $this->connect()->query($sql)) {
				$result = $stmt->fetchAll();
				return $result;
			}
		}		
	}	

	protected function getProductsDetail(int $id=NULL, string $related=NULL) {
		if ($id!=NULL) {
			$sql = "SELECT products.product_id, products.product_url, products.product_desc, products.product_shortDesc, products.product_sold, products.product_name, products.product_price, products.product_category, products.product_image, products.product_related, products.product_purchase_price, products_categories.category_name, products_sub_categories.sub_categories_name, products.product_discount, (products.product_price*(1-(products.product_discount/100))) AS price FROM products
					JOIN products_categories
						ON products.product_category = products_categories.category_id
					JOIN products_sub_categories
						ON products.product_sub_category = products_sub_categories.sub_categories_id
					WHERE product_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$id])) {
				$result = $stmt->fetch();
				return $result;	
			} else {
				return false;
			}
		}
		if ($related!=NULL) {
	        $relatedArray = explode(';', $related);
	        $relatedIds = implode(',', array_fill(0, count($relatedArray), '?'));
	        $sql = "SELECT product_id, product_url, product_desc, product_shortDesc, product_sold, product_name, product_price, product_purchase_price, product_category, product_image, product_related, product_discount, (product_price*(1-(product_discount/100))) AS price FROM products WHERE product_id IN ($relatedIds) LIMIT 6";
	        $stmt = $this->connect()->prepare($sql);
	        if (!empty($relatedArray)) {
				$i = 0;
				foreach ($relatedArray as $bind) {
					$stmt->bindValue(++$i, $bind);
				}
			}
			if ($stmt->execute()) {
				$result1 = $stmt->fetchAll();
				return $result1;
			} else {
				return false;
			}
		}
	}

	protected function getCategories() {
		$sql = "SELECT * FROM products_categories";
		if ($stmt = $this->connect()->query($sql)) {
			$result = $stmt->fetchAll();
			return $result;
		}
	}

	protected function getSubCategories() {
		$sql = "SELECT * FROM products_sub_categories";
		if ($stmt = $this->connect()->query($sql)) {
			$result = $stmt->fetchAll();
			return $result;
		}
	}

	protected function getParams($id=NULL) {
		$sql = "SELECT products_params.param_id, products_params.param_sub_cat, products_params.param_name, products_sub_categories.sub_categories_name, products_sub_categories.sub_categories_url
				FROM products_params
				INNER JOIN products_sub_categories
					ON products_params.param_sub_cat = products_sub_categories.sub_categories_id";
		if ($stmt = $this->connect()->query($sql)) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			header('Location: '.$_SERVER['PHP_SELF'].'&error=get_category');
		}
	}

	protected function getParamsValues($id=NULL) {
		if (!is_null($id)) {
			$sql = "SELECT products_params_values.value_id, products_params_values.value_product_id, products_params_values.value_param_id, products_params_values.value_value, products_params.param_name
				FROM products_params_values
				INNER JOIN products_params
					ON products_params_values.value_param_id = products_params.param_id
				WHERE products_params_values.value_product_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$id])) {
				$result = $stmt->fetchAll();
				return $result;
			} else {
				return false;
			}
		}
		$sql = "SELECT value_id, value_product_id, value_param_id, value_value, COUNT(value_value) AS total FROM products_params_values GROUP BY value_param_id, value_value";
		if ($stmt = $this->connect()->query($sql)) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			return false;
		}		
	}

	protected function findProducts($item, $sort=NULL) {
		if (is_null($sort)) {
			$sql = "SELECT product_id, product_code, product_name, product_category, product_sub_category, product_url, product_image, product_discount, product_price, (product_price*(1-(product_discount/100))) AS price
					FROM products
					WHERE
						product_code LIKE CONCAT('%', ?, '%') OR
						product_name LIKE CONCAT('%', ?, '%') OR
						product_url LIKE CONCAT('%', ?, '%')
					LIMIT 10";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$item, $item, $item])) {
				$result = $stmt->fetchAll();
				return $result;
			} else {
				return false;
			}	
		} else {
			if ($sort=="nejnovejsi") {
				$orderBy = " ORDER BY products.product_id ASC ";
			} elseif ($sort=="nejprodavanejsi") {
				$orderBy = " ORDER BY products.product_sold DESC ";
			} elseif ($sort=="nejlevnejsi") {
				$orderBy = " ORDER BY price ASC ";
			} elseif ($sort=="nejdrazsi") {
				$orderBy = " ORDER BY price DESC ";
			} else {
				$orderBy = "";
			}
			$sql = "SELECT product_id, product_code, product_name, product_category, product_sub_category, product_url, product_image, product_discount, product_price, (product_price*(1-(product_discount/100))) AS price
					FROM products
					WHERE
						product_code LIKE CONCAT('%', ?, '%') OR
						product_name LIKE CONCAT('%', ?, '%') OR
						product_url LIKE CONCAT('%', ?, '%')
					$orderBy
					LIMIT 10";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$item, $item, $item])) {
				$result = $stmt->fetchAll();
				return $result;
			} else {
				return false;
			}	
		}
	}

	protected function findCategories($item) {
		$sql = "SELECT category_id, category_name, category_url
				FROM products_categories
				WHERE
					category_name LIKE CONCAT('%', ?, '%') OR
					category_url LIKE CONCAT('%', ?, '%')
				LIMIT 10";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$item, $item])) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			return false;
		}
	}

	protected function getReviews($id) {
		$sql = "SELECT reviews.review_id, reviews.product_id, reviews.review_email, reviews.review_date, reviews.review_rating, reviews.review_text, registred.registred_name
				FROM reviews 
				INNER JOIN registred
					ON reviews.review_email = registred.registred_id
				WHERE reviews.product_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			return false;
		}
	}

}