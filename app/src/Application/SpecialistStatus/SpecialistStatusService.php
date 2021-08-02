<?php

namespace App\Application\SpecialistStatus;

use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use App\Domain\Service\Specialist\SpecialistStatusCalcServiceInterface;
use Generator;

/**
 * Class SpecialistStatusService.
 */
class SpecialistStatusService
{
    /**
     * @var SpecialistStatusCalcServiceInterface
     */
    private SpecialistStatusCalcServiceInterface $calcService;

    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $repository;

    /**
     * SpecialistStatusCalcServiceInterface constructor.
     * @param SpecialistStatusCalcServiceInterface $calcService
     * @param SpecialistRepositoryInterface $repository
     */
    public function __construct(
        SpecialistStatusCalcServiceInterface $calcService,
        SpecialistRepositoryInterface $repository
    ) {
        $this->calcService = $calcService;
        $this->repository = $repository;
    }

    /**
     * @return Generator
     */
    public function update(): Generator
    {
        $specialistsIDs = $this->repository->findAllSpecialistsIDs();

        foreach ($specialistsIDs as $specialistsID) {
            $specialist = $this->repository->find($specialistsID);

            if (!$specialist) {
                continue;
            }

            $this->calcService->calcStatus($specialist);

            yield $specialistsID;
        }

        return;
    }

    /**
     * Число специалистов для обновления.
     *
     * @return int
     */
    public function getNumberOfSpecialistsToUpdate(): int
    {
        return count($this->repository->findAllSpecialistsIDs());
    }
}
