<?php

require dirname(__DIR__) . '/models/Database.php';


class Login
{
	private static $query = 'SELECT hash FROM users WHERE username=:username';
	private static $username;
	private static $password;
	private static $errorMsg = 'Incorrect username or password';


	private static function storeSession() {
		$_SESSION['username'] = self::$username;

		echo 'Successfully logged in';
	}

	public static function init() {
		$result = Database::$conn->prepare(self::$query);
		$data = json_decode($_GET['data'], true);
		self::$username = $data['username'];
		self::$password = $data['password'];
		
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
}

Login::init();

?>