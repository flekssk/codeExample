<?php

namespace App\Application\SchoolProgram\SchoolProgressGet;

use App\Domain\Repository\NotFoundException;
use App\Domain\Repository\Product\ProductRepositoryInterface;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use GuzzleHttp\Exception\RequestException;
use App\Infrastructure\HttpClients\SchoolProgram\SchoolProgramService;

/**
 * Class SchoolProgressGetService.
 *
 * @package App\Application\SchoolProgram\SchoolProgressGet
 */
class SchoolProgressGetService
{
    /**
     * Default progress value
     * @var float
     */
    const DEFAULT_VALUE = 0.0;

    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $specialistRepository;

    /**
     * @var SchoolProgramService
     */
    private SchoolProgramService $schoolProgramService;

    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    /**
     * SchoolProgressGetService constructor.
     *
     * @param SpecialistRepositoryInterface $specialistRepository
     * @param SchoolProgramService $schoolProgramService
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        SpecialistRepositoryInterface $specialistRepository,
        SchoolProgramService $schoolProgramService,
        ProductRepositoryInterface $productRepository
    ) {
        $this->specialistRepository = $specialistRepository;
        $this->schoolProgramService = $schoolProgramService;
        $this->productRepository = $productRepository;
    }

    /**
     * @param int $id
     * @return float
     * @throws RequestException
     */
    public function getProgressValueBySpecialistId(int $id): float
    {
        $user = $this->specialistRepository->find($id);

        if (!$user) {
            throw new NotFoundException("Специалист с ID={$id} не найден.");
        }

        $versions = $this->productRepository->findAllIds();
        $schoolPrograms = $this->schoolProgramService->getUserProgramsBySpecialistIdAndVersions($id, $versions, false);

        if ($schoolPrograms) {
            $progressValues = [];
            foreach ($schoolPrograms as $program) {
                $progressValues[] = $program->programProgress;
            }
            if ($progressValues) {
                return max($progressValues);
            }
        }

        return self::DEFAULT_VALUE;
    }
}
