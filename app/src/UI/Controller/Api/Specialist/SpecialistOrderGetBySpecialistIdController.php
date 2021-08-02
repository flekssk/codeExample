<?php

namespace App\UI\Controller\Api\Specialist;

use App\Application\RequestFormValidationHelper;
use App\Application\Specialist\SpecialistOrder\SpecialistOrderService;
use App\UI\Controller\Api\Specialist\Form\SpecialistOrderGetBySpecialistIdForm;
use App\UI\Controller\Api\Specialist\Model\SpecialistOrderGetBySpecialistIdModel;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;


/**
 * Class SpecialistOrderGetBySpecialistIdController.
 *
 * @package App\UI\Controller\Api\Specialist
 */
class SpecialistOrderGetBySpecialistIdController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var SpecialistOrderService
     */
    private SpecialistOrderService $specialistOrderService;

    /**
     * SpecialistOrderGetBySpecialistIdController constructor.
     *
     * @param SpecialistOrderService $specialistOrderService
     */
    public function __construct(
        SpecialistOrderService $specialistOrderService
    ) {
        $this->specialistOrderService = $specialistOrderService;
    }

    /**
     * @param Request $request
     *
     * @SWG\Tag(name="Specialist", description="Получение приказов специалиста."),
     *
     * @SWG\Parameter(
     *     in="query",
     *     name="id",
     *     type="integer",
     *     required=true,
     *     description="Bitrix id пользователя"
     * ),
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
     *                         ref=@Model(type=\App\Application\Specialist\SpecialistOrder\Dto\SpecialistOrderResultDto::class)
     *                     )
     *                 )
     *             )
     *         }
     *     )
     * ),
     * @SWG\Response(response=400, description="Bad Request", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=404, description="Not Found", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=500, description="Internal Server Error",
     *     @SWG\Schema(ref="#/definitions/JsonResponseException")
     * ),
     * @Route("api/v1/specialist-order_get-by-specialist-id", methods={"GET"})
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $model = new SpecialistOrderGetBySpecialistIdModel();
        $form = $this->createForm(SpecialistOrderGetBySpecialistIdForm::class, $model)
            ->submit($request->query->all());
        RequestFormValidationHelper::validate($form);
        $orders = $this->specialistOrderService->getByUserId((int) $model->id);

        return ResponseFactory::createOkResponse($request, $orders);
    }
}
