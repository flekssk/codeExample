<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Http\CreateCourseGroup\Api\v1;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalApiResponseDTO;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Http\CreateCourseGroup\Api\v1\Input\CreateCourseGroupRequest;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Http\CreateCourseGroup\Api\v1\Output\CreateCourseGroupResponse;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO\CourseGroupCreateDTO;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Service\CourseGroupManager;

class Controller
{
    private CourseGroupManager $courseGroupManager;

    public function __construct(CourseGroupManager $courseGroupManager)
    {
        $this->courseGroupManager = $courseGroupManager;
    }

    /**
     * @Route("/api/v1/courseGroup/create", methods={"POST"})
     *
     * @SWG\Tag(name="CourseGroup")
     * @SWG\Parameter(
     *      name="GetCourseRequest",
     *      in="body",
     *      required=true,
     *      @Model(type=CreateCourseGroupRequest::class),
     * )
     * @SWG\Response(
     *     response=200,
     *     description="см. CreateCourseGroupResponse",
     * @Model(type=CreateCourseGroupResponse::class)
     * )
     */
    public function __invoke(CreateCourseGroupRequest $request): ConventionalApiResponseDTO
    {
        $dto = new CourseGroupCreateDTO(
            $request->title,
            array_map('intval', $request->courses),
            $request->description
        );

        $courseGroup = $this->courseGroupManager->create($dto);

        return CreateCourseGroupResponse::successfulResult($courseGroup);
    }
}
