<?php

require_once(dirname(__DIR__) . '/models/Database.php');
require_once(dirname(__DIR__) . '/models/GetJSON.php');


class GetPost
{
	private static $query = 'SELECT * FROM posts WHERE title=:title';
	private static $title = '';
	private static $is_echo = false;


	private static function main() {
		$result = Database::$conn->prepare(self::$query);

		if ($result->execute(array(':title' => self::$title))) {
			$result = $result->fetchAll(PDO::FETCH_ASSOC)[0];

			return $result;
		}
	}


	public static function call($data) {
		self::$title = $data['title'];
		
		return self::main();
	}

	public static function init() {
		if (GetJSON::isGet()) {
			self::$is_echo = true;
			self::$title = GetJSON::decodeGet()['title'];

			echo self::main();
		}
	}
}

GetPost::init();

?>