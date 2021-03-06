<?php

require_once(dirname(__DIR__) . '/models/Model.php');
require_once(dirname(__DIR__) . '/functions/Database.php');

session_start();


/**
 * Login model for logging in.
 *
 * @class Login
 * @extends Model
 * @static
 */
class Login extends Model
{
	/**
	 * SQL query for getting user data based off username entered.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private static $query = <<<SQL
		SELECT id, username, first_name, last_name, hash
		FROM users
		WHERE username=:username
SQL;
	/**
	 * Object for the result of @property query.
	 *
	 * @property result
	 * @type Object
	 * @private
	 */
	private static $result;
	/**
	 * Database statement for executing @property query.
	 *
	 * @property stmt
	 * @type Object
	 * @private
	 */
	private static $stmt;


	/**
	 * Method for adding user details to the user session.
	 *
	 * @method storeSession
	 * @private
	 * @return {Boolean} True.
	 */
	private static function storeSession() {
		$_SESSION['user'] = array();
		$_SESSION['user']['id'] = self::$result['id'];
		$_SESSION['user']['username'] = self::$result['username'];
		$_SESSION['user']['first_name'] = self::$result['first_name'];
		$_SESSION['user']['last_name'] = self::$result['last_name'];

		return true;
	}

	/**
	 * Verifies whether entered password matches one associated with the username entered.
	 *
	 * @method verify
	 * @private
	 * @return {Boolean} Whether password is correct.
	 */
	private static function verify() {
		self::$result = self::$stmt->fetchAll(PDO::FETCH_ASSOC)[0];

		// check if password matches
		if (password_verify(self::$data['password'], self::$result['hash'])) {
			return self::storeSession();
		}
		else {
			return false;
		}
	}


	/**
	 * Prepares @property stmt.
	 * Binds username to @property stmt.
	 *
	 * @method main
	 * @protected
	 * @return {Boolean} Whether successfully logged in.
	 */
	protected static function main() {
		self::$stmt = Database::$conn->prepare(self::$query);

		self::$stmt->bindParam(':username', self::$data['username']);
		
		// check if query is successful
		if (self::$stmt->execute()) {
			return self::verify();
		}
		else {
			return false;
		}
	}
}

Login::init();

?>