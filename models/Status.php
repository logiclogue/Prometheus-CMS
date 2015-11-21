<?php

session_start();


class Status
{
	private static $all = array();


	private static function encode() {
		$json = json_encode(self::$all);

		echo $json;
	}

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