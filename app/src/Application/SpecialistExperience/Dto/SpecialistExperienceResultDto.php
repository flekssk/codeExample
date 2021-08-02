<?php

declare(strict_types=1);

namespace App\Application\SpecialistExperience\Dto;

use Swagger\Annotations as SWG;

/**
 * Class SpecialistExperienceResultDto.
 *
 * @package \App\Application\SpecialistExperience\Dto
 *
 * @SWG\Definition()
 */
class SpecialistExperienceResultDto
{
    /**
     * ID.
     *
     * @var int
     */
    public int $id;

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
     * @var string
     */
    public string $startDate;

    /**
     * Дата окончания работы.
     *
     * @var string|null
     */
    public ?string $endDate;
}
