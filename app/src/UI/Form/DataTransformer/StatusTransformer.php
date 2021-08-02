<?php

namespace App\UI\Form\DataTransformer;

use App\Domain\Entity\Specialist\ValueObject\Status;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class StatusTransformer.
 *
 * @package App\UI\Form\DataTransformer
 */
class StatusTransformer implements DataTransformerInterface
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
        return new Status((int) $value);
    }
}
