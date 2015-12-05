<?php

require_once(dirname(__DIR__) . '/models/Database.php');
require_once(dirname(__DIR__) . '/models/GetJSON.php');
require_once(dirname(__DIR__) . '/lib/Parsedown.php');


class GetPost
{
	private static $query = 'SELECT * FROM posts WHERE title = CASE WHEN :title IS NULL THEN title ELSE :title END';
	private static $title = '';
	private static $params = array();


	private static function main() {
		$parsedown = new Parsedown();
		$result = Database::$conn->prepare(self::$query);

		$result->bindParam(':title', self::$title);

		if ($result->execute()) {
			$result = $result->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($result as &$value) {
				if (self::$params['format'] == 'HTML') {
					$value['content'] = $parsedown->text($value['content']);
				}
			}

			return $result;
		}
		else {
			return false;
		}
	}


	public static function call($data) {
		self::$params = $data;
		self::$title = $data['title'];
		
		return self::main();
	}

	public static function init() {
		if (GetJSON::isPost()) {
			self::$params = GetJSON::decodePost();
			self::$title = self::$params['title'];
			
			echo json_encode(self::main());
		}
	}
}

GetPost::init();

?>