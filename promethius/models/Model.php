<?php

require_once(dirname(__DIR__) . '/models/GetJSON.php');


class Model
{
	private static $data = array();


	public static function call($data) {
		self::$data = $data;

		return self::main();
	}

	public static function init() {
		if (GetJSON::isPost()) {
			self::$data = GetJSON::decodePost();

			echo json_encode(self::main());
		}
	}
}

?>