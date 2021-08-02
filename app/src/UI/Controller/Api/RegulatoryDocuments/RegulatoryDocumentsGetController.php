<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\RegulatoryDocuments;

use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use Exception;
use App\Application\RegulatoryDocuments\RegulatoryDocumentsService;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class RegulatoryDocumentsAddController.
 *
 * @package App\UI\Controller\Api\RegulatoryDocuments
 */
class RegulatoryDocumentsGetController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var RegulatoryDocumentsService
     */
    private RegulatoryDocumentsService $regulatoryDocumentsService;

    public function __construct(
        RegulatoryDocumentsService $regulatoryDocumentsService
    ) {
        $this->regulatoryDocumentsService = $regulatoryDocumentsService;
    }

    /**
     * Get RegulatoryDocuments.
     *
     * @SWG\Tag(name="RegulatoryDocuments", description="Get RegulatoryDocuments"),
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
     *                         property="result",
     *                         ref=@Model(type=\App\Application\RegulatoryDocuments\Dto\RegulatoryDocumentsDto::class)
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
     * @Route("api/v1/regulatory-documents_get-list", methods={"GET"})
     *
     * @param Request $request
     *
     * @throws Exception
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $regulatoryDocuments = $this->regulatoryDocumentsService->getRegulatoryDocuments();

        return ResponseFactory::createOkResponse($request, $regulatoryDocuments);
    }
}
