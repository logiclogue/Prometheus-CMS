<?php

require_once(dirname(__DIR__) . '/models/Model.php');
require_once(dirname(__DIR__) . '/functions/Database.php');
require_once(dirname(__DIR__) . '/lib/Parsedown.php');


/**
 * Class for fetching a post.
 * Fetches post based on id, title, or tag.
 * Can return post content as HTML or raw markdown.
 *
 * @class GetPost
 * @extends Model
 * @static
 */
class GetPost extends Model
{
	/**
	 * SQL query string for fetching the post.
	 *
	 * @property query
	 * @type String
	 */
	private static $query = <<<SQL
		SELECT posts.*
		FROM posts
		LEFT JOIN post_tag_maps
		ON post_tag_maps.post_id = posts.id
		LEFT JOIN tags
		ON post_tag_maps.tag_id = tags.id
		WHERE
		posts.title = CASE WHEN :title IS NULL THEN posts.title ELSE :title END AND
		posts.id = CASE WHEN :id IS NULL THEN posts.id ELSE :id END AND
		CASE WHEN :tag IS NULL
		THEN posts.id = posts.id
		ELSE tags.name = :tag
		END
		GROUP BY posts.id
SQL;

	/**
	 * SQL query string for finding tags from the post id.
	 *
	 * @property query_tags
	 * @type String
	 */
	private static $query_tags = <<<SQL
		SELECT tags.name
		FROM tags
		INNER JOIN post_tag_maps
		ON post_tag_maps.tag_id = tags.id
		WHERE post_tag_maps.post_id = :id
SQL;

	/**
	 * Database statement for executing @property query.
	 *
	 * @property stmt
	 * @type Object
	 */
	private static $stmt;
	/**
	 * Database statement for executing @property query_tags
	 *
	 * @property stmt_tags
	 * @type Object
	 */
	private static $stmt_tags;
	/**
	 * Object for using the Parsedown library.
	 * Used to convert raw markdown to HTML.
	 *
	 * @property parsedown
	 * @type Object
	 */
	private static $parsedown;


	/**
	 * Method for finding tags based on the post id.
	 *
	 * @method getTags
	 * @return {Array} List of tags.
	 */
	private static function getTags($id) {
		self::$stmt_tags = Database::$conn->prepare(self::$query_tags);
		self::$stmt_tags->bindParam(':id', $id);

		if (self::$stmt_tags->execute()) {
			return self::$stmt_tags->fetchAll(PDO::FETCH_COLUMN);
		}
		else {
			return false;
		}
	}

	/**
	 * Method for converting content to HTML if requested.
	 *
	 * @method processContent
	 */
	private static function processContent(&$value) {
		if (self::$data['format'] == 'HTML' && isset($value['content'])) {
			$value['content'] = self::$parsedown->text($value['content']);
		}
	}

	/**
	 * Method for fetching result from @property stmt.
	 * Loops over all fetched posts to add tags and process content.
	 *
	 * @method querySuccess
	 * @return {Object} $result.
	 */
	private static function querySuccess() {
		$result = self::$stmt->fetchAll(PDO::FETCH_ASSOC);
			
		foreach ($result as &$value) {
			// populate the tags field with an array of the tag names.
			$value['tags'] = self::getTags($value['id']);

			// convert the content to HTML or keep as markdown
			self::processContent($value);
		}

		return $result;
	}

	/**
	 * Method for executing @property stmt.
	 * On success calls @method querySuccess.
	 *
	 * @method executeQuery
	 * @return {Object} On success of executing query.
	 */
	private static function executeQuery() {
		if (self::$stmt->execute()) {
			return self::querySuccess();
		}
		else {
			return false;
		}
	}

	/**
	 * Binds data to @property query.
	 *
	 * @method bindParams
	 */
	private static function bindParams() {
		self::$stmt->bindParam(':title', self::$data['title']);
		self::$stmt->bindParam(':id', self::$data['id']);
		self::$stmt->bindParam(':tag', self::$data['tag']);
	}

	/**
	 * Prepares @property parsedown and @property stmt.
	 *
	 * @method prep
	 */
	private static function prep() {
		self::$parsedown = new Parsedown();
		self::$stmt = Database::$conn->prepare(self::$query);
	}


	/**
	 * Calls methods for executing database statement.
	 *
	 * @method main
	 * @return {Object} Result of @property query.
	 */
	protected static function main() {
		self::prep();
		self::bindParams();

		return self::executeQuery();
	}
}

GetPost::init();

?>