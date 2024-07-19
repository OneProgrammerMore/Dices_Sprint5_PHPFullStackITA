<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class UserNotFoundByEmailException extends Exception
{
    public const MESSAGE = 'No user was found with the email: %s';

    public function __construct(string $email, $code = 401, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $email);
        parent::__construct($message, $code, $previous);
    }
}
