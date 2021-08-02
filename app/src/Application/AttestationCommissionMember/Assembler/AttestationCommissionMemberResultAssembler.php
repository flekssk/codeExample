<?php

namespace App\Application\AttestationCommissionMember\Assembler;

use App\Application\AttestationCommissionMember\Dto\AttestationCommissionMemberResultDto;
use App\Domain\Entity\AttestationCommissionMember\AttestationCommissionMember;

/**
 * Class AttestationCommissionMemberResultAssembler.
 *
 * @package App\Application\AttestationCommissionMember\Assembler
 */
class AttestationCommissionMemberResultAssembler
{
    /**
     * @param AttestationCommissionMember $member
     *
     * @return AttestationCommissionMemberResultDto
     */
    public function assemble(AttestationCommissionMember $member): AttestationCommissionMemberResultDto
    {
        $dto = new AttestationCommissionMemberResultDto();

        $dto->id = $member->getId();
        $dto->firstName = $member->getFirstName();
        $dto->secondName = $member->getSecondName();
        $dto->middleName = $member->getMiddleName();
        $dto->imageUrl = $member->getImageUrl();
        $dto->description = $member->getDescription();
        $dto->isLeader =  $member->isLeader();

        return $dto;
    }
}
