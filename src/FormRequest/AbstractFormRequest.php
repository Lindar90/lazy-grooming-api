<?php

namespace App\FormRequest;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractFormRequest extends Request implements FormRequestInterface
{
    protected array $errors = [];

    private ValidatorInterface $validator;
    
    public function __construct(
        ValidatorInterface $validator,
        array              $query = [],
        array              $request = [],
        array              $attributes = [],
        array              $cookies = [],
        array              $files = [],
        array              $server = [],
        $content = null
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->validator = $validator;
    }

    public function isValid(): bool
    {
        $dto = $this->getDTO();
        $violations = $this->validator->validate($dto);

        $this->errors = [];

        foreach ($violations as $violation) {
            $this->errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $violations->count() === 0;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
