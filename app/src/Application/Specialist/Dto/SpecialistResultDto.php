<?php

declare(strict_types=1);

namespace App\Application\Specialist\Dto;

use App\Application\Position\Dto\PositionResultDto;
use App\Application\Region\Dto\RegionResultDto;
use App\Application\Specialist\SpecialistOccupationType\Dto\SpecialistOccupationTypeResultDto;
use App\Application\SpecialistDocument\Dto\SpecialistDocumentShortDto;
use App\Application\SpecialistWorkSchedule\Dto\SpecialistWorkScheduleResultDto;
use App\Domain\Entity\ValueObject\Gender;
use App\Domain\Entity\ValueObject\ImageUrl;

/**
 * Class SpecialistResultDto.
 *
 * @package App\Application\Specialist\Dto
 */
class SpecialistResultDto
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string|null
     */
    public ?string $firstName;

    /**
     * @var string|null
     */
    public ?string $secondName;

    /**
     * @var string|null
     */
    public ?string $middleName;

    /**
     * @var string|null
     */
    public ?string $company;

    /**
     * @var string|null
     */
    public ?string $region;

    /**
     * @var SpecialistDocumentShortDto|null
     */
    public ?SpecialistDocumentShortDto $document;

    /**
     * @var string|null
     */
    public ?string $id2Position = '';

    /**
     * @var int
     */
    public int $status;

    /**
     * @var string|null
     */
    public ?string $imageUrl;

    /**
     * @var Gender|null
     */
    public ?Gender $gender;

    /**
     * @var string|null
     */
    public ?string $birthDate;

    /**
     * @var SpecialistWorkScheduleResultDto|null
     */
    public ?SpecialistWorkScheduleResultDto $workSchedule;

    /**
     * @var SpecialistOccupationTypeResultDto|null
     */
    public ?SpecialistOccupationTypeResultDto $employmentType;

    /**
     * @var int
     */
    public int $viewCount;
}
