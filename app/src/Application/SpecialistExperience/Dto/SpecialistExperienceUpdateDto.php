<?php

declare(strict_types=1);

namespace App\Application\SpecialistExperience\Dto;

use DateTimeImmutable;
use Swagger\Annotations as SWG;

/**
 * Class SpecialistExperienceUpdateDto.
 *
 * @package App\Application\SpecialistExperience\Dto
 *
 * @SWG\Definition(
 *     required={"id", "company", "startDate"}
 * )
 */
class SpecialistExperienceUpdateDto
{
    /**
     * ID.
     *
     * @var int
     */
    public int $id;

    /**
     * Компания.
     *
     * @var string
     */
    public string $company;

    /**
     * Дата начала работы.
     *
     * @var DateTimeImmutable
     */
    public DateTimeImmutable $startDate;

    /**
     * Дата окончания работы.
     *
     * @var DateTimeImmutable|null
     */
    public ?DateTimeImmutable $endDate;
}
