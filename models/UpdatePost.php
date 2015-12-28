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

	private static function bindParams() {
		self::bindTitleContent();
		self::$stmt->bindParam(':id', self::$data['id']);
	}

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