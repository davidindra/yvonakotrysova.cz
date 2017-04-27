<?php

namespace App\Model;

use Nette;
use Tracy\Debugger;

/**
 * Users management.
 */
class UserManager implements Nette\Security\IAuthenticator
{
	use Nette\SmartObject;

	public function __construct()
	{

	}

	/**
	 * Performs an authentication.
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;
		$users = json_decode(file_get_contents(__DIR__ . '/../config/secrets.json'))->users;

		if (!isset($users->$username)) {
			throw new Nette\Security\AuthenticationException('Uživatel neexistuje.', self::IDENTITY_NOT_FOUND);

		} elseif ($users->$username != $password) {
			throw new Nette\Security\AuthenticationException('Heslo není správné.', self::INVALID_CREDENTIAL);

		}

		return new Nette\Security\Identity(1);
	}
}
