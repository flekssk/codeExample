<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Http\UpdateCourseGroup\Api\v1;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalApiResponseDTO;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Http\UpdateCourseGroup\Api\v1\Input\UpdateCourseGroupRequest;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Http\UpdateCourseGroup\Api\v1\Output\UpdateCourseGroupResponse;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO\CourseGroupUpdateDTO;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Service\CourseGroupManager;

class Controller
{
    private CourseGroupManager $courseGroupManager;

    public function __construct(CourseGroupManager $courseGroupManager)
    {
        $this->courseGroupManager = $courseGroupManager;
    }

    /**
     * @Route("/api/v1/courseGroup/update", methods={"POST"})
     *
     * @SWG\Tag(name="CourseGroup")
     * @SWG\Parameter(
     *      name="GetCourseRequest",
     *      in="body",
     *      required=true,
     *      @Model(type=UpdateCourseGroupRequest::class),
     * )
     * @SWG\Response(
     *     response=200,
     *     description="см. CreateCourseGroupResponse",
     * @Model(type=UpdateCourseGroupResponse::class)
     * )
     */
    public function __invoke(UpdateCourseGroupRequest $request): ConventionalApiResponseDTO
    {
        $dto = new CourseGroupUpdateDTO($request->id, $request->title, $request->courses, $request->description);

        $courseGroup = $this->courseGroupManager->update($dto);

        return UpdateCourseGroupResponse::successfulResult($courseGroup);
    }
}
