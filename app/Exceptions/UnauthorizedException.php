<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedException extends ApiException
{
    public function __construct(string $message = 'Yetkisiz erişim')
    {
        parent::__construct($message, 401);
    }
}
