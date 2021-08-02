<?php

namespace App\Infrastructure\VichUploaderNamer;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

/**
 * Class AttestationCommissionMemberAvatarNamer.
 *
 * @package App\Infrastructure\VichUploaderNamer
 */
class AttestationCommissionMemberAvatarNamer implements NamerInterface
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

        return "images/attestation_commission_member/avatar/{$name}";
    }
}
