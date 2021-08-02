<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\Specialist;

use App\Application\Specialist\Specialist\Assembler\SpecialistAddAssemblerInterface;
use App\Application\Specialist\Specialist\SpecialistService;
use App\UI\Controller\Api\Specialist\Form\SpecialistAddForm;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use App\UI\Service\Validator\RequestFormValidationHelper;
use Exception;
use App\Application\Exception\ValidationException;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class SpecialistAddController.
 *
 * @package App\UI\Controller\Api\Specialist
 */
class SpecialistAddController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var SpecialistService
     */
    private SpecialistService $specialistService;

    /**
     * @var SpecialistAddAssemblerInterface
     */
    private SpecialistAddAssemblerInterface $specialistAddAssembler;

    /**
     * SpecialistAddController constructor.
     *
     * @param SpecialistService $specialistService
     * @param SpecialistAddAssemblerInterface $specialistAddAssembler
     */
    public function __construct(SpecialistService $specialistService, SpecialistAddAssemblerInterface $specialistAddAssembler)
    {
        $this->specialistService = $specialistService;
        $this->specialistAddAssembler = $specialistAddAssembler;
    }

    /**
     * Add Specialist.
     *
     * @SWG\Tag(name="Specialist", description="Add Specialist"),
     *
     * @SWG\Parameter(
     *     in="body",
     *     name="specialist",
     *     description="Специалист",
     *     @SWG\Schema(
     *         ref=@Model(type=\App\Application\Specialist\Specialist\Dto\SpecialistAddDto::class)
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
     * @SWG\Response(response=500, description="Internal Server Error", @SWG\Schema(ref="#/definitions/JsonResponseException")),
     *
     * @Route("api/v2/specialist_add", methods={"POST"})
     *
     * @param Request $request
     *
     * @throws Exception
     * @throws ValidationException
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $form = $this->createForm(SpecialistAddForm::class)->submit($request->request->all());
        RequestFormValidationHelper::validate($form);

        $dto = $this->specialistAddAssembler->assemble($request->request->all());
        $specialist = $this->specialistService->addOrUpdateSpecialist($dto);

        return ResponseFactory::createOkResponse($request, $specialist);
    }
}
