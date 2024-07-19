<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class RegisterUserDataNotCorrectException extends Exception
{
    public const MESSAGE = 'It was not possible to register the user with the data: Name: %s ; Email: %s ; Password: %s';

    public function __construct(array $data, $code = 401, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $data['name'] ?? 'None', $data['email'] ?? 'None', $data['password'] ?? 'None');
        parent::__construct($message, $code, $previous);
    }
}
