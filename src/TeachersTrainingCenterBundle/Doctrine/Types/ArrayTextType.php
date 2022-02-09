<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Doctrine\Types;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class ArrayTextType extends Type
{
    public const TYPE = 'text[]';

    public function getName(): string
    {
        return self::TYPE;
    }

    /**
     * {@inheritDoc}
     *
     * @throws Exception
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getDoctrineTypeMapping(self::TYPE);
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint.DisallowedMixedTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return convertToPostgresArray($value);
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint.DisallowedMixedTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return convertFromPostgresArray($value);
    }
}
