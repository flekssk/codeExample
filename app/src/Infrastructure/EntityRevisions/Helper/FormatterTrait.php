<?php

namespace App\Infrastructure\EntityRevisions\Helper;

use DateTimeInterface;

/**
 * Trait FormatterTrait.
 *
 * @package App\Infrastructure\EntityRevisions\Helper
 */
trait FormatterTrait
{
    /**
     * Вернуть строковое значение даты.
     *
     * @param $innerObject
     * @param $outerObject
     * @param string $attributeName
     * @param string|null $format
     * @param array $context
     *
     * @return string
     */
    public function dateTimeFormatterCallback(
        $innerObject,
        $outerObject,
        string $attributeName,
        string $format = null,
        array $context = []
    ): string {
        return $innerObject instanceof DateTimeInterface ? $innerObject->format('Y-m-d H:i:s') : '';
    }
}
