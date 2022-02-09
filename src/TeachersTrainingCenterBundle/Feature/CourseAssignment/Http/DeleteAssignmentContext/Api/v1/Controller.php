<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\DeleteAssignmentContext\Api\v1;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\DeleteAssignmentContext\Api\v1\Input\DeleteAssignmentContextRequest;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\DeleteAssignmentContext\Api\v1\Output\DeleteAssignmentContextResponse;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Service\Manager\CourseAssignmentManager;

class Controller
{
    private CourseAssignmentManager $courseAssignmentManager;

    public function __construct(CourseAssignmentManager $courseAssignmentManager)
    {
        $this->courseAssignmentManager = $courseAssignmentManager;
    }

    /**
     * @Route("/api/v1/courseGroupAssignmentContext/delete", methods={"POST"})
     *
     * @SWG\Tag(name="CourseAssignment")
     * @SWG\Parameter(
     *      name="GetCourseRequest",
     *      in="body",
     *      required=true,
     * @Model(type=DeleteAssignmentContextRequest::class),
     * )
     * @SWG\Response(
     *     response=200,
     *     description="см. GetCourseResponse",
     * @Model(type=DeleteAssignmentContextResponse::class)
     * )
     */

    public function __invoke(DeleteAssignmentContextRequest $request): DeleteAssignmentContextResponse
    {
        return DeleteAssignmentContextResponse::successfulResult(
            $this->courseAssignmentManager->deleteContext($request->contextId)
        );
    }
}
