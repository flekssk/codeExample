<?php

namespace App\UI\Form\DataTransformer;

use App\Domain\Entity\ValueObject\Gender;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class GenderTransformer.
 *
 * @package App\UI\Form\DataTransformer
 */
class GenderTransformer implements DataTransformerInterface
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
        return new Gender((int) $value);
    }
}
