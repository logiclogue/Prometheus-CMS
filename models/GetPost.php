<?php

require_once(dirname(__DIR__) . '/models/Database.php');
require_once(dirname(__DIR__) . '/models/GetJSON.php');


class GetPost
{
	private static $query = 'SELECT * FROM posts WHERE title=:title';
	private static $title = '';


	private static function main() {
		$result = Database::$conn->prepare(self::$query);

		if ($result->execute(array(':title' => self::$title))) {
			$result = $result->fetchAll(PDO::FETCH_ASSOC)[0];

			echo json_encode($result);
		}
		else {
			echo 'false';
		}
	}


	public static function call($data) {
		self::$title = $data['title'];
		self::main();
	}

	public static function init() {
		if (GetJSON::isGet()) {
			self::$title = GetJSON::decodeGet()['title'];
			self::main();
		}
	}
}

GetPost::init();

?>