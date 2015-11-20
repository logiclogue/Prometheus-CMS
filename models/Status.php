<?php

class Status
{
	private static $status = array();
	private static $user = array();


	private static function encode() {
		$all = array();
		$json = '';

		$all['status'] = self::$status;
		$all['user'] = self::$user;

		$json = json_encode($all);

		echo $json;
	}

	public static function init() {
		session_start();

		if (isset($_SESSION['username'])) {
			self::$user['username'] = $_SESSION['username'];
		}

		self::$status['logged_in'] = isset($_SESSION['username']);
	
		self::encode();
	}
}

Status::init();

?>