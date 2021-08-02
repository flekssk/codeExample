<?php

namespace App\UI\Controller\Api\Position;

use App\Application\Position\PositionService;
use App\Application\RequestFormValidationHelper;
use App\UI\Controller\Api\Position\Form\PositionSearchForm;
use App\UI\Controller\Api\Position\Model\PositionSearchModel;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model as Model;
use Symfony\Component\Routing\Annotation\Route as Route;
use App\Application\Position\Dto\PositionResultDto;

/**
 * Class PositionSearchController.
 */
class PositionSearchController extends AbstractController implements AccessibleFromPublicInterface
{

    /**
     * @var PositionService
     */
    private PositionService $positionService;

    /**
     * PositionSearchController constructor.
     *
     * @param PositionService $positionService
     */
    public function __construct(PositionService $positionService)
    {
        $this->positionService = $positionService;
    }

    /**
     * Поиск должностей по названию.
     *
     * @SWG\Tag(name="Position", description="Поиск должностей по названию"),
     * @SWG\Parameter(
     *     in="query",
     *     required=false,
     *     name="name",
     *     type="string",
     *     description="Должность"
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
     *                         ref=@Model(type=\App\Application\Position\Dto\PositionResultDto::class)
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
     * @Route("/api/v1/position_search", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $model = new PositionSearchModel();
        $form = $this->createForm(PositionSearchForm::class, $model)
            ->submit($request->query->all());
        RequestFormValidationHelper::validate($form);

        $name = (string) $request->get("name");
        $count = (int) $request->get("count");
        $result = $this->positionService->search($name, $count);

        return ResponseFactory::createOkResponse($request, $result);
    }
}
