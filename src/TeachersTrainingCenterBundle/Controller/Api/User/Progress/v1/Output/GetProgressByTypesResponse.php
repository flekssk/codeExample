<?php

namespace TeachersTrainingCenterBundle\Controller\Api\User\Progress\v1\Output;

use TeachersTrainingCenterBundle\Entity\Progress;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

final class GetProgressByTypesResponse
{
    /**
     * @var array
     * @SWG\Property(type="array", @Model(type=GetProgressResponse::class))
     */
    public $course = [];

    /**
     * @var array
     * @SWG\Property(type="array", @Model(type=GetProgressResponse::class))
     */
    public $lesson = [];

    /**
     * @param Progress[] $userProgress
     */
    public function __construct(array $userProgress)
    {
        foreach ($userProgress as $progress) {
            if (property_exists($this, $progress->getProgressType())) {
                $this->{$progress->getProgressType()}[] = new GetProgressResponse($progress);
            }
        }
    }
}
