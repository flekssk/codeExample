<?php

namespace App\UI\Controller\Api\Specialist\Dto;

use App\Domain\Entity\ValueObject\Gender;
use App\Domain\Entity\ValueObject\ImageUrl;
use App\UI\Controller\Api\Position\Dto\PositionResponseDto;
use App\UI\Controller\Api\Region\Dto\RegionResponseDto;
use App\UI\Controller\Api\SpecialistOccupationType\Dto\SpecialistOccupationTypeResponseDto;
use App\UI\Controller\Api\SpecialistWorkSchedule\Dto\SpecialistWorkScheduleDto;
use DateTimeInterface;
use Swagger\Annotations as SWG;

/**
 * Class SpecialistGetResponseDto.
 *
 * @package App\UI\Controller\Api\Specialist\Dto
 */
class SpecialistGetResponseDto
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
     * @var RegionResponseDto|null
     */
    public ?RegionResponseDto $region;

    /**
     * @var string|null
     */
    public ?string $birthDate;

    /**
     * @var string|null
     */
    public ?string $company;

    /**
     * @var string|null
     */
    public ?string $id2Position;

    /**
     * @var PositionResponseDto|null
     */
    public ?PositionResponseDto $position;

    /**
     * @var SpecialistOccupationTypeResponseDto|null
     */
    public ?SpecialistOccupationTypeResponseDto $employmentType;

    /**
     * @var SpecialistWorkScheduleDto|null
     */
    public ?SpecialistWorkScheduleDto $workSchedule;

    /**
     * @SWG\Schema(
     *     type="array",
     *     allOf={
     *         @SWG\Parameter(
     *              name="id"
     *         ),
     *     }
     * )
     *
     * @var string[]|null
     */
    public ?array $document;
}
