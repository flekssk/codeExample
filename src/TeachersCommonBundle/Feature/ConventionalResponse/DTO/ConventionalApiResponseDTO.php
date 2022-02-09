<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\DTO;

//phpcs:disable SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
//phpcs:disable SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingTraversableTypeHintSpecification
//phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification

use JMS\Serializer\Annotation as Serializer;

/**
 * Формат ответа сервера, утвержденный командой разработки
 *
 * @see https://confluence.skyeng.ru/pages/viewpage.action?pageId=25396874
 * @psalm-immutable
 */
class ConventionalApiResponseDTO
{
    /**
     * @var string|array|object|null
     */
    public $data;

    /**
     * @var ConventionalResponseErrorDTO[]|null
     *
     * @Serializer\Type("array<TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalResponseErrorDTO>")
     */
    public ?array $errors = null;

    /**
     * @param string|array|object|null $data
     * @param ConventionalResponseErrorDTO[]|null $errors
     */
    public function __construct($data, ?array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    /**
     * @param string|array|object|null $data
     *
     * @return static
     */
    public static function successfulResult($data): self
    {
        return new static($data, null);
    }

    public static function errorResult(ConventionalResponseErrorDTO ...$errors): self
    {
        return new static(null, $errors);
    }
}
