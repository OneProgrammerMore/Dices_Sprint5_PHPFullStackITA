<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class ThrowNotStoredInDBException extends Exception
{
    public const MESSAGE = 'It was not possible to store the dices throw with user ID %s and dices result %d and %d';

    public function __construct(string $user_id, array $dices, $code = 401, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $user_id, $dices['dice_1'], $dices['dice_1']);
        parent::__construct($message, $code, $previous);
    }
}
