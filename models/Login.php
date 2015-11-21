<?php

require_once(dirname(__DIR__) . '/models/Database.php');
require_once(dirname(__DIR__) . '/models/GetJSON.php');

session_start();


class Login
{
	private static $query = 'SELECT id, username, first_name, last_name, hash FROM users WHERE username=:username';
	private static $username;
	private static $password;
	private static $errorMsg = 'false';
	private static $data;
	private static $user = array();


	private static function main() {
		$result = Database::$conn->prepare(self::$query);
		
		self::$username = self::$data['username'];
		self::$password = self::$data['password'];
		
		// check if query is successful
		if ($result->execute(array(':username' => self::$username))) {
			self::$user = $result->fetchAll(PDO::FETCH_ASSOC)[0];
			$hash = self::$user['hash'];

			// check if password matches
			if (password_verify(self::$password, $hash)) {
				self::storeSession();
			}
			else {
				echo(self::$errorMsg);
			}
		}
		else {
			echo(self::$errorMsg);
		}
	}

	private static function storeSession() {
		$_SESSION['user'] = array();
		$_SESSION['user']['id'] = self::$user['id'];
		$_SESSION['user']['username'] = self::$user['username'];
		$_SESSION['user']['first_name'] = self::$user['first_name'];
		$_SESSION['user']['last_name'] = self::$user['last_name'];

		echo 'true';
	}


	public static function call($json) {
		self::$data = json_decode($json, true);
		self::main();
	}

	public static function logout($json) {
		session_unset();
		session_destroy();
		
		echo 'true';
	}

	public static function init() {
		if (GetJSON::isGet() && GetJSON::decodeGet()['command'] == 'login') {
			self::$data = GetJSON::decodeGet();
			self::main();
		}
		else if (GetJSON::isGet() && GetJSON::decodeGet()['command'] == 'logout') {
			self::logout();
		}
	}
}

Login::init();

?>