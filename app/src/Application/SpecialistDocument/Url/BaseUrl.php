<?php

namespace App\Application\SpecialistDocument\Url;

use App\Domain\Entity\SpecialistDocument\SpecialistDocument;

/**
 * Class BaseUrl.
 */
abstract class BaseUrl
{

    /**
     * @var SpecialistDocument
     */
    protected SpecialistDocument $document;

    /**
     * Class counstructor.
     *
     * @param SpecialistDocument $document
     */
    public function __construct(SpecialistDocument $document)
    {
        $this->document = $document;
    }

    /**
     * @return string
     */
    abstract public function getValue(): string;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }
}
