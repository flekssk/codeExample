<?php

namespace App\Application\Specialist\SpecialistViewCount;

use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;

/**
 * Class SpecialistViewCount.
 *
 * @package App\Application\Specialist\SpecialistGet
 */
class SpecialistViewCount
{
    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $specialistRepository;

    /**
     * SpecialistViewCount constructor.
     *
     * @param SpecialistRepositoryInterface $specialistRepository
     */
    public function __construct(
        SpecialistRepositoryInterface $specialistRepository
    ) {
        $this->specialistRepository = $specialistRepository;
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function increment(int $id): void
    {
        $specialist = $this->specialistRepository->get($id);

        $specialist->incrementViewCount();

        $this->specialistRepository->save($specialist);

        return;
    }
}
