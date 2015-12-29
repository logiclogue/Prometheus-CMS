<?php

/**
 * Class used to connect to the database.
 *
 * @class Database
 * @static
 */
class Database
{
	/**
	 * Conn object for making database queries.
	 *
	 * @property conn
	 * @type Object
	 */
	public static $conn;


	/**
	 * Method used to create database when installing into server.
	 *
	 * @method create
	 */
	public static function create() {
		$query = file_get_contents(dirname(__DIR__) . '/database.sql');
		$result = self::$conn->prepare($query);

		if ($result->execute()) {
			echo 'Success';
		}
		else {
			echo 'Failure';
		}
	}

	/**
	 * Method used to initialise @property conn.
	 * Called when file is required.
	 *
	 * @method init
	 */
	public static function init() {
		$string = file_get_contents(dirname(__DIR__) . '/env.json');
		$data = json_decode($string, true);
		$connData = $data['database'];

		self::$conn = new PDO('mysql:host=' . $connData['servername'] . ';dbname=' . $connData['database'], $connData['username'], $connData['password']);
	}
}

Database::init();

?>