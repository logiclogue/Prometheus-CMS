<?php

require_once(dirname(__DIR__) . '/models/Model.php');

session_start();


class Logout extends Model
{
	protected static function main() {
		session_unset();
		session_destroy();

		return true;
	}
}

Logout::init();

?>