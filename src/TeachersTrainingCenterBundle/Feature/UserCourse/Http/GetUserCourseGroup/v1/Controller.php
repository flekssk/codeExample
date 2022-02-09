<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\UserCourse\Http\GetUserCourseGroup\v1;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use TeachersTrainingCenterBundle\Feature\UserCourse\Http\GetUserCourseGroup\v1\Input\GetUserCourseGroupRequest;
use TeachersTrainingCenterBundle\Feature\UserCourse\Http\GetUserCourseGroup\v1\Output\GetUserCourseGroupResponse;
use TeachersTrainingCenterBundle\Feature\UserCourse\Service\UserCourseGroupManager;

class Controller
{
    private UserCourseGroupManager $userCourseGroupManager;

    public function __construct(UserCourseGroupManager $userCourseGroupManager)
    {
        $this->userCourseGroupManager = $userCourseGroupManager;
    }

    /**
     * @Route("/api/v1/userCourse/getUserCourseGroupWithStructure", methods={"POST"})
     *
     * @SWG\Tag(name="CourseGroup")
     * @SWG\Parameter(
     *      name="GetUserCourseGroupRequest",
     *      in="body",
     *      required=true,
     *      @Model(type=GetUserCourseGroupRequest::class),
     * )
     * @SWG\Response(
     *     response=200,
     *     description="см. CreateCourseGroupResponse",
     * @Model(type=GetUserCourseGroupResponse::class)
     * )
     */
    public function __invoke(GetUserCourseGroupRequest $request): GetUserCourseGroupResponse
    {
        return GetUserCourseGroupResponse::successfulResult($this->userCourseGroupManager->getUserCourseGroupWithStructure($request->userId));
    }
}
