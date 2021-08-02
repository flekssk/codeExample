<?php

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Entity\Specialist\ValueObject\OrderNumber;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * Class OrderNumberType.
 *
 * @package App\Infrastructure\Persistence\Doctrine\Type
 */
class OrderNumberType extends StringType
{
    /**
     * @inheritdoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = null;

        if ($value) {
            $result = new OrderNumber($value);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'orderNumber';
    }
}
