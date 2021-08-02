<?php

namespace App\Application\Specialist\SpecialistOrder\SpecialistOrderGenerator;

use App\Domain\Entity\Specialist\Specialist;
use Exception;

/**
 * Interface SpecialistOrderGeneratorServiceInterface.
 *
 * @package App\Application\Specialist\SpecialistOrder.
 */
interface SpecialistOrderGeneratorServiceInterface
{
    /**
     * @param Specialist $specialist
     *
     * @throws Exception
     */
    public function generateInclusionOrder(Specialist $specialist): void;

    /**
     * @param array $documents
     *
     * @throws Exception
     */
    public function generateIssueOfADocumentOrder(array $documents): void;
}
