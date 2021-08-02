<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\Specialist;

use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use Exception;
use App\Application\Exception\ValidationException;
use App\Application\Specialist\Specialist\Assembler\SpecialistUpdateAssembler;
use App\Application\Specialist\Specialist\SpecialistService;
use App\UI\Controller\Api\Specialist\Form\SpecialistUpdateForm;
use App\UI\Service\Response\ResponseFactory;
use App\UI\Service\Validator\RequestFormValidationHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class SpecialistUpdateController.
 *
 * @package App\UI\Controller\Api\Specialist
 */
class SpecialistUpdateController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var SpecialistService
     */
    private SpecialistService $specialistService;

    /**
     * @var SpecialistUpdateAssembler
     */
    private SpecialistUpdateAssembler $specialistUpdateAssembler;

    /**
     * SpecialistUpdateController constructor.
     *
     * @param SpecialistService $specialistService
     * @param SpecialistUpdateAssembler $specialistUpdateAssembler
     */
    public function __construct(SpecialistService $specialistService, SpecialistUpdateAssembler $specialistUpdateAssembler)
    {
        $this->specialistUpdateAssembler = $specialistUpdateAssembler;
        $this->specialistService = $specialistService;
    }

    /**
     * Update Specialist.
     *
     * @SWG\Tag(name="Specialist", description="Update Specialist"),
     *
     * @SWG\Parameter(
     *     in="body",
     *     name="specialist",
     *     description="Специалист",
     *     @SWG\Schema(
     *         ref=@Model(type=\App\Application\Specialist\Specialist\Dto\SpecialistUpdateDto::class)
     *     ),
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
     *                         ref=@Model(type=\App\Application\Specialist\Dto\SpecialistResultDto::class)
     *                     )
     *                 )
     *             )
     *         }
     *     )
     * ),
     * @SWG\Response(response=400, description="Bad Request", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=404, description="Not Found", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=500, description="Internal Server Error", @SWG\Schema(ref="#/definitions/JsonResponseException")),
     *
     * @Route("api/v1/specialist_update", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws Exception
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        $form = $this->createForm(SpecialistUpdateForm::class)->submit($request->request->all());
        RequestFormValidationHelper::validate($form);

        $dto = $this->specialistUpdateAssembler->assemble($request->request->all());
        $specialist = $this->specialistService->updateSpecialist($dto);

        return ResponseFactory::createOkResponse($request, $specialist);
    }
}
