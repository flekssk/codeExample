<?php

namespace App\Infrastructure\EntityRevisions\Serializer\Normalizer;

/**
 * Interface NormalizerInterface.
 *
 * @package App\Infrastructure\EntityRevisions\Serializer\Normalizer
 */
interface NormalizerInterface
{
    /**
     * @return array
     */
    public function getContext(): array;
}
