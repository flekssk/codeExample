<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model;

use Swagger\Annotations as SWG;

class Lesson extends StructureItem
{
    /**
     * @var string
     * @SWG\Property(type="string", description="Human-readable lesson description", example="An awesome lesson")
     */
    public $description;

    /**
     * @var string
     * @SWG\Property(type="string", description="lesson section", example="Section 1")
     */
    public $section;

    /**
     * @var int
     * @SWG\Property(type="int", description="steps count for lesson", example="10")
     */
    public $stepsCount;

    /**
     * @var int
     * @SWG\Property(type="int", description="steps time for lesson", example="30")
     */
    public $stepsTimeInMinutes;

    /**
     * @inheritDoc
     */
    public function getChildren(): ?array
    {
        return null;
    }
}
