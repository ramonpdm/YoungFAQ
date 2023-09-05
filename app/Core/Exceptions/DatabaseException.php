<?php

namespace App\Core\Exceptions;

use Exception;
use Throwable;

class DatabaseException extends Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString()
    {
        return '<strong>' . __CLASS__ . ": [{$this->code}]:</strong> {$this->message}\n";
    }
}
