<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1;

use TeachersTrainingCenterBundle\Security\UserProvider;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Swagger\Annotations as SWG;
use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\StructureResponse;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @Rest\Route("/api/v1")
 */
class Controller extends AbstractFOSRestController
{
    /**
     * @var StructureManager
     */
    private $structureManager;

    /**
     * @var UserProvider
     */
    private $userProvider;

    public function __construct(StructureManager $structureManager, UserProvider $userProvider)
    {
        $this->structureManager = $structureManager;
        $this->userProvider = $userProvider;
    }

    /**
     * @Rest\Get("/content/get-structure")
     *
     * @SWG\Get(
     *     operationId="v1ContentGetStructure",
     *     tags={"Content"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="Success",
     *         @Model(type=StructureResponse::class)
     *     ),
     * )
     */
    public function getStructureAction(): View
    {
        $userId = $this->userProvider->getUser()->getUserId();
        return View::create(new StructureResponse($this->structureManager->getStructure($userId)));
    }
}
