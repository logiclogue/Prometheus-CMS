<?php

require_once(dirname(__DIR__) . '/models/Model.php');
require_once(dirname(__DIR__) . '/models/Database.php');

session_start();


class DeletePost extends Model
{
	private static $query = 'DELETE FROM posts WHERE id=:id OR title=:title';


	private static function delete() {
		$result = Database::$conn->prepare(self::$query);

		$result->bindParam(':id', self::$data['id']);
		$result->bindParam(':title', self::$data['title']);

		if ($result->execute()) {
			return true;
		}
		else {
			return false;
		}
	}

	protected static function main() {
		// check to see if the user is logged in before deleting a post
		if (isset($_SESSION['user']['id'])) {
			self::delete();
		}
		else {
			return false;
		}
	}
}

?>