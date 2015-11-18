<?php

require 'Database.php';


class Login
{
	private static $query = 'SELECT hash FROM users WHERE username=:username';
	private static $username = 'logiclogue';
	private static $password = 'password';


	private static function storeSession() {
		$_SESSION['username'] = self::$username;
	}

	public static function init() {
		$result = Database::$conn->prepare(self::$query);
		
		// check if query is successful
		if ($result->execute(array(':username' => self::$username))) {
			$hash = $result->fetchAll(PDO::FETCH_ASSOC)[0]['hash'];

			if (password_verify(self::$password, $hash)) {
				self::storeSession();
			}
		}
		else {
			echo('Query failed');
		}
	}
}

Login::init();

?>