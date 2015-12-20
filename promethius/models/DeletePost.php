<?php

require_once(dirname(__DIR__) . '/models/Model.php');
require_once(dirname(__DIR__) . '/functions/Database.php');

session_start();


class DeletePost extends Model
{
	private static $query = 'DELETE FROM posts WHERE id=:id OR title=:title';
	private static $result;


	private static function bindParams() {
		self::$result->bindParam(':id', self::$data['id']);
		self::$result->bindParam(':title', self::$data['title']);
	}

	private static function delete() {
		self::$result = Database::$conn->prepare(self::$query);

		self::bindParams();

		if (self::$result->execute()) {
			return true;
		}
		else {
			return false;
		}
	}

	protected static function main() {
		// check to see if the user is logged in before deleting a post
		if (isset($_SESSION['user']['id'])) {
			return self::delete();
		}
		else {
			return false;
		}
	}
}

DeletePost::init();

?>