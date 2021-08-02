<?php

namespace App\Application\School\SchoolSync;

use App\Application\School\SchoolSync\Resolver\SchoolSyncResolverInterface;
use App\Domain\Repository\School\SchoolRepositoryInterface;
use App\Infrastructure\HttpClients\School\SchoolService;

/**
 * Class SchoolSyncService.
 *
 * @package App\Application\School\SchoolSync
 */
class SchoolSyncService implements SchoolSyncServiceInterface
{
    /**
     * @var SchoolService
     */
    private SchoolService $schoolService;

    /**
     * @var SchoolRepositoryInterface
     */
    private SchoolRepositoryInterface $repository;

    /**
     * @var SchoolSyncResolverInterface
     */
    private SchoolSyncResolverInterface $resolver;

    /**
     * SchoolSyncService constructor.
     *
     * @param SchoolService $schoolService
     * @param SchoolRepositoryInterface $repository
     * @param SchoolSyncResolverInterface $resolver
     */
    public function __construct(
        SchoolService $schoolService,
        SchoolRepositoryInterface $repository,
        SchoolSyncResolverInterface $resolver
    ) {
        $this->schoolService = $schoolService;
        $this->repository = $repository;
        $this->resolver = $resolver;
    }

    /**
     * @inheritDoc
     */
    public function sync(): int
    {
        $schools = $this->schoolService->getAll();

        $this->repository->beginTransaction();

        $this->repository->deleteAll();

        foreach ($schools as $school) {
            $schoolEntity = $this->resolver->resolve($school);

            $this->repository->save($schoolEntity);
        }

        $this->repository->commit();

        return count($schools);
    }
}
