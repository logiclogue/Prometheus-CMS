<?php

/**
 * Utility class for fetching JSON from POST or GET.
 * Also decodes JSON to PHP array.
 *
 * @class GetJSON
 * @static
 */
class GetJSON
{
	/**
	 * Name of the property in POST or GET where JSON has been passed.
	 *
	 * @property name
	 * @type String
	 */
	public static $name = 'JSON';


	/**
	 * Method for returning decoded JSON from GET.
	 *
	 * @method decodeGet
	 * @return {Array} Decoded JSON.
	 */
	public static function decodeGet() {
		if (isset($_GET[self::$name])) {
			return json_decode($_GET[self::$name], true);
		}
	}

	/**
	 * Method for returning decoded JSON from POST.
	 *
	 * @method decodePost
	 * @return {Array} Decoded JSON.
	 */
	public static function decodePost() {
		if (isset($_POST[self::$name])) {
			return json_decode($_POST[self::$name], true);
		}
	}

	/**
	 * Method for returning JSON as string from GET.
	 *
	 * @method encodeGet
	 * @return {String} Raw JSON.
	 */
	public static function encodeGet() {
		if (isset($_GET[self::$name])) {
			return $_GET[self::$name];
		}
	}

	/**
	 * Method for returning JSON as string from POST.
	 *
	 * @method encodePost
	 * @return {String} Raw JSON.
	 */
	public static function encodePost() {
		if (isset($_POST[self::$name])) {
			return $_POST[self::$name];
		}
	}

	/**
	 * Method for checking whether JSON has been passed through GET.
	 *
	 * @method isGet
	 * @return {Boolean}
	 */
	public static function isGet() {
		return isset($_GET[self::$name]);
	}

	/**
	 * Method for checking whether JSON has been passed through POST.
	 *
	 * @method isPost
	 * @return {Boolean}
	 */
	public static function isPost() {
		return isset($_POST[self::$name]);
	}
}

?>