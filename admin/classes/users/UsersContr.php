<?php

namespace admin\users;

class UsersContr extends Users {

	public function saveSettings($userName, $userEmail, $userPhone, $oldPassword, $newPassword, $id, $file) {
		$this->setSettings($userName, $userEmail, $userPhone, $oldPassword, $newPassword, $id, $file);
	}

	public function deleteImage(int $id) {
		$this->unSetImage($id);
	}

}