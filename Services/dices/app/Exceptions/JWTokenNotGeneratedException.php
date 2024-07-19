<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class JWTokenNotGeneratedException extends Exception
{
    public const MESSAGE = 'It was not possible to generate the JWToken for the user with id: %s';

    public function __construct(string $id, $code = 401, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $id);
        parent::__construct($message, $code, $previous);
    }
}
