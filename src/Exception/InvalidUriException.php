<?php
namespace App\Exception;

use App\Contracts\InvalidUriExceptionInterface;

class InvalidUriException extends \Exception implements InvalidUriExceptionInterface
{
	public function __construct($message,$code,array $params=array())
	{
		if(0 !== count($params))
		{
			foreach($params as $param => $value)
			{
				$message = str_replace("%".$param."%",$value,$message);
			}
		}
		parent::__construct($message,$code);
	}
}
