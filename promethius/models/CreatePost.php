<?php

require_once(dirname(__DIR__) . '/models/Model.php');
require_once(dirname(__DIR__) . '/models/Database.php');
require_once(dirname(__DIR__) . '/models/GetJSON.php');

session_start();


class CreatePost extends Model
{
	private static $createQuery = 'INSERT INTO posts (id, title, content, date) VALUES (:id, :title, :content, :date) ON DUPLICATE KEY UPDATE title=:title, content=:content, date=:date';


	private static function create() {
		$result = Database::$conn->prepare(self::$createQuery);

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

	protected static function main() {
		if (isset($_SESSION['user']['id'])) {
			self::create();
		}
		else {
			return false;
		}
	}
}

CreatePost::init();

?>