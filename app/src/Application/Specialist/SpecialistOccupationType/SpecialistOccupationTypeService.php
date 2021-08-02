<?php

namespace App\Application\Specialist\SpecialistOccupationType;

use App\Domain\Repository\Specialist\SpecialistOccupationTypeRepositoryInterface;
use App\Application\Specialist\SpecialistOccupationType\Assembler\SpecialistOccupationTypeResultAssemblerInterface;

/**
 * Class SpecialistOccupationTypeService.
 */
class SpecialistOccupationTypeService
{

    /**
     * @var SpecialistOccupationTypeResultAssemblerInterface
     */
    private SpecialistOccupationTypeResultAssemblerInterface $assembler;

    /**
     * @var SpecialistOccupationTypeRepositoryInterface
     */
    private SpecialistOccupationTypeRepositoryInterface $repository;

    /**
     * SpecialistOccupationTypeService constructor.
     *
     * @param SpecialistOccupationTypeResultAssemblerInterface $assembler
     * @param SpecialistOccupationTypeRepositoryInterface $repository
     */
    public function __construct(
        SpecialistOccupationTypeResultAssemblerInterface $assembler,
        SpecialistOccupationTypeRepositoryInterface $repository
    ) {
        $this->assembler = $assembler;
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $dtoObjects = [];
        $types = $this->repository->findAll();
        foreach ($types as $type) {
            $dtoObjects[] = $this->assembler->assemble($type);
        }

        return $dtoObjects;
    }
}
