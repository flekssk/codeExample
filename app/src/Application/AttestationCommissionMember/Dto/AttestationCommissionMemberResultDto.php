<?php

namespace App\Application\AttestationCommissionMember\Dto;

/**
 * Class AttestationCommissionMemberResultDto.
 *
 * @package App\Application\AttestationCommissionMember\Dto
 */
class AttestationCommissionMemberResultDto
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $firstName;

    /**
     * @var string
     */
    public string $secondName;

    /**
     * @var string|null
     */
    public ?string $middleName;

    /**
     * @var string|null
     */
    public ?string $imageUrl;

    /**
     * @var string
     */
    public string $description;

    /**
     * @var bool
     */
    public bool $isLeader;
}
