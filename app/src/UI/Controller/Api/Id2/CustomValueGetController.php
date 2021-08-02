<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\Id2;

use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use Exception;
use App\Application\Id2\CustomValueService;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class CustomValueGetController
 * @package App\UI\Controller\Api\CustomValue
 */
class CustomValueGetController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var CustomValueService
     */
    private CustomValueService $customValueService;

    public function __construct(
        CustomValueService $customValueService
    ) {
        $this->customValueService = $customValueService;
    }

    /**
     * Get CustomValue.
     *
     * @param Request $request
     *
     * @SWG\Parameter(
     *     in="query",
     *     name="name",
     *     type="array",
     *     description="Запрошенные события",
     *     @SWG\Items(type="string")
     * ),
     *
     * @SWG\Tag(name="CustomValue", description="Get CustomValue"),
     **
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
     *                     ref=@Model(type=\App\Application\Id2\Dto\CustomValueDto::class)
     *                 )
     *             )
     *         }
     *     )
     * ),
     * @SWG\Response(response=400, description="Bad Request", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=404, description="Not found", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=500, description="Internal Server Error", @SWG\Schema(ref="#/definitions/JsonResponseException")),
     *
     * @Route("api/v1/id2_custom_property_get", methods={"GET"})
     *
     * @param Request $request
     *
     * @throws Exception
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $customValue = $this->customValueService->searchCustomValues((array)$request->get('name'));

        return ResponseFactory::createOkResponse($request, $customValue);
    }
}
