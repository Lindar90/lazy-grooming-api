<?php

namespace App\FormRequest;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractFormRequest extends Request implements FormRequestInterface
{
    protected array $errors = [];

    protected object $dto;

    private ValidatorInterface $validator;

    abstract protected function createDTO(): object;

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
        $this->dto = $this->createDTO();
        $violations = $this->validator->validate($this->dto);

        $this->errors = [];

        foreach ($violations as $violation) {
            $this->errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $violations->count() === 0;
    }

    public function getDTO(): object
    {
        return $this->dto;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
