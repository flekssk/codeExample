<?php

declare(strict_types=1);

namespace App\Application\Specialist\SpecialistCount;

use App\Application\Specialist\SpecialistCount\Assembler\SpecialistCountAssemblerInterface;
use App\Application\Specialist\SpecialistCount\Dto\SpecialistCountDto;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;

/**
 * Class SpecialistCountService.
 *
 * @package App\Application\Specialist\SpecialistCountSpecialist
 */
class SpecialistCountService
{
    /**
     * @var SpecialistCountAssemblerInterface
     */
    private SpecialistCountAssemblerInterface $specialistCountAssembler;

    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $specialistRepository;

    /**
     * SpecialistCountService constructor.
     *
     * @param SpecialistCountAssemblerInterface $specialistCountAssembler
     * @param SpecialistRepositoryInterface     $specialistRepository
     */
    public function __construct(
        SpecialistCountAssemblerInterface $specialistCountAssembler,
        SpecialistRepositoryInterface $specialistRepository
    ) {
        $this->specialistCountAssembler = $specialistCountAssembler;
        $this->specialistRepository = $specialistRepository;
    }

    /**
     * @return SpecialistCountDto
     */
    public function total(): SpecialistCountDto
    {
        $dto = $this
            ->specialistCountAssembler
            ->assemble(
                $this->specialistRepository->totalCount()
            );

        return $dto;
    }
}
