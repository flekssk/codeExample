<?php

namespace App\Infrastructure\EntityRevisions\Serializer\Normalizer\EntityNormalizer;

use App\Infrastructure\EntityRevisions\Serializer\Normalizer\BaseNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * Class DocumentTypeNormalizer.
 *
 * @package App\Infrastructure\EntityRevisions\Serializer\Normalizer\EntityNormalizer
 */
class DocumentTypeNormalizer extends BaseNormalizer
{
    /**
     * DocumentTypeNormalizer constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->context = [
            AbstractNormalizer::CALLBACKS => [
                'year' => [$this, 'dateTimeFormatterCallback'],
            ],
            AbstractNormalizer::IGNORED_ATTRIBUTES => [
                'imagePreviewFile',
                'imageBackgroundFile',
            ]
        ];
    }
}
