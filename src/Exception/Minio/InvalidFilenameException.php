<?php

namespace App\Exception\Minio;

use App\Contracts\ExceptionInterface;

class InvalidFilenameException extends \Exception implements ExceptionInterface
{
	public function __construct($message,$code=self::MINIO_INVALID_FILENAME_CODE)
	{
		parent::__construct($message,$code);
	}
}
