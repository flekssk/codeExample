<?php

namespace App\Infrastructure\EntityRevisions\Serializer\Normalizer\EntityNormalizer;

use App\Infrastructure\EntityRevisions\Serializer\Normalizer\BaseNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * Class RegulatoryDocumentsNormalizer.
 *
 * @package App\Infrastructure\EntityRevisions\Serializer\Normalizer\EntityNormalizer
 */
class RegulatoryDocumentsNormalizer extends BaseNormalizer
{
    /**
     * RegulatoryDocumentsNormalizer constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->context = [
            AbstractNormalizer::IGNORED_ATTRIBUTES => [
                'file',
            ]
        ];
    }
}
