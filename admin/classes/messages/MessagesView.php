<?php

namespace admin\messages;

class MessagesView extends Messages {

	public function showMessages($ids=NULL) {
		$result = $this->getMessages($ids);
		return $result;
	}

}