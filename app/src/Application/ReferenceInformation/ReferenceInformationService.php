<?php

declare(strict_types=1);

namespace App\Application\ReferenceInformation;

use App\Application\ReferenceInformation\Assembler\ReferenceInformationAssembler;
use App\Application\ReferenceInformation\Dto\ReferenceInformationDto;
use App\Domain\Repository\ReferenceInformation\ReferenceInformationRepositoryInterface;

/**
 * Class ReferenceInformationService.
 *
 * @package App\Application\ReferenceInformation
 */
class ReferenceInformationService
{
    /**
     * @var ReferenceInformationRepositoryInterface
     */
    private ReferenceInformationRepositoryInterface $repository;

    /**
     * @var ReferenceInformationAssembler
     */
    private ReferenceInformationAssembler $assembler;

    /**
     * ReferenceInformationService constructor.
     *
     * @param ReferenceInformationRepositoryInterface $repository
     * @param ReferenceInformationAssembler $assembler
     */
    public function __construct(
        ReferenceInformationRepositoryInterface $repository,
        ReferenceInformationAssembler $assembler
    ) {
        $this->repository = $repository;
        $this->assembler = $assembler;
    }

    /**
     * @return ReferenceInformationDto[]
     */
    public function getReferenceInformation(): array
    {
        $referenceInformationsDto = [];
        $referenceInformations = $this->repository->findAllActiveInformation();
        foreach ($referenceInformations as $referenceInformation) {
            $referenceInformationsDto[] = $this->assembler->assemble($referenceInformation);
        }

        return $referenceInformationsDto;
    }
}
