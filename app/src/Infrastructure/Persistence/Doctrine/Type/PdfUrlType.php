<?php

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Entity\ValueObject\PdfUrl;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * Class PdfUrlType.
 *
 * @package App\Infrastructure\Persistence\Doctrine\Type
 */
class PdfUrlType extends StringType
{
    /**
     * @inheritdoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = null;

        if ($value) {
            $result = new PdfUrl($value);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'pdfUrl';
    }
}
