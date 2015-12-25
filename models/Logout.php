<?php

require_once(dirname(__DIR__) . '/models/Model.php');

session_start();


/**
 * Logout model when called logs the user out.
 *
 * @class
 * @extends Model
 * @static
 */
class Logout extends Model
{
	/**
	 * Main method that destroies the session.
	 *
	 * @method
	 * @return {Boolean} True.
	 */
	protected static function main() {
		session_unset();
		session_destroy();

		return true;
	}
}

Logout::init();

?>