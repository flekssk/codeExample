<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Create\v1;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface as ValidationErrors;
use TeachersTrainingCenterBundle\Controller\Api\Lesson\Create\v1\Input\LessonCreateRequest;
use TeachersTrainingCenterBundle\Controller\Api\Lesson\Create\v1\Output\LessonCreateResponse;
use TeachersTrainingCenterBundle\Controller\ErrorResponse;
use TeachersTrainingCenterBundle\Controller\ErrorResponseTrait;
use TeachersTrainingCenterBundle\Security\UserProvider;

/**
 * @Rest\Route("/api/v1")
 */
class Controller extends AbstractFOSRestController
{
    use ErrorResponseTrait;

    private UserProvider $userProvider;

    public function __construct(UserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /**
     * @Rest\Post("/lesson/create")
     *
     * @SWG\Post(
     *     operationId="v1LessonCreate",
     *     tags={"Lesson"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="LessonCreateRequest",
     *         in="body",
     *         required=true,
     *         @Model(type=LessonCreateRequest::class)
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Success",
     *         @Model(type=LessonCreateResponse::class)
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
    public function createAction(
        LessonCreateRequest $request,
        ValidationErrors $validationErrors,
        LessonCreateManager $lessonCreateManager
    ): View {
        if ($validationErrors->count()) {
            return $this->createValidationErrorResponse(Response::HTTP_BAD_REQUEST, $validationErrors);
        }

        try {
            $userId = $this->userProvider->getUser()->getUserId();

            return View::create(
                new LessonCreateResponse($lessonCreateManager->createLesson((int)$request->lessonId, $userId)),
            );
        } catch (\Throwable $e) {
            return $this->createErrorResponse(Response::HTTP_BAD_REQUEST, '', $e->getMessage());
        }
    }
}
