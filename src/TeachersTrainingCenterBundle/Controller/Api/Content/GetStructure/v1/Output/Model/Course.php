<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class Course extends StructureItem
{
    /**
     * @var Level[]
     * @SWG\Property(type="array", @Model(type=Level::class))
     */
    public $levels = [];

    /**
     * @inheritDoc
     */
    public function getChildren(): ?array
    {
        return $this->levels;
    }
}
