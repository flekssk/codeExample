<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Auth\Pusher\v1;

use TeachersTrainingCenterBundle\Controller\Api\Auth\Pusher\v1\Input\AuthPusherRequest;
use TeachersTrainingCenterBundle\Controller\Api\Auth\Pusher\v1\Output\AuthPusherResponse;
use TeachersTrainingCenterBundle\Controller\ErrorResponseTrait;
use TeachersTrainingCenterBundle\Controller\ErrorResponse;
use TeachersTrainingCenterBundle\Security\UserProvider;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Pusher\Pusher;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface as ValidationErrors;

/**
 * @Rest\Route("/api/v1/auth/pusher")
 */
class Controller extends AbstractFOSRestController
{
    use ErrorResponseTrait;

    /** @var Pusher */
    private $pusher;

    /** @var PusherConfig */
    private $pusherConfig;

    /** @var UserProvider */
    private $userProvider;

    public function __construct(Pusher $pusher, PusherConfig $pusherConfig, UserProvider $userProvider)
    {
        $this->pusher = $pusher;
        $this->pusherConfig = $pusherConfig;
        $this->userProvider = $userProvider;
    }

    /**
     * @Rest\Post("")
     *
     * @SWG\Post(
     *     operationId="v1AuthPusher",
     *     tags={"Auth"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="AuthPusherRequest",
     *         in="body",
     *         required=true,
     *         @Model(type=AuthPusherRequest::class)
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Success",
     *         @Model(type=AuthPusherResponse::class)
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
    public function authPusherAction(AuthPusherRequest $request, ValidationErrors $validationErrors): View
    {
        if ($validationErrors->count()) {
            return $this->createValidationErrorResponse(Response::HTTP_BAD_REQUEST, $validationErrors);
        }

        /*
         * Add security logic here if you need: who is allowed to be in same channel. Simplified example:
         * 1. preg_match("/presence-room-(\w+)/", $request->channelName, $matches);
         * 2. $room = $this->roomRepository->findById($matches[1]);
         * 3. $this->roomAccessService->checkJoinIsAllowed($room, $this->userProvider->getUser());
         * Thus only people in same room will be able to get messages/actions.
         */

        $data = [
            // any data for further usage (see pusher docs)
            'user_id' => $this->userProvider->getUser()->getUserId(),
        ];

        try {
            $pusherResponse = $this->pusher->socket_auth($request->channelName, $request->socketId, json_encode($data));

            return View::create(new AuthPusherResponse(json_decode($pusherResponse, true)));
        } catch (\Throwable $e) {
            return $this->createErrorResponse(Response::HTTP_BAD_REQUEST, '', $e->getMessage());
        }
    }

    /**
     * @Rest\Get("/config")
     *
     * @SWG\Get(
     *     operationId="v1GetPusherConfig",
     *     tags={"Auth"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
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
    public function getPusherConfigAction(): View
    {
        return View::create($this->pusherConfig->getConfig());
    }
}
