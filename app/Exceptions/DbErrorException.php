<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class DbErrorException extends Exception
{
    /**
     *
     * @param string $message
     * @param integer $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            $message = "Database Exception";
        }

        parent::__construct($message, $code, $previous);
    }
}
