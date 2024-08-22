<?php

declare(strict_types=1);

namespace Database;

use Database\Exception\DatabaseException;
use PDO;
use PDOException;

class DatabaseConnection implements DatabaseInterface
{

	/**
	 * @var PDO
	 */

	protected PDO $pdo;

	/**
	 * @var array
	 */
	protected array $credentials;

	/**
	 * Main constructor class
	 *
	 * @param array $credentials
	 */
	public function __construct(array $credentials){
		$this->credentials = $credentials;
	}
	/**
	 * @inheritDoc
	 */
	public function openConnection() : PDO
	{
		// TODO: Implement openConnection() method.
		try {
			$params = [
				PDO::ATTR_EMULATE_PREPARES => false,
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			];
			$this->pdo = new PDO(
				$this->credentials['dsn'],
				$this->credentials['username'],
				$this->credentials['password'],
				$params
			);
		} catch (PDOException $e) {
			throw new DatabaseException($e->getMessage(), (int)$e->getCode());
		}
		return $this->pdo;
	}

	/**
	 * @inheritDoc
	 * @return void
	 */
	public function closeConnection() : void
	{
		// TODO: Implement closeConnection() method.
		$this->pdo = null;
	}
}