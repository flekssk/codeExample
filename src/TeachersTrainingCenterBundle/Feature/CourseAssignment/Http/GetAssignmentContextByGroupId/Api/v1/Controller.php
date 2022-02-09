<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\GetAssignmentContextByGroupId\Api\v1;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\GetAssignmentContextByGroupId\Api\v1\Input\GetAssignmentContextByGroupIdRequest;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\GetAssignmentContextByGroupId\Api\v1\Output\GetAssignmentContextByGroupIdResponse;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Service\Manager\CourseAssignmentManager;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\ValueObject\CourseGroupId;

class Controller
{
    private CourseAssignmentManager $courseAssignmentManager;

    public function __construct(CourseAssignmentManager $courseAssignmentManager)
    {
        $this->courseAssignmentManager = $courseAssignmentManager;
    }

    /**
     * @Route("/api/v1/courseGroupAssignmentContext/getByCourseGroupId", methods={"POST"})
     *
     * @SWG\Tag(name="CourseAssignment")
     * @SWG\Parameter(
     *      name="GetCourseRequest",
     *      in="body",
     *      required=true,
     * @Model(type=GetAssignmentContextByGroupIdRequest::class),
     * )
     * @SWG\Response(
     *     response=200,
     *     description="см. GetCourseResponse",
     * @Model(type=GetAssignmentContextByGroupIdResponse::class)
     * )
     */

    public function __invoke(GetAssignmentContextByGroupIdRequest $request): GetAssignmentContextByGroupIdResponse
    {
        return GetAssignmentContextByGroupIdResponse::successfulResult(
            $this->courseAssignmentManager->getByCourseGroupId(new CourseGroupId($request->courseGroupId))
        );
    }
}
