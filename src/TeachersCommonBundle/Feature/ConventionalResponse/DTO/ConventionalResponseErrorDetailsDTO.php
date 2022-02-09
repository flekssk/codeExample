<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\DTO;

use JMS\Serializer\Annotation as JMS;

class ConventionalResponseErrorDetailsDTO
{
    public const CODE_INTERNAL_ERROR = 'internal_error';
    public const CODE_REQUIRED = 'required';
    public const CODE_NOT_VALID = 'not_valid';
    public const CODE_DOMAIN_ERROR = 'domain_error';
    public const CODE_NOT_FOUND = 'not_found';
    public const CODE_CONCURRENT_ACCESS = 'concurrent_access';

    /**
     * @JMS\Type("string")
     */
    private string $message;

    /**
     * @JMS\Type("string")
     */
    private ?string $code;

    private ?\stdClass $extra = null;

    public function __construct(string $message, ?string $code = null, ?\stdClass $extra = null)
    {
        $this->message = $message;
        $this->code = $code;
        $this->extra = $extra;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function code(): ?string
    {
        return $this->code;
    }

    public function extra(): ?\stdClass
    {
        return $this->extra;
    }
}
