<?php

session_start();


/**
 * Model for getting the status of the user.
 *
 * @class Status
 */
class Status
{
	/**
	 * Array for storing the user data to be returned.
	 *
	 * @property all
	 * @type Array
	 */
	private static $all = array();


	/**
	 * Method for encoding the data as JSON.
	 * Also echos that encoded data.
	 *
	 * @method encode
	 */
	private static function encode() {
		$json = json_encode(self::$all);

		echo $json;
	}

	/**
	 * Fetches user data if logged in.
	 * Then calls @method encode.
	 *
	 * @method init.
	 */
	public static function init() {
		if (isset($_SESSION['user'])) {
			self::$all['user'] = $_SESSION['user'];
		}
		else {
			self::$all['user'] = array();
		}

		self::$all['logged_in'] = isset($_SESSION['user']['id']);
	
		self::encode();
	}
}

Status::init();

?>