<?php

namespace App\UI\Controller\Api\Specialist;

use App\Application\Exception\ValidationException;
use App\Application\RequestFormValidationHelper;
use App\Application\Specialist\SpecialistSync\SpecialistSyncService;
use App\UI\Controller\Api\Specialist\Form\SpecialistAfterSignInForm;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model as Model;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * Class SpecialistAfterSignInController.
 *
 * @package App\UI\Controller\Api\Specialist
 */
class SpecialistAfterSignInController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var SpecialistSyncService
     */
    private SpecialistSyncService $specialistSyncService;

    public function __construct(SpecialistSyncService $specialistSyncService)
    {
        $this->specialistSyncService = $specialistSyncService;
    }

    /**
     * @param Request $request
     *
     * @SWG\Tag(name="Specialist", description="Count Specialist"),
     *
     * @SWG\Parameter(
     *     in="body",
     *     name="parameters",
     *     @SWG\Schema(
     *         ref=@Model(type=\App\UI\Controller\Api\Specialist\Models\SpecialistSyncModel::class)
     *     ),
     * ),
     *
     * @SWG\Response(
     *     response=200,
     *     description="OK",
     * ),
     * @SWG\Response(response=404, description="Пользователь не найден",
     *     @SWG\Schema(ref="#/definitions/JsonResponseException")
     * ),
     * @SWG\Response(response=500, description="Internal Server Error",
     *     @SWG\Schema(ref="#/definitions/JsonResponseException")
     * ),
     *
     * @Route("api/v1/specialist_after-sign-in", methods={"POST"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        $userId = $request->get('userId');

        $form = $this->createForm(SpecialistAfterSignInForm::class)
            ->submit($request->request->all());
        RequestFormValidationHelper::validate($form);

        $this->specialistSyncService->syncUserWithId2ById($userId);

        return ResponseFactory::createOkResponse($request);
    }
}
