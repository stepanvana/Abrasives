<?php

namespace products;

class Cart {

	public function addToCart($id, $name, $price, $costs, $discount, $quantity, $url, $image, $category) {
		if(isset($_SESSION['shopping_cart'])) {
			$count = count($_SESSION['shopping_cart']);
			$product_ids = array_column($_SESSION['shopping_cart'], 'id');

			if(!in_array($id, $product_ids)) {
				$_SESSION['shopping_cart'][$count] = array(
					'id' => $id,
					'name' => $name,
					'price' => $price,
					'costs' => $costs,
					'discount' => $discount,
					'quantity' => $quantity,
					'url' => $url,
					'image' => $image,
					'category' => $category
				);
			} else {
				for ($i = 0; $i < count($product_ids); $i++) {
					if ($product_ids[$i] == $id) {
						$_SESSION['shopping_cart'][$i]['quantity'] += $quantity;
					}
				}
			}
		} else {
			$_SESSION['shopping_cart'][0] = array(
				'id' => $id,
				'name' => $name,
				'price' => $price,
				'costs' => $costs,
				'discount' => $discount,
				'quantity' => $quantity,
				'url' => $url,
				'image' => $image,
				'category' => $category
			);
		}
		return true;
	}

	public function setCartAmount(int $id, int $quantity) {
		if(isset($_SESSION['shopping_cart'])) {
		    $product_ids = array_column($_SESSION['shopping_cart'], 'id');
		    if(in_array($id, $product_ids)) {
		      	for ($i = 0; $i < count($product_ids); $i++) {
		        	if ($product_ids[$i] == $id) {
		          		$_SESSION['shopping_cart'][$i]['quantity'] = $quantity;
		        	}
		      	}
		    }
		}
	}

	public function deleteFromCart(int $id) {
		foreach ($_SESSION['shopping_cart'] as $key => $product) {
	    	if ($product['id'] == $id) {
	      		unset($_SESSION['shopping_cart'][$key]);
	    	}
	  	}
	  	$_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
	}

}