<?php

namespace App\Infrastructure\Persistence\Sphinx\Repository\Specialist;

use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Repository\Specialist\SpecialistRepository;
use App\Infrastructure\Persistence\Sphinx\Repository\Specialist\Dto\SpecialistFindDto;
use App\Infrastructure\Repository\Specialist\SpecialistSearchRepositoryInterface;
use Pluk77\SymfonySphinxBundle\Sphinx\Manager;
use Pluk77\SymfonySphinxBundle\Sphinx\Query;

/**
 * Class SpecialistSphinxRepository.
 *
 * @package App\Infrastructure\Persistence\Sphinx\Repository\Specialist
 */
class SpecialistSphinxRepository implements SpecialistSearchRepositoryInterface
{
    private const AGENT_QUERY_TIMEOUT = 10000;

    private const MAX_MATCHES = 50000;

    /**
     * @var Manager
     */
    private Manager $sphinxManager;

    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $repository;

    /**
     * @var string
     */
    private string $specialistIndex;

    /**
     * SpecialistRepository constructor.
     *
     * @param SpecialistRepository $specialistRepository
     * @param Manager              $sphinxManager
     * @param string               $specialistIndex
     */
    public function __construct(SpecialistRepository $specialistRepository, Manager $sphinxManager, string $specialistIndex)
    {
        $this->repository = $specialistRepository;
        $this->sphinxManager = $sphinxManager;
        $this->specialistIndex = $specialistIndex;
    }

    /**
     * @inheritDoc
     */
    public function findBy(
        SpecialistFindDto $findDto,
        string $orderBy = null,
        int $limit = 20,
        int $offset = 1,
        string $orderDirection = 'desc'
    ): array {
        $query = $this->getFindQuery($findDto);

        if (!is_null($orderBy)) {
            $query->orderBy($orderBy, $orderDirection);
        }

        $query
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->setOption('agent_query_timeout', self::AGENT_QUERY_TIMEOUT)
            ->addOption('max_matches', self::MAX_MATCHES);

        return $query->getResults();
    }

    /**
     * @inheritDoc
     */
    public function findResultsTotalCount(SpecialistFindDto $findDto): int
    {
        $query = $this->getFindQuery($findDto);

        $query->execute();

        return $query->getTotalFound();
    }

    /**
     * Метод получения базового объхекта запроса.
     *
     * @param SpecialistFindDto $findDto
     *
     * @return Query
     */
    private function getFindQuery(SpecialistFindDto $findDto): Query
    {
        $queryBuilder = $this->repository->createQueryBuilder('specialist_index');

        /** @noinspection PhpParamsInspection */
        $query = $this->sphinxManager
            ->createQuery()
            ->from($this->specialistIndex)
            ->select('id');

        if (!empty($findDto->searchString)) {
            $query->andMatch('full_text', $findDto->searchString);
        }

        if (!empty($findDto->document)) {
            $query->andMatch('document', $findDto->document);
        }

        if (!empty($findDto->region)) {
            $query->andMatch('region', $findDto->region);
        }

        if (!empty($findDto->company)) {
            $query->andMatch('company', $findDto->company);
        }

        if (!empty($findDto->id2Position)) {
            $query->andMatch('id2position', $findDto->id2Position);
        }

        if (!empty($findDto->status)) {
            $query->andMatch('status_id', $findDto->status);
        }

        $query->useQueryBuilder($queryBuilder, 'specialist_index', 'id');

        return $query;
    }
}
