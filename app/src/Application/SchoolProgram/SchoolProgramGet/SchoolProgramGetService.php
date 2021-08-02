<?php

namespace App\Application\SchoolProgram\SchoolProgramGet;

use App\Domain\Repository\NotFoundException;
use App\Domain\Repository\Product\ProductRepositoryInterface;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use App\Infrastructure\HttpClients\SchoolProgram\SchoolProgramService;
use GuzzleHttp\Exception\RequestException;

/**
 * Class SchoolProgramGetService.
 *
 * @package App\Application\SchoolProgram\SchoolProgramGet
 */
class SchoolProgramGetService implements SchoolProgramGetServiceInterface
{
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
     * SchoolProgramGetService constructor.
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
     * @inheritDoc
     *
     * @throws RequestException
     */
    public function getFinishedBySpecialistId(int $id): array
    {
        $user = $this->specialistRepository->find($id);

        if (!$user) {
            throw new NotFoundException("Специалист с ID={$id} не найден.");
        }

        $versions = $this->productRepository->findAllIds();

        $schoolPrograms = $this->schoolProgramService->getUserProgramsBySpecialistIdAndVersions($id, $versions);

        // Сортировка по дате начала.
        usort($schoolPrograms, function ($a, $b) {
            if ($a->programDateStart == $b->programDateStart) {
                return 0;
            }

            return ($a->programDateStart < $b->programDateStart) ? 1 : -1;
        });

        return array_values($schoolPrograms);
    }

    /**
     * @inheritDoc
     *
     * @throws RequestException
     */
    public function getNotFinishedBySpecialistId(int $id): array
    {
        $user = $this->specialistRepository->find($id);

        if (!$user) {
            throw new NotFoundException("Специалист с ID={$id} не найден.");
        }

        $versions = $this->productRepository->findAllIds();

        $allSchoolPrograms = $this->schoolProgramService->getPrograms($versions);
        $userSchoolPrograms = $this->schoolProgramService->getUserProgramsBySpecialistIdAndVersions($id, $versions, false);

        // Перенос programProgress из массива курсов пользователей в массив всех курсов.
        foreach ($userSchoolPrograms as $programId => $userSchoolProgram) {
            if (isset($allSchoolPrograms[$programId])) {
                // Пропустить завершенные курсы.
                if ($userSchoolProgram->programProgress == 1) {
                    continue;
                }
                $allSchoolPrograms[$programId]->programProgress = $userSchoolProgram->programProgress;
                // Курс удаляется, так как после последующего array_diff_key() этот курс должен остаться
                // в массиве со всеми курсами.
                unset($userSchoolPrograms[$programId]);
            }
        }

        $result = array_diff_key($allSchoolPrograms, $userSchoolPrograms);

        return array_values($result);
    }
}
