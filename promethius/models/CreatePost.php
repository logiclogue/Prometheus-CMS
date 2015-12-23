<?php

require_once(dirname(__DIR__) . '/models/Post.php');

session_start();


class CreatePost extends Post
{
	private static $query = <<<SQL
		INSERT INTO posts (title, content, date) VALUES (:title, :content, :date)
SQL;

	private static $result;


	private static function createTags() {
		$lastId = Database::$conn->lastInsertId();

		foreach (self::$data['tags'] as &$tag) {
			$tag = strtolower($tag);

			$result_create_tag = Database::$conn->prepare(self::$query_create_tag);
			$result_join_tag = Database::$conn->prepare(self::$query_join_tag);

			$result_create_tag->bindParam(':name', $tag);
			$result_join_tag->bindParam(':name', $tag);
			$result_join_tag->bindParam(':id', $lastId);

			if (!$result_create_tag->execute() || !$result_join_tag->execute()) {
				return false;
			}
		}

		return true;
	}

	private static function bindParams() {
		self::$result->bindParam(':title', self::$data['title']);
		self::$result->bindParam(':content', self::$data['content']);
		self::$result->bindParam(':date', self::$data['date']);
	}

	private static function create() {
		self::$result = Database::$conn->prepare(self::$query);

		self::bindParams();

		if (self::$result->execute()) {
			return self::createTags();
		}
		else {
			return false;
		}
	}

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