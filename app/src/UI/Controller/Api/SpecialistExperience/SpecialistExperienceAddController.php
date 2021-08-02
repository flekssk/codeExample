<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\SpecialistExperience;

use App\UI\Controller\Api\SpecialistExperience\Assembler\SpecialistExperienceResponseAssemblerInterface;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use Exception;
use App\Application\SpecialistExperience\Assembler\SpecialistExperienceAddAssemblerInterface;
use App\UI\Controller\Api\SpecialistExperience\Form\SpecialistExperienceAddForm;
use App\UI\Service\Validator\RequestFormValidationHelper;
use App\Application\SpecialistExperience\SpecialistExperienceService;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class SpecialistExperienceAddController.
 *
 * @package App\UI\Controller\Api\SpecialistExperience
 */
class SpecialistExperienceAddController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var SpecialistExperienceService
     */
    private SpecialistExperienceService $specialistExperienceService;

    /**
     * @var SpecialistExperienceAddAssemblerInterface
     */
    private SpecialistExperienceAddAssemblerInterface $specialistExperienceAddAssembler;

    /**
     * SpecialistExperienceAddController constructor.
     *
     * @param SpecialistExperienceService $specialistExperienceService
     * @param SpecialistExperienceAddAssemblerInterface $specialistExperienceAddAssembler
     */
    public function __construct(
        SpecialistExperienceService $specialistExperienceService,
        SpecialistExperienceAddAssemblerInterface $specialistExperienceAddAssembler
    ) {
        $this->specialistExperienceService = $specialistExperienceService;
        $this->specialistExperienceAddAssembler = $specialistExperienceAddAssembler;
    }

    /**
     * Add SpecialistExperience.
     *
     * @SWG\Tag(name="SpecialistExperience", description="Add SpecialistExperience"),
     *
     * @SWG\Parameter(
     *     in="body",
     *     name="specialist_experience",
     *     description="Опыт работы",
     *     @SWG\Schema(
     *         ref=@Model(type=\App\Application\SpecialistExperience\Dto\SpecialistExperienceAddDto::class)
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
     *                         ref=@Model(type=\App\Application\SpecialistExperience\Dto\SpecialistExperienceResultDto::class)
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
     * @Route("api/v1/specialist-experience_add", methods={"POST"})
     *
     * @param Request $request
     *
     * @throws Exception
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        // При запуске тестов specialistId приходит как строка, из-за чего форма ругается при валидации.
        // Этот workaround преобразует specialistId в int.
        $requestParams = $request->request->all();
        if (isset($requestParams['specialistId'])) {
            $requestParams['specialistId'] = (int) $requestParams['specialistId'];
        }

        $form = $this->createForm(SpecialistExperienceAddForm::class)->submit($requestParams);
        RequestFormValidationHelper::validate($form);

        $dto = $this->specialistExperienceAddAssembler->assemble($requestParams);
        $specialistExperience = $this->specialistExperienceService->addSpecialistExperience($dto);

        return ResponseFactory::createOkResponse($request, $specialistExperience);
    }
}
