<?php

namespace App\FormRequest;

use App\DTO\SessionInitRequestDTO;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SessionInitFormRequest extends AbstractFormRequest
{
    private SessionInitRequestDTO $dto;

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
        parent::__construct($validator, $query, $request, $attributes, $cookies, $files, $server, $content);
        $this->createDTO();
    }

    private function createDTO(): SessionInitRequestDTO
    {
        $this->dto = new SessionInitRequestDTO(
            $this->request->get('sessionName'),
            $this->request->get('ownerName'),
        );

        return $this->dto;
    }

    public function getDTO(): SessionInitRequestDTO
    {
        return $this->dto;
    }
}
