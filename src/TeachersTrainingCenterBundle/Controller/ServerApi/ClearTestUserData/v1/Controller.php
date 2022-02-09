<?php

namespace TeachersTrainingCenterBundle\Controller\ServerApi\ClearTestUserData\v1;

use TeachersTrainingCenterBundle\Controller\ServerApi\ClearTestUserData\v1\Input\ClearTestUserDataRequest;
use TeachersTrainingCenterBundle\ErrorHandling\Exceptions\EntityNotFoundException;
use TeachersTrainingCenterBundle\Service\ClearTestUserDataService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use TeachersTrainingCenterBundle\Controller\ErrorResponse;
use TeachersTrainingCenterBundle\Controller\ErrorResponseTrait;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface as ValidationErrors;

/**
 * @Rest\Route("/server-api/v1")
 */
class Controller extends AbstractFOSRestController
{
    use ErrorResponseTrait;

    /**
     * @Rest\Post("/clear-test-user-data")
     *
     * @SWG\Post(
     *     operationId="createTestUserData",
     *     tags={"Complex"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="",
     *         name="Payload",
     *         in="body",
     *         required=true,
     *         @Model(type=ClearTestUserDataRequest::class)
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Success"
     *      ),
     *     @SWG\Response(
     *         response="400",
     *         description="Bad request",
     *         @Model(type=ErrorResponse::class)
     *      ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @Model(type=ErrorResponse::class)
     *      )
     * )
     */
    public function clearTestUserDataAction(
        ClearTestUserDataRequest $request,
        ValidationErrors $validationErrors,
        ClearTestUserDataService $clearTestUserDataService
    ): View {
        if ($validationErrors->count()) {
            return $this->createValidationErrorResponse(Response::HTTP_BAD_REQUEST, $validationErrors);
        }
        try {
            $clearTestUserDataService->clearTestUserDataWithProgress($request->userId);
            return View::create(null, Response::HTTP_OK);
        } catch (EntityNotFoundException $e) {
            return $this->createErrorResponse(Response::HTTP_FORBIDDEN, '', $e->getMessage());
        }
    }
}
