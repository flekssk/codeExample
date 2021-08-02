<?php

declare(strict_types=1);

namespace App\Application\Specialist\Specialist\Assembler;

use App\Application\Specialist\Specialist\Dto\SpecialistUpdateDto;
use App\Domain\Repository\Position\PositionRepositoryInterface;
use App\Domain\Repository\Region\RegionRepositoryInterface;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use Exception;

/**
 * Class SpecialistUpdateAssembler.
 *
 * @package App\Application\Specialist\Specialist\Assembler
 */
class SpecialistUpdateAssembler implements SpecialistUpdateAssemblerInterface
{
    /**
     * @var RegionRepositoryInterface
     */
    private RegionRepositoryInterface $regionRepository;

    /**
     * @var PositionRepositoryInterface
     */
    private PositionRepositoryInterface $positionRepository;

    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $specialistRepository;


    /**
     * SpecialistUpdateAssembler constructor.
     *
     * @param SpecialistRepositoryInterface $specialistRepository
     * @param RegionRepositoryInterface $regionRepository
     * @param PositionRepositoryInterface $positionRepository
     */
    public function __construct(
        SpecialistRepositoryInterface $specialistRepository,
        RegionRepositoryInterface $regionRepository,
        PositionRepositoryInterface $positionRepository
    ) {
        $this->specialistRepository = $specialistRepository;
        $this->regionRepository = $regionRepository;
        $this->positionRepository = $positionRepository;
    }

    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    public function assemble($options): SpecialistUpdateDto
    {
        $dto = new SpecialistUpdateDto();
        $dto->id = (int)$options['id'];

        return $dto;
    }
}
