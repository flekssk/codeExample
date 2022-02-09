<?php

namespace TeachersTrainingCenterBundle\Controller\Api\User\TeacherStudent\v1;

use TeachersTrainingCenterBundle\Controller\Api\User\TeacherStudent\v1\Output\GetTeacherStudentsResponse;
use TeachersTrainingCenterBundle\Controller\ErrorResponseTrait;
use TeachersTrainingCenterBundle\Security\UserProvider;
use TeachersTrainingCenterBundle\Service\TeacherStudentService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/api/v1/user/teacher-student")
 */
class Controller extends AbstractFOSRestController
{
    use ErrorResponseTrait;

    /** @var TeacherStudentService */
    private $teacherStudentService;

    /** @var UserProvider */
    private $userProvider;

    public function __construct(TeacherStudentService $teacherStudentService, UserProvider $userProvider)
    {
        $this->teacherStudentService = $teacherStudentService;
        $this->userProvider = $userProvider;
    }

    /**
     * @Rest\Get("/students")
     *
     * @SWG\Get(
     *     operationId="v1UserGetTeacherStudents",
     *     tags={"GetTeacherStudents"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="Success",
     *         @Model(type=GetTeacherStudentsResponse::class)
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Bad request",
     *         @Model(type=ErrorResponse::class)
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @Model(type=ErrorResponse::class)
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Access Denied",
     *         @Model(type=ErrorResponse::class)
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Access Denied",
     *         @Model(type=ErrorResponse::class)
     *     ),
     * )
     */
    public function getTeacherStudentsAction(): View
    {
        try {
            $teacherId = $this->userProvider->getUser()->getUserId();
            $teacherStudents = $this->teacherStudentService->getTeacherStudents($teacherId);

            return View::create(new GetTeacherStudentsResponse($teacherStudents));
        } catch (\Throwable $e) {
            return $this->createErrorResponse(Response::HTTP_BAD_REQUEST, '', $e->getMessage());
        }
    }
}
