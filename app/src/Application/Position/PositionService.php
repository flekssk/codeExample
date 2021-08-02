<?php

namespace App\Application\Position;

use App\Application\Position\Assembler\PositionResultAssemblerInterface;
use App\Domain\Repository\Position\PositionRepositoryInterface;
use App\Infrastructure\HttpClients\Crm\CrmProxyInterface;

/**
 * Class PositionService.
 */
class PositionService implements PositionServiceInterface
{

    /**
     * Дефолтное значение count.
     */
    const DEFAULT_COUNT = 10;

    /**
     * @var CrmProxyInterface
     */
    private CrmProxyInterface $crmProxy;

    /**
     * @var PositionRepositoryInterface
     */
    private PositionRepositoryInterface $repository;

    /**
     * @var PositionResultAssemblerInterface
     */
    private PositionResultAssemblerInterface $positionAssembler;

    /**
     * @param CrmProxyInterface                $crmProxy
     * @param PositionRepositoryInterface      $positionRepository
     * @param PositionResultAssemblerInterface $positionAssembler
     */
    public function __construct(
        CrmProxyInterface $crmProxy,
        PositionRepositoryInterface $positionRepository,
        PositionResultAssemblerInterface $positionAssembler
    ) {
        $this->crmProxy = $crmProxy;
        $this->repository = $positionRepository;
        $this->positionAssembler = $positionAssembler;
    }

    /**
     * @inheritdoc
     */
    public function update(): int
    {
        $positions = $this->crmProxy->getPositions();
        try {
            $this->repository->beginTransaction();

            foreach ($positions as $position) {
                $this->repository->replace($position);
            }
            $this->repository->commit();
        } catch (\Exception $e) {
            $this->repository->rollBack();
            throw $e;
        }

        return count($positions);
    }

    /**
     * @inheritdoc
     */
    public function search(string $positionName, int $count): array
    {
        if (empty($count)) {
            $count = self::DEFAULT_COUNT;
        }

        $positionName = mb_strtolower($positionName);
        $positions = $this->repository->searchByName($positionName, $count);

        $list = [];
        foreach ($positions as $position) {
            $list[] = $this->positionAssembler->assemble($position);
        }

        return $list;
    }
}
