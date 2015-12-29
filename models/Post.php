<?php

require_once(dirname(__DIR__) . '/models/Model.php');
require_once(dirname(__DIR__) . '/functions/Database.php');

session_start();


/**
 * Parent model for creating and altering posts.
 *
 * @class Post
 * @extends Model
 * @static
 */
class Post extends Model
{
	/**
	 * SQL query string for inserting new tag if it doesn't already exist.
	 *
	 * @property query_create_tag
	 * @type String
	 * @protected
	 */
	protected static $query_create_tag = <<<SQL
		INSERT INTO tags (name)
		SELECT * FROM (SELECT :name) AS tag_name
		WHERE NOT EXISTS (
			SELECT name FROM tags WHERE name = :name
		) LIMIT 1
SQL;

	/**
	 * SQL query string for creating a link between a post and a tag.
	 *
	 * @property query_join_tag
	 * @type String
	 * @protected
	 */
	protected static $query_join_tag = <<<SQL
		INSERT INTO post_tag_maps (post_id, tag_id)
		VALUES (:id, (SELECT id FROM tags WHERE name=:name))
SQL;

	/**
	 * Database statement for creating a post.
	 *
	 * @property stmt
	 * @type Object
	 * @protected
	 */
	protected static $stmt;


	/**
	 * Method for creating tags and joining to post.
	 *
	 * @method createTags
	 * @protected
	 * @return {Boolean} Whether success of creating tags.
	 */
	protected static function createTags($post_id) {
		foreach (self::$data['tags'] as &$tag) {
			$tag = strtolower($tag);

			$stmt_create_tag = Database::$conn->prepare(self::$query_create_tag);
			$stmt_join_tag = Database::$conn->prepare(self::$query_join_tag);

			$stmt_create_tag->bindParam(':name', $tag);
			$stmt_join_tag->bindParam(':name', $tag);
			$stmt_join_tag->bindParam(':id', $post_id);

			if (!$stmt_create_tag->execute() || !$stmt_join_tag->execute()) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Method for binding data to @property stmt.
	 *
	 * @method bindTitleContent
	 * @protected
	 */
	protected static function bindTitleContent() {
		self::$stmt->bindParam(':title', self::$data['title']);
		self::$stmt->bindParam(':content', self::$data['content']);
	}
}

?>