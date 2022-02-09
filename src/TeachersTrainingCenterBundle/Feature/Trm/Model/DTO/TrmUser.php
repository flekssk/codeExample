<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\Trm\Model\DTO;

use TeachersTrainingCenterBundle\Feature\User\Contracts\UserInterface;

class TrmUser implements UserInterface
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
