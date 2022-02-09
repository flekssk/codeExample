<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Join\v1;

use TeachersTrainingCenterBundle\Controller\Api\Lesson\Join\v1\Input\LessonJoinRequest;
use TeachersTrainingCenterBundle\Controller\Api\Lesson\Join\v1\Output\LessonJoinResponse;
use TeachersTrainingCenterBundle\Controller\ErrorResponseTrait;
use TeachersTrainingCenterBundle\Controller\ErrorResponse;
use TeachersTrainingCenterBundle\Security\UserProvider;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface as ValidationErrors;

/**
 * @Rest\Route("/api/v1")
 */
class Controller extends AbstractFOSRestController
{
    use ErrorResponseTrait;

    /** @var UserProvider */
    private $userProvider;

    public function __construct(UserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /**
     * @Rest\Post("/lesson/join")
     *
     * @SWG\Post(
     *     operationId="v1LessonJoin",
     *     tags={"Lesson"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="LessonJoinRequest",
     *         in="body",
     *         required=true,
     *         @Model(type=LessonJoinRequest::class)
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Success",
     *         @Model(type=LessonJoinResponse::class)
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
     *         description="Not Found",
     *         @Model(type=ErrorResponse::class)
     *     ),
     * )
     */
    public function joinAction(
        LessonJoinRequest $request,
        ValidationErrors $validationErrors,
        LessonJoinManager $lessonJoinManager
    ): View {
        if ($validationErrors->count()) {
            return $this->createValidationErrorResponse(Response::HTTP_BAD_REQUEST, $validationErrors);
        }

        try {
            // add security logic here if you need: who may watch student's step version
            $userId = $this->userProvider->getUser()->getUserId();

            return View::create(new LessonJoinResponse($lessonJoinManager->joinLesson($userId, $request)));
        } catch (\Throwable $e) {
            return $this->createErrorResponse(Response::HTTP_BAD_REQUEST, '', $e->getMessage());
        }
    }
}
