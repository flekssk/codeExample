<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model;

use Swagger\Annotations as SWG;

abstract class StructureItem
{
    /**
     * @var int
     * @SWG\Property(type="integer", description="Item ID", example=1)
     */
    public $id;

    /**
     * @var string
     * @SWG\Property(type="string", description="Item readable title", example="General english")
     */
    public $title;

    /**
     * @return StructureItem[]|null
     */
    abstract public function getChildren(): ?array;
}
