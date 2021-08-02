<?php

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Entity\Specialist\ValueObject\OrderType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * Class OrderTypeType.
 *
 * @package App\Infrastructure\Persistence\Doctrine\Type
 */
class OrderTypeType extends StringType
{
    /**
     * @inheritdoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = null;

        if ($value) {
            $result = new OrderType($value);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'orderType';
    }
}
