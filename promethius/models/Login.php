<?php

requrie_once(dirname(__DIR__) . '/models/Model.php');
require_once(dirname(__DIR__) . '/models/Database.php');
require_once(dirname(__DIR__) . '/models/GetJSON.php');

session_start();


class Login extends Model
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
				return self::storeSession();
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}

	private static function storeSession() {
		$_SESSION['user'] = array();
		$_SESSION['user']['id'] = self::$user['id'];
		$_SESSION['user']['username'] = self::$user['username'];
		$_SESSION['user']['first_name'] = self::$user['first_name'];
		$_SESSION['user']['last_name'] = self::$user['last_name'];

		return true;
	}


	public static function logout($json) {
		session_unset();
		session_destroy();
		
		return true;
	}

	public static function init() {
		if (GetJSON::isPost() && GetJSON::decodePost()['command'] == 'login') {
			self::$data = GetJSON::decodePost();
			echo json_encode(self::main());
		}
		else if (GetJSON::isPost() && GetJSON::decodePost()['command'] == 'logout') {
			echo json_encode(self::logout());
		}
	}
}

Login::init();

?>