<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends ApiException
{
    public function __construct(string $message = 'Kaynak bulunamadı')
    {
        parent::__construct($message, 404);
    }
}
