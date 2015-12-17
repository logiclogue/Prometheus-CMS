<?php

require_once(dirname(__DIR__) . '/models/Model.php');
require_once(dirname(__DIR__) . '/functions/Database.php');

session_start();


class UpdatePost extends Model
{
	private static $query = <<<SQL
		UPDATE posts
		SET title=:title, content=:content
		WHERE id=:id
SQL;


	private static function update() {
		$result = Database::$conn->prepare(self::$query);

		$result->bindParam(':id', self::$data['id']);
		$result->bindParam(':title', self::$data['title']);
		$result->bindParam(':content', self::$data['content']);

		if ($result->execute()) {
			return true;
		}
		else {
			return false;
		}
	}

	protected static function main() {
		// check to see if user is logged in before updating post
		if (isset($_SESSION['user']['id'])) {
			return self::update();
		}
		else {
			return false;
		}
	}
}

UpdatePost::init();

?>