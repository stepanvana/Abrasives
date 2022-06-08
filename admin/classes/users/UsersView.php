<?php

namespace admin\users;

class UsersView extends Users {

	public function showUser(int $id) {
		$result = $this->getUser($id);
		return $result;
	}

	public function showTasks(int $id) {
		$result = $this->getTasks($id);
		return $result;
	}

}