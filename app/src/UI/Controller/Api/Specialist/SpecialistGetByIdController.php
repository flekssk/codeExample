<?php

namespace App\UI\Controller\Api\Specialist;

use App\Application\RequestFormValidationHelper;
use App\Application\Specialist\SpecialistGet\SpecialistGetService;
use App\UI\Controller\Api\Specialist\Assembler\SpecialistGetResponseAssemblerInterface;
use App\UI\Controller\Api\Specialist\Form\SpecialistGetByIdForm;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class SpecialistGetByIdController.
 *
 * @package App\UI\Controller\Api\Specialist
 */
class SpecialistGetByIdController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var SpecialistGetService
     */
    private SpecialistGetService $specialistGetService;

    public function __construct(
        SpecialistGetService $specialistGetService
    ) {
        $this->specialistGetService = $specialistGetService;
    }

    /**
     * @param Request $request
     *
     * @SWG\Parameter(
     *     in="query",
     *     required=true,
     *     name="id",
     *     type="integer",
     *     description="ID специалиста"
     * ),
     *
     * @SWG\Tag(name="Specialist", description="Получение данных спеиалиста"),
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
     *                         ref=@Model(type=\App\Application\Specialist\Dto\SpecialistResultDto::class)
     *                     )
     *                 )
     *             )
     *         }
     *     )
     * ),
     * @SWG\Response(response=400, description="Bad Request", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=500, description="Internal Server Error",
     *     @SWG\Schema(ref="#/definitions/JsonResponseException")),
     *
     * @return Response
     * @Route("api/v1/specialist_get-by-id", methods={"GET"})
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $id = $request->get('id');

        $form = $this->createForm(SpecialistGetByIdForm::class)
            ->submit($request->query->all());
        RequestFormValidationHelper::validate($form);

        $resultDto = $this->specialistGetService->get((int) $id);

        return ResponseFactory::createOkResponse($request, $resultDto);
    }
}
