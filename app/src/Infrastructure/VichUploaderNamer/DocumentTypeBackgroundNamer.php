<?php

namespace App\Infrastructure\VichUploaderNamer;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

/**
 * Class DocumentTypeBackgroundNamer.
 *
 * @package App\Infrastructure\VichUploaderNamer
 */
class DocumentTypeBackgroundNamer implements NamerInterface
{
    /**
     * @inheritDoc
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UndefinedMethod
     */
    public function name($object, PropertyMapping $mapping): string
    {
        $file = $mapping->getFile($object);
        $name = $file->getClientOriginalName();

        return "images/document_type/background/{$name}";
    }
}
