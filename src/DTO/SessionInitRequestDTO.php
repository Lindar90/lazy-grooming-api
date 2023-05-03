<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class SessionInitRequestDTO
{
    public function __construct(
        #[Assert\NotBlank(normalizer: "trim")]
        #[Assert\Length(max: 256)]
        private readonly ?string $sessionName,
        #[Assert\NotBlank(normalizer: "trim")]
        #[Assert\Length(max: 256)]
        private readonly ?string $ownerName,
    ) {
    }
}
