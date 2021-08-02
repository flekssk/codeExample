<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\SchoolProgram;

use App\Application\RequestFormValidationHelper;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use App\Application\SchoolProgram\SchoolProgressGet\SchoolProgressGetService;
use App\UI\Controller\Api\SchoolProgram\Form\SchoolProgramProgressGetBySpecialistForm;

/**
 * Class SchoolProgramProgressGetBySpecialistController.
 */
class SchoolProgramProgressGetBySpecialistController extends AbstractController
{

    /**
     * @var SchoolProgressGetService
     */
    private SchoolProgressGetService $schoolProgressGetService;

    public function __construct(
        SchoolProgressGetService $schoolProgressGetService
    ) {
        $this->schoolProgressGetService = $schoolProgressGetService;
    }

    /**
     * Возвращает процент прохождения обучения специалиста.
     *
     * @SWG\Tag(name="School Program", description="Возвращает процент прохождения обучения специалиста"),
     * @SWG\Parameter(
     *     in="query",
     *     required=true,
     *     name="id",
     *     type="integer",
     *     description="ID специалиста"
     * )
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
     *                         type="float"
     *                     )
     *                 )
     *             )
     *         }
     *     )
     * )
     * @SWG\Response(response=400, description="Bad Request", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=500, description="Internal Server Error",
     *     @SWG\Schema(ref="#/definitions/JsonResponseException")),
     *
     * @Route("/api/v1/school-program_progress_get-by-specialist-id", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(SchoolProgramProgressGetBySpecialistForm::class)
            ->submit($request->query->all());
        RequestFormValidationHelper::validate($form);

        $id = (int)$request->get('id');
        $result = $this->schoolProgressGetService->getProgressValueBySpecialistId($id);
        return ResponseFactory::createOkResponse($request, $result);
    }
}
