<?php

class Database
{
	public static $conn;


	public static function init() {
		$string = file_get_contents('../env.json');
		$data = json_decode($string, true);
		$connData = $data['database'];

		self::$conn = new PDO('mysql:host=' . $connData['servername'] . ';dbname=' . $connData['database'], $connData['username'], $connData['password']);
	}
}

Database::init();

?>