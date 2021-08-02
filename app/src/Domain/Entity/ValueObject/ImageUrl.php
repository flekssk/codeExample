<?php

namespace App\Domain\Entity\ValueObject;

/**
 * Class ImageURL.
 *
 * @package App\Domain\Entity\ValueObject
 * @todo: Реализовать проверку разрешенных mime типов.
 *
 * @codeCoverageIgnore
 * @ignore Empty
 */
class ImageUrl extends Url
{
    /**
     * @inheritDoc
     */
    protected function validate(string $url): void
    {
    }
}
