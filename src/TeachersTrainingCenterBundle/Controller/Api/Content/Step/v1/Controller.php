<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Controller\Api\Content\Step\v1;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface as ValidationErrors;
use TeachersTrainingCenterBundle\Controller\Api\Content\Step\v1\Input\LoadStepRequest;
use TeachersTrainingCenterBundle\Controller\Api\Content\Step\v1\Output\LoadStepResponse;
use TeachersTrainingCenterBundle\Controller\ErrorResponse;
use TeachersTrainingCenterBundle\Controller\ErrorResponseTrait;
use TeachersTrainingCenterBundle\Security\UserProvider;

/**
 * @Rest\Route("/api/v1/content/step")
 */
class Controller extends AbstractFOSRestController
{
    use ErrorResponseTrait;

    private StepManager $stepManager;

    private UserProvider $userProvider;

    public function __construct(StepManager $stepManager, UserProvider $userProvider)
    {
        $this->stepManager = $stepManager;
        $this->userProvider = $userProvider;
    }

    /**
     * @Rest\Get("/load")
     *
     * @SWG\Get(
     *     operationId="v1ContentLoadStep",
     *     tags={"Step"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="LoadStepRequest",
     *         in="body",
     *         required=true,
     *         @Model(type=LoadStepRequest::class)
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Success",
     *         @Model(type=LoadStepResponse::class)
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
    public function loadStepAction(LoadStepRequest $request, ValidationErrors $validationErrors): View
    {
        if ($validationErrors->count()) {
            return $this->createValidationErrorResponse(Response::HTTP_BAD_REQUEST, $validationErrors);
        }

        try {
            // add security logic here if you need: who may watch student's step version
            $studentId = $request->studentId ?? $this->userProvider->getUser()->getUserId();
            $isLastRevision = $request->last === 'true';

            return View::create(
                new LoadStepResponse(
                    $this->stepManager->loadStep((int)$studentId, $request->stepUuid, $isLastRevision),
                ),
            );
        } catch (\Throwable $e) {
            return $this->createErrorResponse(Response::HTTP_BAD_REQUEST, '', $e->getMessage());
        }
    }
}
