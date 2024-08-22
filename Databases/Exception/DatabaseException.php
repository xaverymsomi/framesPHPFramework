<?php

declare(strict_types=1);

namespace Database\Exception;

use PDOException;
use Throwable;

class DatabaseException extends PDOException
{
	protected $code;
	protected $message;
	public function __construct($message = "", $code = 0, Throwable $previous = null){
		parent::__construct("Database connection error");
		$this->code = $code;
		$this->message = $message;
	}
}