<?php

require_once(dirname(__DIR__) . '/models/Model.php');
require_once(dirname(__DIR__) . '/functions/Database.php');
require_once(dirname(__DIR__) . '/lib/Parsedown.php');


class GetPost extends Model
{
	private static $query = <<<SQL
		SELECT * FROM posts WHERE
		title = CASE WHEN :title IS NULL THEN title ELSE :title END AND
		id = CASE WHEN :id IS NULL THEN id ELSE :id END
SQL;


	protected static function main() {
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
}

GetPost::init();

?>