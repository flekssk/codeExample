<?php

namespace TeachersTrainingCenterBundle\Controller\ServerApi\User\Progress;

use TeachersTrainingCenterBundle\Controller\ErrorResponse;
use TeachersTrainingCenterBundle\Controller\ErrorResponseTrait;
use TeachersTrainingCenterBundle\Controller\ServerApi\User\Progress\Input\PostProgressBatchRequest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface as ValidationErrors;
use Throwable;

/**
 * @Rest\Route("/server-api/v1/user/progress")
 */
class Controller extends AbstractFOSRestController
{
    use ErrorResponseTrait;

    /** @var ProgressManager */
    private $progressManager;

    public function __construct(ProgressManager $progressManager)
    {
        $this->progressManager = $progressManager;
    }

    /**
     * @Rest\Post("")
     * @SWG\Post(
     *     operationId="serverApiV1UserPostProgressBatch",
     *     tags={{"ServerApi|V1|Progress"}},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="PostProgressBatchRequest",
     *         in="body",
     *         required=true,
     *         @Model(type=PostProgressBatchRequest::class)
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
     *         description="Not found",
     *         @Model(type=ErrorResponse::class)
     *     ),
     * )
     */
    public function postProgressBatch(PostProgressBatchRequest $request, ValidationErrors $validationErrors): View
    {
        if ($validationErrors->count()) {
            return $this->createValidationErrorResponse(Response::HTTP_BAD_REQUEST, $validationErrors);
        }

        try {
            $this->progressManager->updateProgressFromRequest($request);

            return $this->view(null, Response::HTTP_OK);
        } catch (Throwable $e) {
            return $this->createErrorResponse(Response::HTTP_BAD_REQUEST, '', $e->getMessage());
        }
    }
}
