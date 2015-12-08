<?php

require_once(dirname(__DIR__) . '/models/Model.php');
require_once(dirname(__DIR__) . '/models/Database.php');
require_once(dirname(__DIR__) . '/lib/Parsedown.php');


class GetPost
{
	private static $query = <<<SQL
		SELECT * FROM posts WHERE
		title = CASE WHEN :title IS NULL THEN title ELSE :title END AND
		id = CASE WHEN :id IS NULL THEN id ELSE :id END
SQL;
	private static $data = array();


	private static function main() {
		$parsedown = new Parsedown();
		$result = Database::$conn->prepare(self::$query);

		$result->bindParam(':title', self::$data['title']);
		$result->bindParam(':id', self::$data['id']);

		if ($result->execute()) {
			$result = $result->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($result as &$value) {
				if (self::$data['format'] == 'HTML') {
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
		self::$data = $data;
		
		return self::main();
	}

	public static function init() {
		if (GetJSON::isPost()) {
			self::$data = GetJSON::decodePost();
			
			echo json_encode(self::main());
		}
	}
}

GetPost::init();

?>