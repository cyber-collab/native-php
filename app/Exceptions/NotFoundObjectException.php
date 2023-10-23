<?php

namespace App\Exceptions;

use Throwable;

class NotFoundObjectException extends \Exception
{
    public function __construct(string $message = "Object not found", int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
