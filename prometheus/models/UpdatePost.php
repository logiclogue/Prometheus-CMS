<?php

require_once(dirname(__DIR__) . '/models/Post.php');

session_start();


class UpdatePost extends Post
{
	private static $query = <<<SQL
		UPDATE posts
		SET title=:title, content=:content
		WHERE id=:id
SQL;

	private static $query_delete_tags = <<<SQL
		DELETE post_tag_maps.*
		FROM post_tag_maps
		INNER JOIN tags
		ON post_tag_maps.tag_id = tags.id
		WHERE post_tag_maps.post_id = :id
SQL;

	private static $result;


	private static function createTags() {
		foreach (self::$data['tags'] as &$tag) {
			$tag = strtolower($tag);

			$result_create_tag = Database::$conn->prepare(self::$query_create_tag);
			$result_join_tag = Database::$conn->prepare(self::$query_join_tag);

			$result_create_tag->bindParam(':name', $tag);
			$result_join_tag->bindParam(':name', $tag);
			$result_join_tag->bindParam(':id', self::$data['id']);

			if (!$result_create_tag->execute() || !$result_join_tag->execute()) {
				return false;
			}
		}

		return true;
	}

	private static function deleteTags() {
		$result_delete_tags = Database::$conn->prepare(self::$query_delete_tags);

		$result_delete_tags->bindParam(':id', self::$data['id']);

		if ($result_delete_tags->execute()) {
			return self::createTags();
		}
		else {
			return false;
		}
	}

	private static function bindParams() {
		self::$result->bindParam(':id', self::$data['id']);
		self::$result->bindParam(':title', self::$data['title']);
		self::$result->bindParam(':content', self::$data['content']);
	}

	private static function update() {
		self::$result = Database::$conn->prepare(self::$query);

		self::bindParams();

		if (self::$result->execute()) {
			return self::deleteTags();
		}
		else {
			return false;
		}
	}

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