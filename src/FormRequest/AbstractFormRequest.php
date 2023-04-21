<?php

namespace App\FormRequest;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractFormRequest extends Request implements FormRequestInterface
{
    protected array $errors = [];

    abstract protected function getRules(): array;

    public function isValid(): bool
    {
        $validator = $this->getValidator();
        $constraints = $this->getConstraints();
        $violations = $validator->validate($this->request->all(), $constraints);

        $this->errors = [];

        foreach ($violations as $violation) {
            $this->errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $violations->count() === 0;
    }

    public function getData(): array
    {
        return $this->request->all();
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    protected function getValidator(): ValidatorInterface
    {
        return Validation::createValidator();
    }

    protected function getConstraints(): Assert\Collection
    {
        return new Assert\Collection($this->getRules());
    }
}
