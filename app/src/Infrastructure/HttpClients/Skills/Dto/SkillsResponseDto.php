<?php

namespace App\Infrastructure\HttpClients\Skills\Dto;

/**
 * Class SkillsResponseDto.
 *
 * @package App\Infrastructure\HttpClients\Skills\Dto
 */
class SkillsResponseDto
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $macroSkillId;

    /**
     * @var string
     */
    public string $macroSkillName;

    /**
     * @var string
     */
    public string $macroTypeId;

    /**
     * @var string
     */
    public string $macroTypeName;

    /**
     * @var string
     */
    public string $reestrId;

    /**
     * @var string
     */
    public string $reestrName;
}
