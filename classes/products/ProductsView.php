<?php

namespace products;

class ProductsView extends Products {

	public function showBestSellingProducts($category=NULL, $subcategory=NULL, $orderBy=NULL) {
		$result = $this->getBestSellingProducts($category, $subcategory, $orderBy);
		return $result;
	}

	public function showProductsDetail($id, $related) {
		$result = $this->getProductsDetail($id, $related);
		return $result;
	}

	public function showProducts($category=NULL, $subcategory=NULL, $sort=NULL) {
		$result = $this->getProducts($category, $subcategory, $sort);
		return $result;
	}

	public function showCategories() {
		$result = $this->getCategories();
		return $result;
	}

	public function showSubCategories() {
		$result = $this->getSubCategories();
		return $result;
	}

	public function showParams($id=NULL) {
		$result = $this->getParams($id);
		return $result;
	}

	public function showParamsValues($id=NULL) {
		$result = $this->getParamsValues($id);
		return $result;
	}

	public function searchProducts($item, $sort=NULL) {
		$result = $this->findProducts($item, $sort);
		return $result;
	}

	public function searchCategories($item) {
		$result = $this->findCategories($item);
		return $result;
	}

	public function showReviews($id) {
		$result = $this->getReviews($id);
		return $result;
	}

}