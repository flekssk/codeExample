<?php

namespace App\Application\SpecialistDocument\Dto;

/**
 * Class SpecialistDocumentResultDto.
 */
class SpecialistDocumentResultDto
{

    /**
     * @var int
     */
    public int $id;

    /**
     * @var int
     */
    public int $specialistId;

    /**
     * @var string
     */
    public string $number;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $disciplinesName;

    /**
     * @var string|null
     */
    public ?string $previewUrl;

    /**
     * @var string
     */
    public string $imageUrl;

    /**
     * @var string
     */
    public string $pdfUrl;
}
