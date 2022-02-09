<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\Exception;

use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalResponseErrorDTO;

interface ErrorsExceptionInterface
{
    /**
     * @return ConventionalResponseErrorDTO[]
     */
    public function getErrors(): array;
}
