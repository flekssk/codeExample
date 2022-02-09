<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Exception;

final class InvalidStringEnumException extends \Exception
{
    /**
     * @param string[] $possibleValues
     *
     * @return static
     */
    public static function wrongEnumValue(string $value, array $possibleValues): self
    {
        return new self(
            \sprintf(
                "Wrong string enum value : '%s'! Must be one of ['%s']",
                $value,
                \implode("','", $possibleValues)
            )
        );
    }
}
