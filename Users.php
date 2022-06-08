<?php

namespace users;

class Users extends Dbh {

	protected function setNewMessage($contactForm_name, $contactForm_email, $contactForm_subject, $contactForm_message, $ip_contact) {
		if (empty(trim($contactForm_name)) || empty(trim($contactForm_email)) || empty(trim($contactForm_subject)) || empty(trim($contactForm_message))) {
			header('Location: '.$_SERVER['PHP_SELF'].'?error_message=wrong_input#message');
		} elseif (!filter_var($contactForm_email, FILTER_VALIDATE_EMAIL)) {
			header('Location: '.$_SERVER['PHP_SELF'].'?error_message=wrong_input#message');
		} elseif (!preg_match('/^[a-z0-9 .\-]+$/i', $contactForm_name)) {
			header('Location: '.$_SERVER['PHP_SELF'].'?error_message=wrong_input#message');
		} elseif (!preg_match('/^[a-z0-9 .\-]+$/i', $contactForm_subject)) {
			header('Location: '.$_SERVER['PHP_SELF'].'?error_message=wrong_input#message');
		} else {
			$sqlContactForm = "INSERT INTO contact_form (contact_name, contact_email, contact_subject, contact_message, contact_ip) VALUES (?,?,?,?,?)";
			$stmt = $this->connect()->prepare($sqlContactForm);
			if ($stmt->execute([$contactForm_name, $contactForm_email, $contactForm_subject, $contactForm_message, $ip_contact])) {
				header('Location: '.$_SERVER['PHP_SELF'].'?success_message#message');
			} else {
				header('Location: '.$_SERVER['PHP_SELF'].'?error_message#message');
			}
		}
	}

	protected function setNewSub($email_sub, $ip_sub) {
		if (!filter_var($email_sub, FILTER_VALIDATE_EMAIL)) {
			return false;
		} else {
			$sql = "SELECT * FROM email_subscription WHERE nl_email=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$email_sub])) {
				$result = $stmt->fetchAll();
				if (count($result)==0) {
					$sqlEmailNewsletter = "INSERT INTO email_subscription (nl_email, nl_ip) VALUES (?,?)";
					$stmt = $this->connect()->prepare($sqlEmailNewsletter);
					if ($stmt->execute([$email_sub, $ip_sub])) {
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			}
		}
	}

	protected function authUser($uname, $upassword) {
		if (empty(trim($uname)) || empty(trim($upassword))) {
			return false;
		} elseif (!ctype_alnum($uname) || !ctype_alnum($upassword)) {
			return false;
		} else {
			$sql = "SELECT * FROM users WHERE user_name=?;";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$uname])) {
				$result = $stmt->fetch();
				if ($stmt->rowCount() > 0) {
					if (password_verify($upassword, $result['user_password'])) {
						session_start();
						$_SESSION['userId'] = $result['user_id'];
						$_SESSION['userUid'] = $result['user_name'];
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}

	protected function checkUser() {
		if (isset($_SESSION['userId'])) {
			return $_SESSION['userId'];
		} else {
			return false;
		}
	}

	protected function unAuthUser() {
		session_destroy();
		unset($_SESSION['userId']);
		unset($_SESSION['userUid']);
		return true;
	}

}