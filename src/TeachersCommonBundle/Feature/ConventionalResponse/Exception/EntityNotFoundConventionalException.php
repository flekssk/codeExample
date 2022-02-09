<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\Exception;

use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalResponseErrorDetailsDTO;

class EntityNotFoundConventionalException extends \Exception implements ConventionalResponseExceptionInterface
{
    private ?string $property = null;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    public function __construct($id = null, ?string $entityName = null, ?string $customMessage = null)
    {
        $message = $customMessage ?? \sprintf(
            '%s %s not found.',
            $entityName ? \ucfirst($entityName) : 'Entity',
            $id ? sprintf('with id %s', $id) : ''
        );

        $this->property = \str_replace(' ', '_', $entityName);

        parent::__construct($message);
    }

    public function getConventionalCode(): string
    {
        return ConventionalResponseErrorDetailsDTO::CODE_NOT_FOUND;
    }

    public function getProperty(): ?string
    {
        return $this->property;
    }

    public function getExtra(): ?\stdClass
    {
        return null;
    }
}
