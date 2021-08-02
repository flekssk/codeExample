<?php

namespace App\UI\Controller\Api\Specialist;

use App\Application\Exception\ValidationException;
use App\Application\RequestFormValidationHelper;
use App\Application\Specialist\SpecialistViewCount\SpecialistViewCount;
use App\UI\Controller\Api\Specialist\Form\SpecialistIncrementViewCountForm;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model as Model;

/**
 * Class SpecialistIncrementViewCountController.
 *
 * @package App\UI\Controller\Api\Specialist
 */
class SpecialistIncrementViewCountController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var SpecialistViewCount
     */
    private SpecialistViewCount $specialistViewCount;

    /**
     * SpecialistIncrementViewCountController constructor.
     *
     * @param SpecialistViewCount $specialistViewCount
     */
    public function __construct(
        SpecialistViewCount $specialistViewCount
    ) {
        $this->specialistViewCount = $specialistViewCount;
    }

    /**
     * @param Request $request
     *
     * @SWG\Parameter(
     *     in="body",
     *     required=true,
     *     name="id",
     *     type="integer",
     *     description="ID специалиста",
     *     @SWG\Schema(
     *         title="id",
     *         type="integer",
     *     ),
     * ),
     *
     * @SWG\Tag(name="Specialist", description="Увеличение количества просмотров карточки пользователя."),
     * @SWG\Response(
     *     response=200,
     *     description="OK"
     * ),
     * @SWG\Response(response=404, description="Not Found", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=500, description="Internal Server Error", @SWG\Schema(ref="#/definitions/JsonResponseException")),
     *
     *
     * @Route("api/v1/specialist_increment-view-count", methods={"POST"})
     *
     * @return Response
     *
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        $id = $request->get('id');

        $form = $this->createForm(SpecialistIncrementViewCountForm::class)->submit($request->request->all());
        RequestFormValidationHelper::validate($form);

        $this->specialistViewCount->increment((int) $id);

        return ResponseFactory::createOkResponse($request);
    }
}
