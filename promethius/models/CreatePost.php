<?php

require_once(dirname(__DIR__) . '/models/Model.php');
require_once(dirname(__DIR__) . '/models/Database.php');

session_start();


class CreatePost extends Model
{
	private static $query = 'INSERT INTO posts (title, content, date) VALUES (:title, :content, :date)';


	private static function create() {
		$result = Database::$conn->prepare(self::$query);

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
		// check to see if user is logged in before creating post
		if (isset($_SESSION['user']['id'])) {
			return self::create();
		}
		else {
			return false;
		}
	}
}

CreatePost::init();

?>