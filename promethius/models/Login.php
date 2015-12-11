<?php

require_once(dirname(__DIR__) . '/models/Model.php');
require_once(dirname(__DIR__) . '/models/Database.php');

session_start();


class Login extends Model
{
	private static $query = 'SELECT id, username, first_name, last_name, hash FROM users WHERE username=:username';
	private static $result;
	private static $user = array();


	private static function storeSession() {
		$_SESSION['user'] = array();
		$_SESSION['user']['id'] = self::$user['id'];
		$_SESSION['user']['username'] = self::$user['username'];
		$_SESSION['user']['first_name'] = self::$user['first_name'];
		$_SESSION['user']['last_name'] = self::$user['last_name'];

		return true;
	}

	private static function login() {
		self::$user = self::$result->fetchAll(PDO::FETCH_ASSOC)[0];

		// check if password matches
		if (password_verify(self::$data['password'], self::$user['hash'])) {
			return self::storeSession();
		}
		else {
			return false;
		}
	}


	protected static function main() {
		self::$result = Database::$conn->prepare(self::$query);
		
		// check if query is successful
		if (self::$result->execute(array(':username' => self::$data['username']))) {
			self::login();
		}
		else {
			return false;
		}
	}
}

Login::init();

?>