<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\SpecialistExperience;

use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use Exception;
use App\Application\SpecialistExperience\Assembler\SpecialistExperienceUpdateAssemblerInterface;
use App\UI\Controller\Api\SpecialistExperience\Assembler\SpecialistExperienceResponseAssemblerInterface;
use App\Application\Exception\ValidationException;
use App\UI\Controller\Api\SpecialistExperience\Form\SpecialistExperienceUpdateForm;
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
 * Class SpecialistExperienceUpdateController.
 *
 * @package App\UI\Controller\Api\SpecialistExperience
 */
class SpecialistExperienceUpdateController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var SpecialistExperienceService
     */
    private SpecialistExperienceService $specialistExperienceService;

    /**
     * @var SpecialistExperienceUpdateAssemblerInterface
     */
    private SpecialistExperienceUpdateAssemblerInterface $specialistExperienceUpdateAssembler;

    /**
     * SpecialistExperienceUpdateController constructor.
     *
     * @param SpecialistExperienceService $specialistExperienceService
     * @param SpecialistExperienceUpdateAssemblerInterface $specialistExperienceUpdateAssembler
     */
    public function __construct(
        SpecialistExperienceService $specialistExperienceService,
        SpecialistExperienceUpdateAssemblerInterface $specialistExperienceUpdateAssembler
    ) {
        $this->specialistExperienceService = $specialistExperienceService;
        $this->specialistExperienceUpdateAssembler = $specialistExperienceUpdateAssembler;
    }

    /**
     * Update SpecialistExperience.
     *
     * @SWG\Tag(name="SpecialistExperience", description="Update SpecialistExperience"),
     *
     * @SWG\Parameter(
     *     in="body",
     *     name="specialist_experience",
     *     description="Опыт работы",
     *     @SWG\Schema(
     *         ref=@Model(type=\App\Application\SpecialistExperience\Dto\SpecialistExperienceUpdateDto::class)
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
     * @Route("api/v1/specialist-experience_update", methods={"POST"})
     *
     * @param Request $request
     *
     * @throws Exception
     *
     * @return Response
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        $form = $this->createForm(SpecialistExperienceUpdateForm::class)->submit($request->request->all());
        RequestFormValidationHelper::validate($form);

        $dto = $this->specialistExperienceUpdateAssembler->assemble($request->request->all());
        $specialistExperience = $this->specialistExperienceService->updateSpecialistExperience($dto);

        return ResponseFactory::createOkResponse($request, $specialistExperience);
    }
}
