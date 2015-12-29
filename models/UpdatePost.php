<?php

require_once(dirname(__DIR__) . '/models/Post.php');

session_start();


/**
 * Model for updating post's content, title, etc.
 *
 * @class UpdatePost.
 * @extends Post
 * @static
 */
class UpdatePost extends Post
{
	/**
	 * SQL query string for updating a post.
	 * Updates title and content.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private static $query = <<<SQL
		UPDATE posts
		SET title=:title, content=:content
		WHERE id=:id
SQL;

	/**
	 * SQL query string for deleting the links to tags.
	 *
	 * @property query_delete_tags
	 * @type String
	 * @private
	 */
	private static $query_delete_tags = <<<SQL
		DELETE post_tag_maps.*
		FROM post_tag_maps
		INNER JOIN tags
		ON post_tag_maps.tag_id = tags.id
		WHERE post_tag_maps.post_id = :id
SQL;


	/**
	 * Method for deleting all tags associated with the post.
	 *
	 * @method deleteTags
	 * @private
	 * @return {Boolean} Whether tags creation and deletion was successful.
	 */
	private static function deleteTags() {
		$stmt_delete_tags = Database::$conn->prepare(self::$query_delete_tags);

		$stmt_delete_tags->bindParam(':id', self::$data['id']);

		if ($stmt_delete_tags->execute()) {
			return self::createTags(self::$data['id']);
		}
		else {
			return false;
		}
	}

	/**
	 * Method for binding parameters to @property stmt
	 *
	 * @method bindParams
	 * @private
	 */
	private static function bindParams() {
		self::bindTitleContent();
		self::$stmt->bindParam(':id', self::$data['id']);
	}

	/**
	 * Method for preparing @property stmt.
	 * Also executes it.
	 *
	 * @method update
	 * @private
	 * @return {Boolean} Whether successfully updated post.
	 */
	private static function update() {
		self::$stmt = Database::$conn->prepare(self::$query);

		self::bindParams();

		if (self::$stmt->execute()) {
			return self::deleteTags();
		}
		else {
			return false;
		}
	}

	/**
	 * Checks whether user is logged in.
	 * Then calls @method update.
	 *
	 * @method main
	 * @protected
	 * @return {Boolean} Whether successfully updated post and logged in.
	 */
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