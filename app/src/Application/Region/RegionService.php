<?php

namespace App\Application\Region;

use App\Domain\Repository\Region\RegionRepositoryInterface;
use App\Application\Exception\ValidationException;
use App\Application\Region\Assembler\RegionResultAssemblerInterface;

/**
 * Class RegionService.
 *
 * Сервис регионов.
 */
class RegionService implements RegionServiceInterface
{

    /**
     * Дефолтное значения для count.
     */
    const DEFAULT_COUNT = 10;

    /**
     * @var RegionRepositoryInterface
     */
    private RegionRepositoryInterface $repository;

    /**
     * @var RegionResultAssemblerInterface
     */
    private RegionResultAssemblerInterface $assembler;

    /**
     * @param RegionRepositoryInterface      $regionRepository
     * @param RegionResultAssemblerInterface $assembler
     */
    public function __construct(
        RegionRepositoryInterface $regionRepository,
        RegionResultAssemblerInterface $assembler
    ) {
        $this->repository = $regionRepository;
        $this->assembler = $assembler;
    }

    /**
     * @inheritdoc
     */
    public function search(string $name, int $count): array
    {
        if (empty($count)) {
            $count = self::DEFAULT_COUNT;
        }
        $regions = $this->repository->findByName($name, $count);
        $dtoObjects = [];
        foreach ($regions as $region) {
            $dtoObjects[] = $this->assembler->assemble($region);
        }

        return $dtoObjects;
    }
}
