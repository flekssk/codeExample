<?php

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Entity\ValueObject\ImageUrl;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * Class ImageURL.
 *
 * @package App\Infrastructure\Persistence\Doctrine\Type
 */
class ImageUrlType extends StringType
{
    /**
     * @inheritdoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = null;

        if ($value) {
            $result = new ImageUrl($value);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'imageUrl';
    }
}
