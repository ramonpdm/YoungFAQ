<?php

namespace App\Core\Exceptions;

use Exception;
use Throwable;

class DatabaseException extends Exception
{
    protected $code;

    public function __construct($message, $code = '', Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->code = $code;
    }

    /** 
     * Custom string representation of object
     * 
     * @return string
     */
    public function __toString()
    {
        return '<strong>' . __CLASS__ . ": [{$this->code}]:</strong> {$this->message}\n";
    }
}
