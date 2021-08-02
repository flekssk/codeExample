<?php

namespace App\Infrastructure\EntityRevisions\Serializer\Normalizer;

use App\Infrastructure\EntityRevisions\Helper\FormatterTrait;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * Class BaseNormalizer.
 *
 * @package App\Infrastructure\EntityRevisions\Serializer\Normalizer
 */
class BaseNormalizer implements NormalizerInterface
{
    use FormatterTrait;

    /**
     * @var array
     */
    protected array $context;

    /**
     * DefaultNormalizer constructor.
     */
    public function __construct()
    {
        $this->context = [
            AbstractNormalizer::CALLBACKS => [
                'createdAt' => [$this, 'dateTimeFormatterCallback'],
                'updatedAt' => [$this, 'dateTimeFormatterCallback'],
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
