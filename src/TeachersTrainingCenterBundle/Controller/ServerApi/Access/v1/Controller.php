<?php

namespace TeachersTrainingCenterBundle\Controller\ServerApi\Access\v1;

use TeachersTrainingCenterBundle\Controller\ServerApi\Access\v1\Input\StoreBlocksAuthorizationRequest;
use TeachersTrainingCenterBundle\Controller\ServerApi\Access\v1\Output\StoreBlocksAuthorizationResponse;
use TeachersTrainingCenterBundle\Controller\ErrorResponseTrait;
use TeachersTrainingCenterBundle\Controller\ErrorResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface as ValidationErrors;

/**
 * @Rest\Route("/server-api/v1/access")
 */
class Controller extends AbstractFOSRestController
{
    use ErrorResponseTrait;

    /** @var AuthorizationChecker */
    private $authorizationChecker;

    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @Rest\Post("/ttc-store-blocks/authorize")
     *
     * @SWG\Post(
     *     operationId="v1AccessStoreBlocksAuthorize",
     *     tags={"Access"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="StoreBlocksAuthorizationRequest",
     *         in="body",
     *         required=true,
     *         @Model(type=StoreBlocksAuthorizationRequest::class)
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Success",
     *         @Model(type=StoreBlocksAuthorizationResponse::class)
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
    public function authorizeAction(StoreBlocksAuthorizationRequest $request, ValidationErrors $validationErrors): View
    {
        if ($validationErrors->count()) {
            return $this->createValidationErrorResponse(Response::HTTP_BAD_REQUEST, $validationErrors);
        }

        return View::create(
            new StoreBlocksAuthorizationResponse(
                $this->authorizationChecker->authorize($request->getUser(), $request->getAction()),
            ),
        );
    }
}
