<?php

require_once(dirname(__DIR__) . '/models/Model.php');
require_once(dirname(__DIR__) . '/functions/Database.php');
require_once(dirname(__DIR__) . '/lib/Parsedown.php');


class GetPost extends Model
{
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

	private static $query_tags = <<<SQL
		SELECT tags.name
		FROM tags
		INNER JOIN post_tag_maps
		ON post_tag_maps.tag_id = tags.id
		WHERE post_tag_maps.post_id = :id
SQL;

	private static $stmt;
	private static $stmt_tags;
	private static $parsedown;


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

	private static function processContent(&$value) {
		if (self::$data['format'] == 'HTML' && isset($value['content'])) {
			$value['content'] = self::$parsedown->text($value['content']);
		}
	}

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

	private static function executeQuery() {
		if (self::$stmt->execute()) {
			return self::querySuccess();
		}
		else {
			return false;
		}
	}

	private static function bindParams() {
		self::$stmt->bindParam(':title', self::$data['title']);
		self::$stmt->bindParam(':id', self::$data['id']);
		self::$stmt->bindParam(':tag', self::$data['tag']);
	}

	private static function prep() {
		self::$parsedown = new Parsedown();
		self::$stmt = Database::$conn->prepare(self::$query);
	}


	protected static function main() {
		self::prep();
		self::bindParams();

		return self::executeQuery();
	}
}

GetPost::init();

?>