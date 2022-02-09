<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Http\GetCourseGroup\Api\v1;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalApiResponseDTO;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Http\GetCourseGroup\Api\v1\Input\GetCourseGroupRequest;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Http\GetCourseGroup\Api\v1\Output\GetCourseGroupResponse;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Service\CourseGroupManager;

class Controller
{
    private CourseGroupManager $courseGroupManager;

    public function __construct(CourseGroupManager $courseGroupManager)
    {
        $this->courseGroupManager = $courseGroupManager;
    }

    /**
     * @Route("/api/v1/courseGroup/get", methods={"POST"})
     *
     * @SWG\Tag(name="CourseGroup")
     * @SWG\Parameter(
     *      name="GetCourseGroupRequest",
     *      in="body",
     *      required=true,
     * @Model(type=GetCourseGroupRequest::class),
     * )
     * @SWG\Response(
     *     response=200,
     *     description="см. GetCourseGroupResponse",
     * @Model(type=GetCourseGroupResponse::class)
     * )
     */
    public function __invoke(GetCourseGroupRequest $request): ConventionalApiResponseDTO
    {
        $courseGroup = $this->courseGroupManager->findByIds($request->ids);

        return GetCourseGroupResponse::successfulResult($courseGroup);
    }
}
