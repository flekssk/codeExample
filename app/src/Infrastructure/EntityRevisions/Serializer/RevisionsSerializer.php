<?php

namespace App\Infrastructure\EntityRevisions\Serializer;

use App\Infrastructure\EntityRevisions\Configuration;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class RevisionsSerializer.
 *
 * @package App\Infrastructure\EntityRevisions\Serializer
 */
class RevisionsSerializer
{
    /**
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * @var Configuration
     */
    private Configuration $configuration;

    /**
     * RevisionsSerializer constructor.
     *
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param string $entityClass
     */
    private function init(string $entityClass): void
    {
        $baseContext = $this->getBaseContext();
        $entityContext = $this->getEntityContext($entityClass);

        $context = array_merge_recursive($baseContext, $entityContext);

        $normalizer = new GetSetMethodNormalizer(
            null,
            null,
            null,
            null,
            null,
            $context
        );

        $encoder = new JsonEncoder(
            new JsonEncode(
                [
                    JsonEncode::OPTIONS => JSON_UNESCAPED_UNICODE
                ]
            ),
            new JsonDecode()
        );

        $this->serializer = new Serializer([$normalizer], [$encoder]);
    }

    /**
     * @param object $entity
     *
     * @return string
     */
    public function serialize(object $entity): string
    {
        $this->init(get_class($entity));
        return $this->serializer->serialize($entity, 'json');
    }

    /**
     * @return array
     */
    private function getBaseContext(): array
    {
        $baseNormalizerClass = $this->configuration->getBaseNormalizer();
        $baseNormalizer = new $baseNormalizerClass();

        return $baseNormalizer->getContext();
    }

    /**
     * @param string $entityClass
     *
     * @return array
     */
    private function getEntityContext(string $entityClass): array
    {
        $entityContext = [];
        $entityNormalizers = $this->configuration->getEntityNormalizers();
        if ($entityNormalizers && array_key_exists($entityClass, $entityNormalizers)) {
            $normalizerClass = $entityNormalizers[$entityClass];
            $entityNormalizer = new $normalizerClass();
            $entityContext = $entityNormalizer->getContext();
        }

        return $entityContext;
    }
}
