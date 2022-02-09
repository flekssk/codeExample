<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Http\GetCourseGroupList\Api\v1;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalApiResponseDTO;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Http\GetCourseGroupList\Api\v1\Input\GetCourseGroupListRequest;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Http\GetCourseGroupList\Api\v1\Output\GetCourseGroupListResponse;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Service\CourseGroupManager;

class Controller
{
    private CourseGroupManager $courseGroupManager;

    public function __construct(CourseGroupManager $courseGroupManager)
    {
        $this->courseGroupManager = $courseGroupManager;
    }

    /**
     * @Route("/api/v1/courseGroup/list", methods={"POST"})
     *
     * @SWG\Tag(name="CourseGroup")
     * @SWG\Parameter(
     *      name="GetCourseGroupRequest",
     *      in="body",
     *      required=true,
     * @Model(type=GetCourseGroupListRequest::class),
     * )
     * @SWG\Response(
     *     response=200,
     *     description="см. GetCourseGroupListResponse",
     * @Model(type=GetCourseGroupListResponse::class)
     * )
     */
    public function __invoke(GetCourseGroupListRequest $request): ConventionalApiResponseDTO
    {
        $orderBy = null;

        if (!is_null($request->orderBy) && !is_null($request->orderDirection)) {
            $orderBy = [
                $request->orderBy => $request->orderDirection,
            ];
        }

        return GetCourseGroupListResponse::successfulResult(
            $this->courseGroupManager->findAll($orderBy)
        );
    }
}
