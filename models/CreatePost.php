<?php

require_once(dirname(__DIR__) . '/models/Post.php');

session_start();


/**
 * Model for creating a post.
 *
 * @class CreatePost
 * @extends Post
 * @static
 */
class CreatePost extends Post
{
	/**
	 * SQL query string for inserting a new post.
	 * Based on title, content, and date.
	 *
	 * @property query
	 * @type String
	 */
	private static $query = <<<SQL
		INSERT INTO posts (title, content, date)
		VALUES (:title, :content, :date)
SQL;


	/**
	 * Method for binding parameters to @property query
	 * Calls parent @method bindTitleContent, which binds common data.
	 * In addition, this binds date.
	 *
	 * @method bindParams
	 */
	private static function bindParams() {
		self::bindTitleContent();
		self::$stmt->bindParam(':date', self::$data['date']);
	}

	/**
	 * General method for creating the post.
	 * Populates @property stmt and executes.
	 *
	 * @method create
	 * @return {Boolean} Success of post creation.
	 */
	private static function create() {
		self::$stmt = Database::$conn->prepare(self::$query);

		self::bindParams();

		if (self::$stmt->execute()) {
			return self::createTags(Database::$conn->lastInsertId());
		}
		else {
			return false;
		}
	}

	/**
	 * Checks to see if user is logged in.
	 *
	 * @method main
	 * @return {Boolean} Success of post creation and whether user is logged in.
	 */
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