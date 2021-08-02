<?php

declare(strict_types=1);

namespace App\Application\SpecialistExperience\Dto;

use DateTimeImmutable;
use Swagger\Annotations as SWG;

/**
 * Class SpecialistExperienceAddDto.
 *
 * @package App\Application\SpecialistExperience\Dto
 *
 * @SWG\Definition(
 *     required={"specialistId", "company", "startDate"}
 * )
 */
class SpecialistExperienceAddDto
{
    /**
     * ID пользователя.
     *
     * @var int
     */
    public int $specialistId;

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
