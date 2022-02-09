<?php

namespace TeachersTrainingCenterBundle\Symfony;

use Doctrine\DBAL\Platforms\AbstractPlatform;

class BigIntType extends \Doctrine\DBAL\Types\BigIntType
{
    public function getBindingType()
    {
        return \PDO::PARAM_INT;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value !== null ? (int) $value : null;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
