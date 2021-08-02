<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\SpecialistExperience;

use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use Exception;
use App\UI\Controller\Api\SpecialistExperience\Form\SpecialistExperienceDeleteForm;
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
 * Class SpecialistExperienceDeleteController.
 *
 * @package App\UI\Controller\Api\SpecialistExperience
 */
class SpecialistExperienceDeleteController extends AbstractController implements AccessibleFromPublicInterface
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
     * Add SpecialistExperienceDeleteController.
     *
     * @SWG\Tag(name="SpecialistExperience", description="Delete SpecialistExperience"),
     *
     * @SWG\Response(
     *     response=200,
     *     description="OK",
     * ),
     * @SWG\Response(response=400, description="Bad Request", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=404, description="Not found", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=500, description="Internal Server Error", @SWG\Schema(ref="#/definitions/JsonResponseException")),
     *
     * @Route("api/v1/specialist-experience_delete", methods={"POST"})
     *
     * @param Request $request
     *
     * @throws Exception
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $form = $this->createForm(SpecialistExperienceDeleteForm::class)->submit($request->request->all());
        RequestFormValidationHelper::validate($form);

        $this->specialistExperienceService->deleteSpecialistExperience((int) $request->get('id'));

        return ResponseFactory::createOkResponse($request);
    }
}
