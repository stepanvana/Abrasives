<?php

namespace admin\messages;

class MessagesContr extends Messages {

	public function saveMessages($post) {
		$this->setMessages($post['ids'], $post['contactCondition']);
	}

	public function deleteMessages($post) {
		$this->unSetMessages($post['checkbox']);
	}

}