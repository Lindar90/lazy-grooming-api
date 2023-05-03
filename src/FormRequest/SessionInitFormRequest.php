<?php

namespace App\FormRequest;

use App\DTO\SessionInitRequestDTO;

class SessionInitFormRequest extends AbstractFormRequest
{
    protected function createDTO(): SessionInitRequestDTO
    {
        return new SessionInitRequestDTO(
            $this->request->get('sessionName'),
            $this->request->get('ownerName'),
        );
    }
}
