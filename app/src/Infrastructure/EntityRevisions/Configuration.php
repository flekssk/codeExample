<?php

namespace App\Infrastructure\EntityRevisions;

/**
 * Class Configuration.
 *
 * @package App\Infrastructure\EntityRevisions
 */
class Configuration
{
    /**
     * @var string
     */
    private string $baseNormalizer;

    /**
     * @var array
     */
    private array $entityNormalizers;

    /**
     * Configuration constructor.
     *
     * @param string $baseNormalizer
     * @param array $entityNormalizers
     */
    public function __construct(
        string $baseNormalizer,
        array $entityNormalizers
    ) {
        $this->baseNormalizer = $baseNormalizer;
        $this->entityNormalizers = $entityNormalizers;
    }

    /**
     * @return string
     */
    public function getBaseNormalizer(): string
    {
        return $this->baseNormalizer;
    }

    /**
     * @return array
     */
    public function getEntityNormalizers(): array
    {
        return $this->entityNormalizers;
    }
}
