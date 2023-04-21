<?php

namespace App\FormRequest;

interface FormRequestInterface
{
    public function isValid(): bool;

    public function getData(): array;

    public function getErrors(): array;
}
