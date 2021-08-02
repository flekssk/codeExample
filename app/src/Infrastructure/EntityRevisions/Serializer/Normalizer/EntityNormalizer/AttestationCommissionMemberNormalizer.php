<?php

namespace App\Infrastructure\EntityRevisions\Serializer\Normalizer\EntityNormalizer;

use App\Infrastructure\EntityRevisions\Serializer\Normalizer\BaseNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * Class AttestationCommissionMemberNormalizer.
 *
 * @package App\Infrastructure\EntityRevisions\Serializer\Normalizer\EntityNormalizer
 */
class AttestationCommissionMemberNormalizer extends BaseNormalizer
{
    /**
     * AttestationCommissionMemberNormalizer constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->context = [
            AbstractNormalizer::IGNORED_ATTRIBUTES => [
                'imageFile',
            ]
        ];
    }
}
