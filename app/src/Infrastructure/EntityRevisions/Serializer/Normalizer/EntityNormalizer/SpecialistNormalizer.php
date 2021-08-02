<?php

namespace App\Infrastructure\EntityRevisions\Serializer\Normalizer\EntityNormalizer;

use App\Infrastructure\EntityRevisions\Serializer\Normalizer\BaseNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * Class SpecialistNormalizer.
 *
 * @package App\Infrastructure\EntityRevisions\Serializer\Normalizer\EntityNormalizer
 */
class SpecialistNormalizer extends BaseNormalizer
{
    /**
     * SpecialistNormalizer constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->context = [
            AbstractNormalizer::CALLBACKS => [
                'dateOfBirth' => [$this, 'dateTimeFormatterCallback'],
                'dateCheckAccess' => [$this, 'dateTimeFormatterCallback'],
            ],
            AbstractNormalizer::IGNORED_ATTRIBUTES => [
                'orders',
                'genderName',
                'avatarUrl',
                'avatarFile',
                'statusName',
            ]
        ];
    }
}
