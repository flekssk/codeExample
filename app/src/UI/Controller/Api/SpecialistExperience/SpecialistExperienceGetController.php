<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\SpecialistExperience;

use App\Application\RequestFormValidationHelper;
use App\UI\Controller\Api\SpecialistExperience\Form\SpecialistExperienceGetForm;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use Exception;
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
class SpecialistExperienceGetController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var SpecialistExperienceService
     */
    private SpecialistExperienceService $specialistExperienceService;

    public function __construct(
        SpecialistExperienceService $specialistExperienceService
    ) {
        $this->specialistExperienceService = $specialistExperienceService;
    }

    /**
     * Get SpecialistExperience.
     *
     * @SWG\Tag(name="SpecialistExperience", description="Get SpecialistExperience"),
     *
     * @SWG\Parameter(
     *     in="query",
     *     name="id",
     *     description="Specialist id",
     *     type="integer"
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
     * @Route("api/v1/specialist-experience_get-by-specialist-id", methods={"GET"})
     *
     * @param Request $request
     *
     * @throws Exception
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $form = $this->createForm(SpecialistExperienceGetForm::class)
            ->submit($request->query->all());
        RequestFormValidationHelper::validate($form);

        $specialistExperience = $this->specialistExperienceService->getSpecialistExperience((int)$request->get('id'));

        return ResponseFactory::createOkResponse($request, $specialistExperience);
    }
}
