<?php

namespace App\UI\Controller\Api\Region;

use App\Application\Region\RegionService;
use App\Application\RequestFormValidationHelper;
use App\UI\Controller\Api\Region\Form\RegionSearchForm;
use App\UI\Controller\Api\Region\Model\RegionSearchModel;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model as Model;
use Symfony\Component\Routing\Annotation\Route as Route;
use App\Application\Region\Dto\RegionResultDto;
use App\Application\Exception\ValidationException;

/**
 * Class RegionSearchController.
 */
class RegionSearchController extends AbstractController implements AccessibleFromPublicInterface
{

    /**
     * Значение записей по умолчанию.
     */
    const DEFAULT_COUNT = 10;

    /**
     * @var RegionService
     */
    private RegionService $regionService;

    /**
     * RegionSearchController constructor.
     *
     * @param RegionService $regionService
     */
    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
    }

    /**
     * Поиск регионов по названию.
     *
     * @SWG\Tag(name="Region", description="Поиск регионов по названию"),
     * @SWG\Parameter(
     *     in="query",
     *     required=false,
     *     name="name",
     *     type="string",
     *     description="Регион"
     * )
     * @SWG\Parameter(
     *     in="query",
     *     required=false,
     *     name="count",
     *     type="integer",
     *     description="Кол-во записей"
     * )
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
     *                         ref=@Model(type=\App\Application\Region\Dto\RegionResultDto::class)
     *                     )
     *                 )
     *             )
     *         }
     *     )
     * )
     * @SWG\Response(response=400, description="Bad Request", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=500, description="Internal Server Error",
     *     @SWG\Schema(ref="#/definitions/JsonResponseException")),
     *
     * @Route("/api/v1/region_search", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $model = new RegionSearchModel();
        $form = $this->createForm(RegionSearchForm::class, $model)
            ->submit($request->query->all());
        RequestFormValidationHelper::validate($form);

        $name = (string) trim($request->get("name"));
        $count = intval($request->get("count", self::DEFAULT_COUNT));
        $result = $this->regionService->search($name, $count);

        return ResponseFactory::createOkResponse($request, $result);
    }
}
