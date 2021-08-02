<?php

namespace App\Application\AttestationCommissionMember;

use App\Application\AttestationCommissionMember\Assembler\AttestationCommissionMemberResultAssembler;
use App\Application\AttestationCommissionMember\Dto\AttestationCommissionMemberResultDto;
use App\Domain\Repository\AttestationCommissionMember\AttestationCommissionMemberRepositoryInterface;

/**
 * Class AttestationCommissionMemberService.
 *
 * @package App\Application\AttestationCommissionMember
 */
class AttestationCommissionMemberService
{
    /**
     * @var AttestationCommissionMemberRepositoryInterface
     */
    private AttestationCommissionMemberRepositoryInterface $repository;

    /**
     * @var AttestationCommissionMemberResultAssembler
     */
    private AttestationCommissionMemberResultAssembler $assembler;

    /**
     * AttestationCommissionMemberService constructor.
     *
     * @param AttestationCommissionMemberRepositoryInterface $repository
     * @param AttestationCommissionMemberResultAssembler $assembler
     */
    public function __construct(
        AttestationCommissionMemberRepositoryInterface $repository,
        AttestationCommissionMemberResultAssembler $assembler
    ) {
        $this->repository = $repository;
        $this->assembler = $assembler;
    }

    /**
     * @return AttestationCommissionMemberResultDto[]|array
     */
    public function getAll(): array
    {
        $members = $this->repository->findAllActive();

        $result = [];
        foreach ($members as $member) {
            $result[] = $this->assembler->assemble($member);
        }

        return $result;
    }
}
