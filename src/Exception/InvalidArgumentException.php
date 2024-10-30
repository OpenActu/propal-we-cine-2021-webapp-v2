<?php

namespace App\Exception;

use App\Contracts\ExceptionInterface;

class InvalidArgumentException extends \Exception implements ExceptionInterface
{
	public function __construct($message,$code=self::INVALID_ARGUMENT_EXCEPTION)
	{
		parent::__construct($message,$code);
	}
}
