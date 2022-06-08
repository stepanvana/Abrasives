<?php

namespace users;

class UsersView extends Users {

	public function isUserLogged() {
		$isLogged = $this->checkUser();
		return $isLogged;
	}

	public function loginUser($uname, $upassword) {
		$result = $this->authUser($uname, $upassword);
		return $result;
	}

	public function logOutUser() {
		$result = $this->unAuthUser();
		return $result;
	}

}