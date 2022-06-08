<?php

namespace admin\products;

class ProductsView extends Products {

	public function showProducts($ids=NULL) {
		$result = $this->getProducts($ids);
		return $result;
	}

	public function showCategories() {
		$result = $this->getCategories();
		return $result;
	}

	public function showSubCat($id=NULL) {
		$result = $this->getSubCat($id);
		return $result;
	}

	public function showParams($id=NULL) {
		$result = $this->getParams($id);
		return $result;
	}

	public function showParamsValues() {
		$result = $this->getParamsValues();
		return $result;
	}

	public function showProduct(int $id) {
		$result = $this->getProduct($id);
		return $result;
	}

}