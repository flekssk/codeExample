<?php

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Entity\Specialist\ValueObject\OrderNumber;
use App\Domain\Entity\SpecialistDocument\ValueObject\DocumentNumber;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * Class DocumentNumberType.
 *
 * @package App\Infrastructure\Persistence\Doctrine\Type
 */
class DocumentNumberType extends StringType
{
    /**
     * @inheritdoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = null;

        if ($value) {
            $result = new DocumentNumber($value);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'documentNumber';
    }
}
