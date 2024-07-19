<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class NameAlreadyTakenException extends Exception
{
    public const MESSAGE = 'The name  %s  is already taken';

    public function __construct(string $name, $code = 401, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $name);
        parent::__construct($message, $code, $previous);
    }
}
