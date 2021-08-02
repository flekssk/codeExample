<?php

namespace App\UI\Form\DataTransformer;

use App\Domain\Entity\ValueObject\ImageUrl;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class ImageUrlTransformer.
 *
 * @package App\UI\Form\DataTransformer
 */
class ImageUrlTransformer implements DataTransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform($value)
    {
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform($value)
    {
        return new ImageUrl($value);
    }
}
