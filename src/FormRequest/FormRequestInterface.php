<?php

namespace App\FormRequest;

interface FormRequestInterface
{
    public function isValid(): bool;

    public function getDTO(): object;

    public function getErrors(): array;
}
