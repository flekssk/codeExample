<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Feedback\v1;

use TeachersTrainingCenterBundle\Controller\Api\Lesson\Feedback\v1\Input\SetAnswerRequest;
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
 * @Rest\Route("/api/v1/lesson/feedback")
 */
class Controller extends AbstractFOSRestController
{
    use ErrorResponseTrait;

    /** @var FeedbackManager */
    private $feedbackManager;

    /** @var UserProvider */
    private $userProvider;

    public function __construct(FeedbackManager $feedbackManager, UserProvider $userProvider)
    {
        $this->feedbackManager = $feedbackManager;
        $this->userProvider = $userProvider;
    }

    /**
     * @Rest\Post("/set-answer")
     *
     * @SWG\Post(
     *     operationId="v1LessonFeedbackSetAnswer",
     *     tags={"Lesson"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="SetAnswerRequest",
     *         in="body",
     *         required=true,
     *         @Model(type=SetAnswerRequest::class)
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
     *         description="Not Found",
     *         @Model(type=ErrorResponse::class)
     *     ),
     * )
     */
    public function setAnswerAction(SetAnswerRequest $request, ValidationErrors $validationErrors): View
    {
        if ($validationErrors->count()) {
            return $this->createValidationErrorResponse(Response::HTTP_BAD_REQUEST, $validationErrors);
        }

        try {
            $userId = $this->userProvider->getUser()->getUserId();

            $this->feedbackManager->setAnswer(
                $request->questionAlias,
                $request->periodId,
                $userId,
                $request->answerMark,
                $request->answerComment,
                $request->payload,
            );

            return View::create(['success' => true]);
        } catch (\Throwable $e) {
            return $this->createErrorResponse(Response::HTTP_BAD_REQUEST, '', $e->getMessage());
        }
    }
}
