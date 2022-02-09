<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\DTO;

use JMS\Serializer\Annotation as JMS;

/**
 * Формат ошибки в ответе сервера, утвержденный командой разработки
 *
 * @see https://confluence.skyeng.ru/pages/viewpage.action?pageId=25396874
 * @see ConventionalApiResponseDTO
 */
class ConventionalResponseErrorDTO
{
    /**
     * @JMS\Type("string")
     */
    private ?string $property;

    /**
     * @JMS\Type(ConventionalResponseErrorDetailsDTO::class)
     */
    private ConventionalResponseErrorDetailsDTO $error;

    public function __construct(?string $property, ConventionalResponseErrorDetailsDTO $error)
    {
        $this->property = $property;
        $this->error = $error;
    }

    public function property(): ?string
    {
        return $this->property;
    }

    public function error(): ConventionalResponseErrorDetailsDTO
    {
        return $this->error;
    }
}
