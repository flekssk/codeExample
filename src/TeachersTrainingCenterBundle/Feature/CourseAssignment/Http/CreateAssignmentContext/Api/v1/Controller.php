<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\CreateAssignmentContext\Api\v1;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\CreateAssignmentContext\Api\v1\Input\CreateAssignmentContextRequest;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\CreateAssignmentContext\Api\v1\Output\CreateAssignmentContextResponse;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentContextCreateDTO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentRulesCreateDTO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Service\Manager\CourseAssignmentManager;

class Controller
{
    private CourseAssignmentManager $courseAssignmentManager;

    public function __construct(CourseAssignmentManager $courseAssignmentManager)
    {
        $this->courseAssignmentManager = $courseAssignmentManager;
    }

    /**
     * @Route("/api/v1/courseGroupAssignmentContext/create", methods={"POST"})
     *
     * @SWG\Tag(name="CourseAssignment")
     * @SWG\Parameter(
     *      name="GetCourseRequest",
     *      in="body",
     *      required=true,
     * @Model(type=CreateAssignmentContextRequest::class),
     * )
     * @SWG\Response(
     *     response=200,
     *     description="см. GetCourseResponse",
     * @Model(type=CreateAssignmentContextResponse::class)
     * )
     */

    public function __invoke(CreateAssignmentContextRequest $request): CreateAssignmentContextResponse
    {
        $createDto = new CourseAssignmentContextCreateDTO(
            $request->courseGroupId,
            new CourseAssignmentRulesCreateDTO(
                $request->rules->rules
            ),
            $request->deadlineInDays
        );

        return CreateAssignmentContextResponse::successfulResult(
            $this->courseAssignmentManager->createContext($createDto)
        );
    }
}
