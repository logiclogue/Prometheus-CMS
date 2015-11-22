<?php

require_once(dirname(__DIR__) . '/models/Database.php');
require_once(dirname(__DIR__) . '/models/GetJSON.php');

session_start();


class CreatePost
{
	private static $query = 'INSERT INTO posts (id, title, content, date) VALUES (:id, :title, :content, :date) ON DUPLICATE KEY UPDATE title=:title, content=:content, date=:date';
	private static $data = array();


	private static function main() {
		if (isset($_SESSION['user']['id'])) {
			$result = Database::$conn->prepare(self::$query);

			$result->bindParam(':id', self::$data['id']);
			$result->bindParam(':title', self::$data['title']);
			$result->bindParam(':content', self::$data['content']);
			$result->bindParam(':date', self::$data['date']);

			if ($result->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}


	public static function call($data) {
		self::$data = $data;

		return self::main();
	}

	public static function init() {
		if (GetJSON::isGet()) {
			self::$data = GetJSON::decodeGet();

			echo json_encode(self::main());
		}
	}
}

CreatePost::init();

?>