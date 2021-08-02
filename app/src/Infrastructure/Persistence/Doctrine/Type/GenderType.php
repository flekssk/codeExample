<?php

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Entity\ValueObject\Gender;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

/**
 * Class GenderType.
 *
 * @package App\Infrastructure\Persistence\Doctrine\Type
 */
class GenderType extends IntegerType
{
    /**
     * @inheritdoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = null;

        if (is_int($value)) {
            $result = new Gender($value);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'gender';
    }
}
