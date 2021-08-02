<?php

declare(strict_types=1);

namespace App\Domain\Service\Specialist;

use App\Domain\Entity\Specialist\Specialist;
use App\Domain\Entity\Specialist\ValueObject\Status;

interface SpecialistStatusCalcServiceInterface
{
    /**
     * @param Specialist $specialist
     * @return Status
     */
    public function calcStatus(Specialist $specialist): Status;
}
