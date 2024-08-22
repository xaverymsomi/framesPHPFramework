<?php

declare(strict_types=1);

namespace Database;
use PDO;

interface DatabaseInterface {
	/**
	 * Create a new database connection
	 *
	 *@return PDO
	 */
	public function openConnection() : PDO;

	/**
	 * close Database connection
	 */
	public function closeConnection() : void;
}