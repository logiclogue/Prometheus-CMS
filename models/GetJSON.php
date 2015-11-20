<?php

class GetJSON
{
	public static $name = 'JSON';


	public static function decodeGet() {
		return json_decode($_GET[self::$name], true);
	}

	public static function decodePost() {
		return json_decode($_POST[self::$name], true);
	}

	public static function encodeGet() {
		return $_GET[self::$name];
	}

	public static function encodePost() {
		return $_POST[self::$name];
	}

	public static function isGet() {
		return isset($_GET[self::$name]);
	}

	public static function isPost() {
		return isset($_POST[self::$name]);
	}
}

?>