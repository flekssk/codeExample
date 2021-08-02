<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Specialist;

use App\Domain\Repository\Specialist\SpecialistOccupationTypeRepositoryInterface;
use App\Domain\Entity\Specialist\SpecialistOccupationType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class SpecialistOccupationTypeRepository.
 *
 * @method SpecialistOccupationType|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialistOccupationType|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialistOccupationType[]    findAll()
 * @method SpecialistOccupationType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\Specialist
 */
class SpecialistOccupationTypeRepository extends ServiceEntityRepository implements SpecialistOccupationTypeRepositoryInterface
{

    /**
     * SpecialistOccupationTypeRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialistOccupationType::class);
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?SpecialistOccupationType
    {
        return $this->find($id);
    }
}
