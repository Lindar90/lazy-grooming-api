<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class BadRequestWithErrorsHttpException extends BadRequestHttpException
{
    public array $errors;

    public function __construct(
        array $errors,
        string $message = '',
        Throwable $previous = null,
        int $code = 0,
        array $headers = []
    ) {
        parent::__construct($message, $previous, $code, $headers);
        $this->errors = $errors;
    }
}
