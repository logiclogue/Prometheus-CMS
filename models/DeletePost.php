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
	 * @private
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
	 * The database statement.
	 * For executing @property query.
	 *
	 * @property stmt
	 * @type Object
	 * @private
	 */
	private static $stmt;


	/**
	 * Method for binding data to @property query
	 *
	 * @method bindParams
	 * @private
	 */
	private static function bindParams() {
		self::$stmt->bindParam(':id', self::$data['id']);
		self::$stmt->bindParam(':title', self::$data['title']);
	}

	/**
	 * Method for preparing the statement.
	 * Also executes the statement.
	 *
	 * @method delete
	 * @private
	 * @return {Boolean} Whether deleted post successfully.
	 */
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

	/**
	 * Checks whether user is logged in.
	 * Calls @method delete.
	 *
	 * @method main
	 * @protected
	 * @return {Boolean} Whether successful and logged in.
	 */
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