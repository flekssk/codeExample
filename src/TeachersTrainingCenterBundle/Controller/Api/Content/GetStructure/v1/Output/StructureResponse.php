<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output;

use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model\Group;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class StructureResponse
{
    /**
     * @var Group[]
     * @SWG\Property(type="array", @Model(type=Group::class))
     */
    public $data;

    public function __construct(array $structure)
    {
        $this->data = $structure;
    }
}
