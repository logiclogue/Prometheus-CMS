<?php

require dirname(__DIR__) . '/models/Database.php';
require dirname(__DIR__) . '/models/GetJSON.php';


class Login
{
	private static $query = 'SELECT hash FROM users WHERE username=:username';
	private static $username;
	private static $password;
	private static $errorMsg = 'Incorrect username or password';
	private static $data;


	private static function main() {
		$result = Database::$conn->prepare(self::$query);
		
		self::$username = self::$data['username'];
		self::$password = self::$data['password'];
		
		// check if query is successful
		if ($result->execute(array(':username' => self::$username))) {
			$hash = $result->fetchAll(PDO::FETCH_ASSOC)[0]['hash'];

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
		$_SESSION['username'] = self::$username;

		echo 'Successfully logged in';
	}


	public static function init() {
		if (GetJSON::isGet()) {
			self::$data = GetJSON::decodeGet();
			self::main();
		}
	}

	public static function call($json) {
		self::$data = json_decode($json, true);
		self::main();
	}
}

Login::init();

?>