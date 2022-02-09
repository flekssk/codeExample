<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\Exception;

// phpcs:disable SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint.DisallowedMixedTypeHint

class TeachersCommonException extends \Exception
{
    /**
     * @var mixed|null
     */
    private $context;

    /**
     * @param mixed|null $context
     */
    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null, $context = null)
    {
        parent::__construct($message, $code, $previous);

        $this->context = $context;
    }

    /**
     * @return mixed|null
     */
    public function getContext()
    {
        return $this->context;
    }
}
