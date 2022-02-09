<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Wordset\v1;

use TeachersTrainingCenterBundle\Controller\Api\Lesson\Wordset\v1\Output\LessonGetWordsetResponse;
use TeachersTrainingCenterBundle\Controller\Api\Lesson\Wordset\v1\Input\CreateWordsetRequest;
use TeachersTrainingCenterBundle\Controller\ErrorResponse;
use TeachersTrainingCenterBundle\Controller\ErrorResponseTrait;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface as ValidationErrors;

/**
 * @Rest\Route("/api/v1/lesson/wordset")
 */
class Controller extends AbstractFOSRestController
{
    use ErrorResponseTrait;

    /**
     * @var WordsetManager
     */
    private $wordsetManager;

    public function __construct(WordsetManager $wordsetManager)
    {
        $this->wordsetManager = $wordsetManager;
    }

    /**
     * @Rest\Get("")
     *
     * @SWG\Get(
     *     operationId="v1LessonCreateWordset",
     *     tags={"Lesson"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="CreateWordsetRequest",
     *         in="query",
     *         required=true,
     *         type="array",
     *         @Model(type=CreateWordsetRequest::class)
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Success",
     *         @Model(type=LessonGetWordsetResponse::class)
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
    public function getWordsetAction(CreateWordsetRequest $request, ValidationErrors $validationErrors): View
    {
        if ($validationErrors->count()) {
            return $this->createValidationErrorResponse(Response::HTTP_BAD_REQUEST, $validationErrors);
        }

        try {
            $wordsetId = $this->wordsetManager->ensureWordsetId($request->getStudentId(), $request->getLessonId());

            return View::create(
                new LessonGetWordsetResponse($request->getStudentId(), $request->getLessonId(), $wordsetId),
            );
        } catch (\Throwable $e) {
            return $this->createErrorResponse(Response::HTTP_BAD_REQUEST, '', $e->getMessage());
        }
    }
}
