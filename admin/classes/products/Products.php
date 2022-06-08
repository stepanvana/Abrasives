<?php

namespace admin\products;

class Products extends Dbh {

	protected function getProducts($ids=NULL) {
		if (is_null($ids)) {
			$sql = "SELECT products.product_id, products.product_code, products.product_name, products.product_desc, products.product_shortDesc, products.product_price, products.product_purchase_price, products.product_discount, products.product_category, products.product_storage, products.product_sold, products.product_availibility, products.product_minus_shopping, products.product_visibility, products.product_related, products.product_image, products.product_url, products_categories.category_name, products.product_sub_category, products_sub_categories.sub_categories_name, products.product_date
					FROM products
					JOIN products_categories
						ON products.product_category = products_categories.category_id
					JOIN products_sub_categories
                		ON products.product_sub_category = products_sub_categories.sub_categories_id
					ORDER BY products.product_id ASC";
			if ($stmt = $this->connect()->query($sql)) {
				$result = $stmt->fetchAll();
				return $result;
			} else {
				header('Location: &error=asd');
			}
		} else {
	        $usedIds = implode(',', array_fill(0, count($ids), '?'));
			$sql = "SELECT products.product_id, products.product_code, products.product_name, products.product_desc, products.product_shortDesc, products.product_price, products.product_purchase_price, products.product_discount, products.product_category, products.product_storage, products.product_sold, products.product_availibility, products.product_minus_shopping, products.product_visibility, products.product_related, products.product_image, products.product_url, products_categories.category_name, products.product_sub_category, products_sub_categories.sub_categories_name, products.product_date
					FROM products
					JOIN products_categories
						ON products.product_category = products_categories.category_id
					JOIN products_sub_categories
                		ON products.product_sub_category = products_sub_categories.sub_categories_id
					WHERE product_id NOT IN ($usedIds)
					ORDER BY products.product_id ASC";
			$stmt = $this->connect()->prepare($sql);
	        if (!empty($ids)) {
				$i = 0;
				foreach ($ids as $bind) {
					$stmt->bindValue(++$i, $bind);
				}
			}
			if ($stmt->execute()) {
				$result = $stmt->fetchAll();
				return $result;
			} else {
				return false;
			}
		}
	}

	protected function setProducts($ids, $productStorage, $productVisibility) {
		$saveSuccess = false;
		for ($i=0; $i < count($ids); $i++) {
	    	$sql = "UPDATE products SET product_storage=?, product_visibility=? WHERE product_id=?";
	    	$stmt = $this->connect()->prepare($sql);
	    	if ($stmt->execute([$productStorage[$i], $productVisibility[$i], $ids[$i]])) {
	    		$saveSuccess = true;
	    	}
		}
		if ($saveSuccess == true) {
			header("Location: ?success");
		} else {
			header('Location: ?error=set_product');
		}
	}

	protected function setVisibility($ids, $visibility) {
		$visibilitySuccess = false;
		for ($i=0; $i < count($ids); $i++) {
	    	$sql = "UPDATE products SET product_visibility=? WHERE product_id=?";
	    	$stmt = $this->connect()->prepare($sql);
	    	if ($stmt->execute([$visibility, $ids[$i]])) {
	    		$visibilitySuccess = true;
	    	}
		}
		if ($visibilitySuccess == true) {
			header("Location: ?success");
		} else {
			header('Location: ?error=set_product');
		}
	}

	protected function unSetProducts($ids) {
		$deleteSuccess = false;
		for ($i=0; $i < count($ids); $i++) {
	    	$sql = "DELETE FROM products WHERE product_id=?";
	    	$stmt = $this->connect()->prepare($sql);
	    	if ($stmt->execute([$ids[$i]])) {
	    		$sqlParam = "DELETE FROM products_params_values WHERE value_product_id=?";
	    		$stmt = $this->connect()->prepare($sqlParam);
	    		if ($stmt->execute([$ids[$i]])) {
	    			$deleteSuccess = true;
	    		} else {
	    			$deleteSuccess = false;
	    		}
	    	} else {
	    		$deleteSuccess = false;
	    	}
		}
		if ($deleteSuccess == true) {
			header("Location: ?success");
		} else {
			header('Location: ?error=set_product');
		}
	}

	protected function getCategories() {
		$sql = "SELECT * FROM products_categories";
		if ($stmt = $this->connect()->query($sql)) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			header('Location: &error=get_category');
		}
	}

	protected function getSubCat($id=NULL) {
		if (is_null($id)) {
			$sql = "SELECT * FROM products_sub_categories";
			if ($stmt = $this->connect()->query($sql)) {
				$result = $stmt->fetchAll();
				return $result;
			} else {
				header('Location: &error=get_category');
			}	
		} else {
			$sql = "SELECT * FROM products_sub_categories WHERE sub_categories_category=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$id])) {
				$result = $stmt->fetchAll();
				return $result;
			} else {
				header('Location: &error=get_category');
			}	
		}		
	}

	protected function getParams($id=NULL) {
		if (is_null($id)) {
			$sql = "SELECT * FROM products_params";
			if ($stmt = $this->connect()->query($sql)) {
				$result = $stmt->fetchAll();
				return $result;
			} else {
				header('Location: &error=get_category');
			}
		} else {
			$sql = "SELECT * FROM products_params WHERE param_sub_cat=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$id])) {
				$result = $stmt->fetchAll();
				return $result;
			} else {
				header('Location: &error=get_category');
			}
		}
	}

	protected function getParamsValues($id=NULL) {
		$sql = "SELECT * FROM products_params_values";
		if ($stmt = $this->connect()->query($sql)) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			return false;
		}		
	}

	protected function setCategory($name, $url) {
		$sql = "INSERT INTO products_categories(category_name, category_url) VALUES (?,?)";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$name, $url])) {
			header("Location: ?success");
		} else {
			header("Location: ?error=category");
		}
	}

	protected function setSubCategory($category, $name, $url) {
		$sql = "INSERT INTO products_sub_categories(sub_categories_category, sub_categories_name, sub_categories_url) VALUES (?,?,?)";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$category, $name, $url])) {
			header("Location: ?success");
		} else {
			header("Location: ?error=category");
		}
	}

	protected function setParam($subCategory, $name) {
		$sql = "INSERT INTO products_params(param_sub_cat, param_name) VALUES (?,?)";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$subCategory, $name])) {
			header("Location: ?success");
		} else {
			header("Location: ?error=category");
		}
	}

	protected function setName($editedName, $newName, $url) {
		if (substr($editedName, 0, 3) === 'cat') {
			$sql = "UPDATE products_categories SET category_name=?, category_url=? WHERE category_id=?";
			$stmt = $this->connect()->prepare($sql);
			$editedName = substr($editedName, 4);
			if ($stmt->execute([$newName, $url, $editedName])) {
				header("Location: ?success");
			} else {
				header("Location: ?error=set_name");
			}
		} elseif (substr($editedName, 0, 3) === 'sub') {
			$sql = "UPDATE products_sub_categories SET sub_categories_name=?, sub_categories_url=? WHERE sub_categories_id=?";
			$stmt = $this->connect()->prepare($sql);
			$editedName = substr($editedName, 4);
			if ($stmt->execute([$newName, $url, $editedName])) {
				header("Location: ?success");
			}
		} elseif (substr($editedName, 0, 3) === 'par') {
			$sql = "UPDATE products_params SET param_name=? WHERE param_id=?";
			$stmt = $this->connect()->prepare($sql);
			$editedName = substr($editedName, 4);
			if ($stmt->execute([$newName, $editedName])) {
				header("Location: ?success");
			}
		} else {
			header("Location: ?error=set_name");
		}
	}

	protected function unSetCategory(int $id) {
		$sql = "DELETE FROM products_categories WHERE category_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			header("Location: ?success");
		} else {
			header("Location: ?error=delete_cat");
		}
	}

	protected function unSetSubCategory(int $id) {
		$sql = "DELETE FROM products_sub_categories WHERE sub_categories_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			header("Location: ?success");
		} else {
			header("Location: ?error=delete_cat");
		}
	}

	protected function unSetParam(int $id) {
		$sql = "DELETE FROM products_params WHERE param_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			header("Location: ?success");
		} else {
			header("Location: ?error=delete_cat");
		}
	}

	protected function getProduct(int $id) {
		$sql = "SELECT * FROM products WHERE product_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			$result = $stmt->fetch();
			return $result;
		} else {
			header('Location: &error=get_products');
		}
	}

	protected function setProduct($nazevProduktu, $urlProduktu, $kodProduktu, $kratkyPopis, $podrobnyPopis, $podKategorieProdukt, $param, $paramValue, $viditelnostProdukt, $cenaProduktu, $nakupniCenaProduktu, $slevaProduktu, $stavSkladuProduktu, $dostupnostProduktu, $minusovyProduktu, $odstranitProdukt=NULL, $souvisejiciProdukt=NULL, $images, $id) {
		if (!empty($odstranitProdukt) && !empty($souvisejiciProdukt)) {
			$souvisejiciProdukt = array_diff($souvisejiciProdukt, $odstranitProdukt);
			$souvisejiciProdukt = implode(";", $souvisejiciProdukt);
			$souvisejiciProdukt = trim($souvisejiciProdukt, ";");
		} else {
			$souvisejiciProdukt = implode(";", $souvisejiciProdukt);
			$souvisejiciProdukt = trim($souvisejiciProdukt, ";");
		}
		$sqlCat = "SELECT sub_categories_category FROM products_sub_categories WHERE sub_categories_id=?";
        $stmt = $this->connect()->prepare($sqlCat);
        if ($stmt->execute([$podKategorieProdukt])) {
        	$result = $stmt->fetch();
        	$kategorieProdukt = $result['sub_categories_category'];
        } else {
        	header('Location: ?error=set_product');
        	exit();
        }
		$sql = "UPDATE products SET product_name=?, product_url=?, product_code=?, product_shortDesc=?, product_desc=?, product_image=?, product_category=?, product_sub_category=?, product_visibility=?, product_related=?, product_price=?, product_purchase_price=?, product_discount=?, product_storage=?, product_availibility=?, product_minus_shopping=? WHERE product_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$nazevProduktu, $urlProduktu, $kodProduktu, $kratkyPopis, $podrobnyPopis, $images, $kategorieProdukt, $podKategorieProdukt, $viditelnostProdukt, $souvisejiciProdukt, $cenaProduktu, $nakupniCenaProduktu, $slevaProduktu, $stavSkladuProduktu, $dostupnostProduktu, $minusovyProduktu, $id])) {
			if (empty($param)) {
				header("Location: ?id=" . $id . "&success");
			} else {
				$paramSuccess = false;
				$sqlDel = "DELETE FROM products_params_values WHERE value_product_id=?";
				$stmt = $this->connect()->prepare($sqlDel);

				if ($stmt->execute([$id])) {
					for ($i=0; $i < count($param); $i++) {
						$sqlParams = "INSERT INTO products_params_values(value_param_id, value_value, value_product_id) VALUES (?,?,?)";
						$stmt = $this->connect()->prepare($sqlParams);
						if ($stmt->execute([$param[$i], $paramValue[$i], $id])) {
							$paramSuccess = true;
						} else {
							$paramSuccess = false;
						}
					}
					if ($paramSuccess == true) {
						header("Location: ?id=" . $id . "&success");
					} else {
						header("Location: ?id=" . $id . "&error=set_product3");
					}
				} else {
					header("Location: ?id=" . $id . "&error=set_product2");
				}
			}
		} else {
			header("Location: ?id=" . $id . "&error=set_product1");
		}
	}

	protected function unSetProduct(int $id) {
		$sql = "DELETE FROM products WHERE product_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			$sqlParam = "DELETE FROM products_params_values WHERE value_product_id=?";
			$stmt = $this->connect()->prepare($sqlParam);
			if ($stmt->execute([$id])) {
				header("Location: produkty.php?success");
			} else {
				header("Location: produkty.php?error=delete");
			}
		} else {
			header("Location: produkty.php?error=delete");
		}
	}

	protected function duplicateProduct(int $id) {
		$sql = "INSERT INTO products (product_name, product_desc, product_shortDesc, product_price, product_purchase_price, product_discount, product_category, product_sub_category,product_storage, product_availibility, product_minus_shopping, product_visibility, product_related, product_image) SELECT product_name, product_desc, product_shortDesc, product_price, product_purchase_price, product_discount, product_category, product_sub_category, product_storage, product_availibility, product_minus_shopping, product_visibility, product_related, product_image FROM products WHERE product_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			$sqlNew = "SELECT MAX(product_id) AS maxID FROM products";
			if ($stmt = $this->connect()->query($sqlNew)) {
				$result = $stmt->fetch();
				$maxID = $result['maxID'];
				$sqlParams = "INSERT INTO products_params_values (value_product_id, value_param_id, value_value) SELECT $maxID, value_param_id, value_value FROM products_params_values WHERE value_product_id=?";
				$stmt = $this->connect()->prepare($sqlParams);
				if ($stmt->execute([$id])) {
					header("Location: ?id=" . $maxID . "&success");
				} else {
					header("Location: ?id=" . $id . "&error=set_product");
				}
			} else {
				header("Location: ?id=" . $id . "&error=set_product");
			}
		} else {
			header("Location: ?id=" . $id . "&error=set_product");
		}
	}

	protected function setProductsPrices($ids, $productPrice, $productDiscount, $productPurchasePrice) {
		$updSuccess = false;
		for ($i=0; $i < count($ids); $i++) {
			$sql = "UPDATE products SET product_price=?, product_purchase_price=?, product_discount=? WHERE product_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$productPrice[$i], $productPurchasePrice[$i], $productDiscount[$i], $ids[$i]])) {
				$updSuccess = true;
			}
		}
		if ($updSuccess == true) {
			header("Location: ?success");
		} else {
			header('Location: ?error=set_product');
		}
	}

	protected function setProductsStorage($ids, $productStorage, $minusovyProduktu, $dostupnostProduktu) {
		$updSuccess = false;
		for ($i=0; $i < count($ids); $i++) {
			$sql = "UPDATE products SET product_storage=?, product_availibility=?, product_minus_shopping=? WHERE product_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$productStorage[$i], $dostupnostProduktu[$i], $minusovyProduktu[$i], $ids[$i]])) {
				$updSuccess = true;
			}
		}
		if ($updSuccess == true) {
			header("Location: ?success");
		} else {
			header('Location: ?error=set_product');
		}
	}

	protected function createProduct($nazevProduktu, $urlProduktu, $kodProduktu, $kratkyPopis, $podrobnyPopis, $podKategorieProdukt, $param, $paramValue, $viditelnostProdukt, $cenaProduktu, $nakupniCenaProduktu, $slevaProduktu, $stavSkladuProduktu, $dostupnostProduktu, $minusovyProduktu, $souvisejiciProdukt, $filteredFotografie) {
		if (!empty($_POST['souvisejiciProdukt'])) {
          	$souvisejiciProdukt = $_POST['souvisejiciProdukt'];
          	$filteredProdukt = implode(";", $souvisejiciProdukt);
          	$filteredProdukt = trim($filteredProdukt, ';');  
        } else {
          	$filteredProdukt = "";
        }
        $sqlCat = "SELECT sub_categories_category FROM products_sub_categories WHERE sub_categories_id=?";
        $stmt = $this->connect()->prepare($sqlCat);
        if ($stmt->execute([$podKategorieProdukt])) {
        	$result = $stmt->fetch();
        	$kategorieProdukt = $result['sub_categories_category'];
        } else {
        	header('Location: ?error=set_product');
        	exit();
        }
        $sql = "INSERT INTO products (product_name, product_url, product_code, product_shortDesc, product_desc, product_image, product_category, product_sub_category, product_visibility, product_related, product_price, product_purchase_price, product_discount, product_storage, product_availibility, product_minus_shopping) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        if ($stmt->execute([$nazevProduktu, $urlProduktu, $kodProduktu, $kratkyPopis, $podrobnyPopis, $filteredFotografie, $kategorieProdukt, $podKategorieProdukt, $viditelnostProdukt, $filteredProdukt, $cenaProduktu, $nakupniCenaProduktu, $slevaProduktu, $stavSkladuProduktu, $dostupnostProduktu, $minusovyProduktu])) {
        	$sqlNew = "SELECT MAX(product_id) AS maxID FROM products";
			if ($stmt = $this->connect()->query($sqlNew)) {
				$result = $stmt->fetch();
				$maxId = $result['maxID'];
				$paramSuccess = false;
				for ($i=0; $i < count($param); $i++) {
					$sqlParams = "INSERT INTO products_params_values(value_product_id, value_param_id, value_value) VALUES (?,?,?)";
					$stmt = $this->connect()->prepare($sqlParams);
					if ($stmt->execute([$maxId, $param[$i], $paramValue[$i]])) {
						$paramSuccess = true;
					} else {
						$paramSuccess = false;
					}
				}
				if ($paramSuccess == true) {
					header("Location: ?id=" . $maxId . "&success");
				} else {
					header('Location: ?error=set_product');
				}
			} else {
				header('Location: ?error=set_product');
			}
        } else {
        	header('Location: ?error=set_product');
        }
	}

}