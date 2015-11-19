<?php

class GetJSON
{
	public static $name = 'JSON';


	public static function decodeGet() {
		return json_decode($_GET[$name], true);
	}

	public static function decodePost() {
		return json_decode($_POST[$name], true);
	}

	public static function encodeGet() {
		return $_GET[$name];
	}

	public static function decodePost() {
		return $_POST[$name];
	}
}

?>