<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class Level extends StructureItem
{
    /**
     * @var Lesson[]
     * @SWG\Property(type="array", @Model(type=Lesson::class))
     */
    public $lessons = [];

    /**
     * @inheritDoc
     */
    public function getChildren(): ?array
    {
        return $this->lessons;
    }
}
