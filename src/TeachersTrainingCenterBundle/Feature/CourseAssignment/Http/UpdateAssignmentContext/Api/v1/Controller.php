<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\UpdateAssignmentContext\Api\v1;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\UpdateAssignmentContext\Api\v1\Input\UpdateAssignmentContextRequest;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\UpdateAssignmentContext\Api\v1\Output\UpdateAssignmentContextResponse;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentContextUpdateDTO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentRulesUpdateDTO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Service\Manager\CourseAssignmentManager;

class Controller
{
    private CourseAssignmentManager $courseAssignmentManager;

    public function __construct(CourseAssignmentManager $courseAssignmentManager)
    {
        $this->courseAssignmentManager = $courseAssignmentManager;
    }

    /**
     * @Route("/api/v1/courseGroupAssignmentContext/update", methods={"POST"})
     *
     * @SWG\Tag(name="CourseAssignment")
     * @SWG\Parameter(
     *      name="GetCourseRequest",
     *      in="body",
     *      required=true,
     * @Model(type=UpdateAssignmentContextRequest::class),
     * )
     * @SWG\Response(
     *     response=200,
     *     description="см. GetCourseResponse",
     * @Model(type=UpdateAssignmentContextResponse::class)
     * )
     */

    public function __invoke(UpdateAssignmentContextRequest $request): UpdateAssignmentContextResponse
    {
        $updateDto = new CourseAssignmentContextUpdateDTO(
            $request->id,
            $request->courseGroupId,
            new CourseAssignmentRulesUpdateDTO(
                $request->rules->id,
                $request->rules->rules,
                $request->deadlineInDays
            ),
            $request->deadlineInDays
        );

        return UpdateAssignmentContextResponse::successfulResult(
            $this->courseAssignmentManager->updateContext($updateDto)
        );
    }
}
