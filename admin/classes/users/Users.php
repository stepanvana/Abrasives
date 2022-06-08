<?php

namespace admin\users;

class Users extends Dbh {

	protected function getUser(int $id) {
		$sql = "SELECT * FROM users WHERE user_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			$result = $stmt->fetch();
			return $result;
		} else {
			header('Location: ?error=get_data');
		}
	}

	protected function getTasks(int $id) {
		$sql = "SELECT * FROM orders WHERE order_employee=? && order_condition=1 ORDER BY order_date ASC";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			$result = $stmt->fetchAll();
			return $result;
		} else {
			header('Location: ?error=get_data');
		}
	}

	protected function setSettings($userName, $userEmail, $userPhone, $oldPassword, $newPassword, $id, $file) {
		if (!empty($_POST['oldPassword']) && !empty($_POST['newPassword'])) {
			$sql = "SELECT * FROM users WHERE user_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$id])) {
				$pwd = $stmt->fetch();
			} else {
				header('Location: ?error=edit_settings');
			}
			$pwdCheck = password_verify($oldPassword, $pwd['user_password']);
			if ($pwdCheck == false) {
				header('Location: ?error=wrong_password');
			} elseif ($pwdCheck == true) {
				$sql = "UPDATE users SET user_password=? WHERE user_id=?";
				$stmt = $this->connect()->prepare($sql);
				$hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
				if ($stmt->execute([$hashed_password, $id])) {
					$sqlUpd = "UPDATE users SET user_name=?, user_email=?, user_phone=?, user_image=? WHERE user_id=?";
					$stmt = $this->connect()->prepare($sqlUpd);
					if ($stmt->execute([$userName, $userEmail, $userPhone, $file, $id])) {
						header("Location: ?success");
					} else {
						header('Location: ?error=edit_settings');
					}
				} else {
					header('Location: ?error=edit_settings');
				}
			}
		} else {
			$sqlUpd = "UPDATE users SET user_name=?, user_email=?, user_phone=?, user_image=? WHERE user_id=?";
			$stmt = $this->connect()->prepare($sqlUpd);
			if ($stmt->execute([$userName, $userEmail, $userPhone, $file, $id])) {
				header("Location: ?success");
			} else {
				header('Location: ?error=edit_settings');
			}
		}
	}

	protected function unSetImage(int $id) {
		$sql = "UPDATE users SET user_image = NULL WHERE user_id=?";
		$stmt = $this->connect()->prepare($sql);
		if ($stmt->execute([$id])) {
			header("Location: ?success");
		} else {
			header('Location: ?error=edit_settings');
		}
	}

}