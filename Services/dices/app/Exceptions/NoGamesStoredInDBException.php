<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class NoGamesStoredInDBException extends Exception
{
    public const MESSAGE = 'It was not possible to retrieve any games from the database.';

    public function __construct( $code = 204, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE);
        parent::__construct($message, $code, $previous);
    }
}
