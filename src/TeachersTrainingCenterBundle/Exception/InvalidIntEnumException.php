<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Exception;

final class InvalidIntEnumException extends \Exception
{
    /**
     * @param int[] $possibleValues
     *
     * @return static
     */
    public static function wrongEnumValue(int $value, array $possibleValues): self
    {
        return new self(
            \sprintf(
                "Wrong integer enum value : '%d'! Must be one of ['%s']",
                $value,
                \implode("','", $possibleValues)
            )
        );
    }
}
