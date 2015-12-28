<?php

require_once(dirname(__DIR__) . '/models/Model.php');
require_once(dirname(__DIR__) . '/functions/Database.php');

session_start();


/**
 * This model deletes a post.
 *
 * @class DeletePost
 * @extends Model
 * @static
 */
class DeletePost extends Model
{
	/**
	 * SQL query string for deleting a post from the database.
	 *
	 * @property query
	 * @type String
	 */
	private static $query = <<<SQL
		DELETE posts.*, post_tag_maps.*
		FROM posts
		LEFT JOIN post_tag_maps
		ON post_tag_maps.post_id = posts.id
		WHERE
		posts.id=:id OR
		posts.title=:title
SQL;

	/**
	 * The result
	 *
	 *
	 */
	private static $stmt;


	private static function bindParams() {
		self::$stmt->bindParam(':id', self::$data['id']);
		self::$stmt->bindParam(':title', self::$data['title']);
	}

	private static function delete() {
		self::$stmt = Database::$conn->prepare(self::$query);

		self::bindParams();

		if (self::$stmt->execute()) {
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