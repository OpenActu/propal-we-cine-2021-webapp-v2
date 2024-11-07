<?php

namespace App\Exception\Proxy;

use App\Contracts\ExceptionInterface;

class NoIdentifierException extends \Exception implements ExceptionInterface
{
	public function __construct($message=self::PROXY_MOVIE_REPOSITORY_NO_ID_MSG,$code=self::PROXY_MOVIE_REPOSITORY_NO_ID_CODE)
	{
		parent::__construct($message,$code);
	}
}
