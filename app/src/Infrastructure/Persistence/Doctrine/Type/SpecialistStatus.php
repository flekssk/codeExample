<?php

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Entity\Specialist\ValueObject\Status;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

/**
 * Class SpecialistStatus.
 *
 * @package App\Infrastructure\Persistence\Doctrine\Type
 */
class SpecialistStatus extends IntegerType
{
    /**
     * @inheritdoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = null;

        if (is_int($value)) {
            $result = new Status($value);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'specialistStatus';
    }
}
