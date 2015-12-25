<?php

require_once(dirname(__DIR__) . '/functions/GetJSON.php');


/**
 * Model class, the class is extended by all models. It provides a foundation for all models.
 *
 * @class Model
 * @static
 */

class Model
{
	/**
	 * The data object is used to store.
	 *
	 * @property
	 * @type {Object}
	 */
	protected static $data = array();


	/**
	 * Call allows PHP to pass data into the model.
	 *
	 * @method
	 * @param {Object} Data object to interact with the model
	 * @return {}
	 */
	public static function call($data) {
		self::$data = $data;

		return static::main();
	}


	/**
	 * Function that is called to check if it is called with Post.
	 *
	 * @method
	 */
	public static function init() {
		if (GetJSON::isPost()) {
			self::$data = GetJSON::decodePost();

			echo json_encode(static::main());
		}
	}
}

?>