<?php

namespace App\Application\Specialist\SpecialistOrder\Dto;

use App\Domain\Entity\Specialist\ValueObject\OrderNumber;
use App\Domain\Entity\Specialist\ValueObject\OrderType;
use App\Domain\Entity\ValueObject\PdfUrl;
use DateTimeInterface;

/**
 * Class SpecialistOrderResultDto.
 *
 * @package App\Application\Specialist\SpecialistOrder\Dto
 */
class SpecialistOrderResultDto
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $number;

    /**
     * @var string
     */
    public string $type;

    /**
     * @var string
     */
    public string $date;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $pdfUrl;
}
