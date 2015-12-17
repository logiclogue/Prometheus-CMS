<?php

class GetJSON
{
	public static $name = 'JSON';


	public static function decodeGet() {
		if (isset($_GET[self::$name])) {
			return json_decode($_GET[self::$name], true);
		}
	}

	public static function decodePost() {
		if (isset($_POST[self::$name])) {
			return json_decode($_POST[self::$name], true);
		}
	}

	public static function encodeGet() {
		if (isset($_GET[self::$name])) {
			return $_GET[self::$name];
		}
	}

	public static function encodePost() {
		if (isset($_POST[self::$name])) {
			return $_POST[self::$name];
		}
	}

	public static function isGet() {
		return isset($_GET[self::$name]);
	}

	public static function isPost() {
		return isset($_POST[self::$name]);
	}
}

?>