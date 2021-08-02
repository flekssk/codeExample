<?php

namespace App\Domain\Repository\AttestationCommissionMember;

use App\Domain\Entity\AttestationCommissionMember\AttestationCommissionMember;

/**
 * Interface AttestationCommissionMemberRepositoryInterface.
 *
 * @method AttestationCommissionMember|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttestationCommissionMember|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttestationCommissionMember[]    findAll()
 * @method AttestationCommissionMember[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\AttestationCommissionMember
 */
interface AttestationCommissionMemberRepositoryInterface
{
    /**
     * @return AttestationCommissionMember[]
     */
    public function findAllActive(): array;

    /**
     * @param AttestationCommissionMember $member
     */
    public function save(AttestationCommissionMember $member): void;

    /**
     * @param AttestationCommissionMember $member
     */
    public function delete(AttestationCommissionMember $member): void;
}
