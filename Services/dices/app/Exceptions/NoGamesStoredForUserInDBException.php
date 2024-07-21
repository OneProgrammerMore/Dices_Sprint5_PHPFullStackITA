<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class NoGamesStoredForUserInDBException extends Exception
{
    public const MESSAGE = 'It was not possible to retrieve the throws with user ID %s';

    public function __construct(string $user_id, $code = 204, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $user_id);
        parent::__construct($message, $code, $previous);
    }
}
