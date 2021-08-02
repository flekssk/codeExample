<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\AttestationCommissionMember;

use App\Domain\Entity\AttestationCommissionMember\AttestationCommissionMember;
use App\Domain\Repository\AttestationCommissionMember\AttestationCommissionMemberRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class AttestationCommissionMemberRepository.
 *
 * @method AttestationCommissionMember|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttestationCommissionMember|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttestationCommissionMember[]    findAll()
 * @method AttestationCommissionMember[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\AttestationCommissionMember
 */
class AttestationCommissionMemberRepositoryRepository extends ServiceEntityRepository implements AttestationCommissionMemberRepositoryInterface
{
    /**
     * Class constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttestationCommissionMember::class);
    }

    /**
     * @inheritdoc
     */
    public function findAllActive(): array
    {
        return $this->findBy(['active' => true]);
    }

    /**
     * @inheritdoc
     */
    public function save(AttestationCommissionMember $member): void
    {
        $this->getEntityManager()->persist($member);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritdoc
     */
    public function delete(AttestationCommissionMember $member): void
    {
        $this->getEntityManager()->remove($member);
        $this->getEntityManager()->flush();
    }
}
