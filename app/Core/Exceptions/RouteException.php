<?php

namespace App\Core\Exceptions;

use Exception;
use Throwable;

class RouteException extends Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
