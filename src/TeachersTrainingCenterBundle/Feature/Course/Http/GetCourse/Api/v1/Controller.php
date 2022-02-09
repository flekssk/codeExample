<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\Course\Http\GetCourse\Api\v1;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use TeachersTrainingCenterBundle\Feature\Course\Http\GetCourse\Api\v1\Input\GetCourseRequest;
use TeachersTrainingCenterBundle\Feature\Course\Http\GetCourse\Api\v1\Output\GetCourseResponse;
use TeachersTrainingCenterBundle\Feature\Course\Service\CourseManager;

class Controller
{
    private CourseManager $courseManager;

    public function __construct(CourseManager $courseManager)
    {
        $this->courseManager = $courseManager;
    }

    /**
     * @Route("/api/v1/course/get", methods={"POST"})
     *
     * @SWG\Tag(name="Course")
     * @SWG\Parameter(
     *      name="GetCourseRequest",
     *      in="body",
     *      required=true,
     * @Model(type=GetCourseRequest::class),
     * )
     * @SWG\Response(
     *     response=200,
     *     description="см. GetCourseResponse",
     * @Model(type=GetCourseResponse::class)
     * )
     */
    public function __invoke(GetCourseRequest $request): GetCourseResponse
    {
        $course = $this->courseManager->findByIds($request->ids);

        return GetCourseResponse::successfulResult($course);
    }
}
