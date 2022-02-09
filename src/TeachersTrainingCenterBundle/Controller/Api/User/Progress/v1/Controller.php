<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Controller\Api\User\Progress\v1;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface as ValidationErrors;
use TeachersTrainingCenterBundle\Controller\Api\User\Progress\v1\Input\GetProgressRequest;
use TeachersTrainingCenterBundle\Controller\Api\User\Progress\v1\Input\PostProgressRequest;
use TeachersTrainingCenterBundle\Controller\Api\User\Progress\v1\Output\GetProgressByTypesResponse;
use TeachersTrainingCenterBundle\Controller\ErrorResponse;
use TeachersTrainingCenterBundle\Controller\ErrorResponseTrait;
use TeachersTrainingCenterBundle\Security\UserProvider;

/**
 * @Rest\Route("/api/v1/user/progress")
 */
class Controller extends AbstractFOSRestController
{
    use ErrorResponseTrait;

    private ProgressManager $progressManager;

    private UserProvider $userProvider;

    public function __construct(ProgressManager $progressManager, UserProvider $userProvider)
    {
        $this->progressManager = $progressManager;
        $this->userProvider = $userProvider;
    }

    /**
     * @Rest\Get("")
     *
     * @SWG\Get(
     *     operationId="v1UserGetProgress",
     *     tags={"Progress"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *
     *     @SWG\Parameter(
     *         name="GetProgressRequest",
     *         in="body",
     *         required=true,
     *         @Model(type=GetProgressRequest::class)
     *     ),
     *
     *     @SWG\Response(
     *         response="200",
     *         description="Success",
     *         @Model(type=GetProgressByTypesResponse::class)
     *     ),
     *
     *     @SWG\Response(
     *         response="400",
     *         description="Bad request",
     *         @Model(type=ErrorResponse::class)
     *     ),
     *
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @Model(type=ErrorResponse::class)
     *     ),
     *
     *     @SWG\Response(
     *         response="403",
     *         description="Access Denied",
     *         @Model(type=ErrorResponse::class)
     *     ),
     *
     *     @SWG\Response(
     *         response="404",
     *         description="Access Denied",
     *         @Model(type=ErrorResponse::class)
     *     ),
     * )
     *
     * @phpcsSuppress SlevomatCodingStandard.Whitespaces.DuplicateSpaces.DuplicateSpaces
     */
    public function getProgressAction(GetProgressRequest $request, ValidationErrors $validationErrors): View
    {
        if ($validationErrors->count()) {
            return $this->createValidationErrorResponse(Response::HTTP_BAD_REQUEST, $validationErrors);
        }

        try {
            $progressUserId = $request->getUserId() ?? $this->userProvider->getUser()->getUserId();
            $userProgress = $this->progressManager->getForCourseAndLessonByUserId((int)$progressUserId);

            return View::create(new GetProgressByTypesResponse($userProgress));
        } catch (\Throwable $e) {
            return $this->createErrorResponse(Response::HTTP_BAD_REQUEST, '', $e->getMessage());
        }
    }

    /**
     * @Rest\Post("/save")
     *
     * @SWG\Post(
     *     operationId="v1UserPostProgress",
     *     tags={"Progress"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="PostProgressRequest",
     *         in="body",
     *         required=true,
     *         @Model(type=PostProgressRequest::class)
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Success"
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
    public function postProgressAction(PostProgressRequest $request, ValidationErrors $validationErrors): View
    {
        if ($validationErrors->count()) {
            return $this->createValidationErrorResponse(Response::HTTP_BAD_REQUEST, $validationErrors);
        }

        try {
            $progressUserId = $request->getUserId() ?? $this->userProvider->getUser()->getUserId();
            // add security access and race condition checks if you need this method in production
            $this->progressManager->updateProgressFromRequest($request, $progressUserId);

            return View::create();
        } catch (\Throwable $e) {
            return $this->createErrorResponse(Response::HTTP_BAD_REQUEST, '', $e->getMessage());
        }
    }
}
