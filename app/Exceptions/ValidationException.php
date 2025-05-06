<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends ApiException
{
    public function __construct(array $errors, string $message = 'Doğrulama hatası')
    {
        parent::__construct($message, 422, $errors);
    }
}
