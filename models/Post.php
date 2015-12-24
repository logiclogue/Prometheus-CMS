<?php

require_once(dirname(__DIR__) . '/models/Model.php');
require_once(dirname(__DIR__) . '/functions/Database.php');

session_start();


class Post extends Model
{
	protected static $query_create_tag = <<<SQL
		INSERT INTO tags (name)
		SELECT * FROM (SELECT :name) AS tag_name
		WHERE NOT EXISTS (
			SELECT name FROM tags WHERE name = :name
		) LIMIT 1
SQL;

	protected static $query_join_tag = <<<SQL
		INSERT INTO post_tag_maps (post_id, tag_id)
		VALUES (:id, (SELECT id FROM tags WHERE name=:name))
SQL;

	protected static $result;


	protected static function createTags($post_id) {
		foreach (self::$data['tags'] as &$tag) {
			$tag = strtolower($tag);

			$result_create_tag = Database::$conn->prepare(self::$query_create_tag);
			$result_join_tag = Database::$conn->prepare(self::$query_join_tag);

			$result_create_tag->bindParam(':name', $tag);
			$result_join_tag->bindParam(':name', $tag);
			$result_join_tag->bindParam(':id', $post_id);

			if (!$result_create_tag->execute() || !$result_join_tag->execute()) {
				return false;
			}
		}

		return true;
	}

	protected static function bindTitleContent() {
		self::$result->bindParam(':title', self::$data['title']);
		self::$result->bindParam(':content', self::$data['content']);
	}
}

?>