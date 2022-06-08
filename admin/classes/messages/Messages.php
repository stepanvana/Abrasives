<?php

namespace admin\messages;

class Messages extends Dbh {

	protected function getMessages($ids=NULL) {
		if (!is_null($ids)) {
			$sql = "SELECT * FROM contact_form WHERE contact_id IN (";
			$params = array();
			foreach ($ids as $val) {
				$params[] = '?';
				$binds[] = $val;
			}
			$stmt = $this->connect()->prepare($sql . join(', ', $params) . ')');
			$i = 0;
			foreach ($binds as $bind) {
				$stmt->bindValue(++$i, $bind);
			}
			if ($stmt->execute()) {
				$result = $stmt->fetchAll();
				return $result;
			} else {
				header('Location: ?error=get_data');
			}	
		} else {
			$sql = "SELECT * FROM contact_form";
			if ($stmt = $this->connect()->query($sql)) {
				$result = $stmt->fetchAll();
				return $result;
			} else {
				header('Location: ?error=get_data');
			}
		}
		
	}

	protected function setMessages($ids, $condition) {
		$saveSuccess = false;
		for ($i=0; $i < count($ids); $i++) { 
			$sql = "UPDATE contact_form SET contact_condition=? WHERE contact_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$condition[$i], $ids[$i]])) {
				$saveSuccess = true;
			}
		}
		if ($saveSuccess == true) {
			header("Location: ?success");
		} else {
			header('Location: ?error=messages_edit');
		}
	}

	protected function unSetMessages($ids) {
		$deleteSuccess = false;
		for ($i=0; $i < count($ids); $i++) { 
			$sql = "DELETE FROM contact_form WHERE contact_id=?";
			$stmt = $this->connect()->prepare($sql);
			if ($stmt->execute([$ids[$i]])) {
				$deleteSuccess = true;
			}
		}
		if ($deleteSuccess == true) {
			header("Location: ?success");
		} else {
			header('Location: ?error=messages_edit');
		}
	}

}