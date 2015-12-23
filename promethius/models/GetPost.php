<?php

require_once(dirname(__DIR__) . '/models/Model.php');
require_once(dirname(__DIR__) . '/functions/Database.php');
require_once(dirname(__DIR__) . '/lib/Parsedown.php');


class GetPost extends Model
{
	private static $query = <<<SQL
		SELECT *
		FROM posts
		WHERE
		title = CASE WHEN :title IS NULL THEN title ELSE :title END AND
		id = CASE WHEN :id IS NULL THEN id ELSE :id END
SQL;

	private static $query_tags = <<<SQL
		SELECT tags.name
		FROM tags
		INNER JOIN post_tag_maps
		ON post_tag_maps.tag_id = tags.id
		WHERE post_tag_maps.post_id = :id
SQL;

	private static $result;
	private static $result_tags;
	private static $parsedown;


	private static function getTags($id) {
		self::$result_tags = Database::$conn->prepare(self::$query_tags);
		self::$result_tags->bindParam(':id', $id);

		if (self::$result_tags->execute()) {
			return self::$result_tags->fetchAll(PDO::FETCH_COLUMN);
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
		self::$result = self::$result->fetchAll(PDO::FETCH_ASSOC);
			
		foreach (self::$result as &$value) {
			// populate the tags field with the tag names.
			$value['tags'] = self::getTags($value['id']);

			// convert the content to HTML or keep as markdown
			self::processContent($value);
		}
	}

	private static function executeQuery() {
		if (self::$result->execute()) {
			self::querySuccess();

			return self::$result;
		}
		else {
			return false;
		}
	}

	private static function bindParams() {
		self::$result->bindParam(':title', self::$data['title']);
		self::$result->bindParam(':id', self::$data['id']);
	}

	private static function prep() {
		self::$parsedown = new Parsedown();
		self::$result = Database::$conn->prepare(self::$query);
	}


	protected static function main() {
		self::prep();
		self::bindParams();

		return self::executeQuery();
	}
}

GetPost::init();

?>