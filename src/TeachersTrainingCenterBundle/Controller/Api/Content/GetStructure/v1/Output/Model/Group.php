<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class Group extends StructureItem
{
    /**
     * @var Course[]
     * @SWG\Property(type="array", @Model(type=Course::class))
     */
    public $courses = [];

    /**
     * @inheritDoc
     */
    public function getChildren(): ?array
    {
        return $this->courses;
    }
}
