<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\ReferenceInformation;

use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use Exception;
use App\Application\ReferenceInformation\ReferenceInformationService;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class ReferenceInformationAddController.
 *
 * @package App\UI\Controller\Api\ReferenceInformation
 */
class ReferenceInformationGetController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var ReferenceInformationService
     */
    private ReferenceInformationService $regulatoryDocumentsService;

    public function __construct(
        ReferenceInformationService $regulatoryDocumentsService
    ) {
        $this->regulatoryDocumentsService = $regulatoryDocumentsService;
    }

    /**
     * Get ReferenceInformation.
     *
     * @SWG\Tag(name="ReferenceInformation", description="Get ReferenceInformation"),
     *
     * @SWG\Response(
     *     response=200,
     *     description="OK",
     *     @SWG\Schema(
     *         type="object",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/JsonResponseOk"),
     *             @SWG\Schema(
     *                 @SWG\Property(
     *                     property="data",
     *                     @SWG\Property(
     *                        property="result",
     *                        ref=@Model(type=\App\Application\ReferenceInformation\Dto\ReferenceInformationDto::class)
     *                     )
     *                 )
     *             )
     *         }
     *     )
     * ),
     * @SWG\Response(response=400, description="Bad Request", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=404, description="Not found", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=500, description="Internal Server Error", @SWG\Schema(ref="#/definitions/JsonResponseException")),
     *
     * @Route("api/v1/reference-information_get-list", methods={"GET"})
     *
     * @param Request $request
     *
     * @throws Exception
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $referenceInformation = $this->regulatoryDocumentsService->getReferenceInformation();

        return ResponseFactory::createOkResponse($request, $referenceInformation);
    }
}
