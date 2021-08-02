<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\SchoolProgram;

use App\Application\Exception\ValidationException;
use App\Application\RequestFormValidationHelper;
use App\Application\SchoolProgram\SchoolProgramGet\SchoolProgramGetService;
use App\Domain\Repository\NotFoundException;
use App\UI\Controller\Api\SchoolProgram\Form\SchoolProgramGetFinishedBySpecialistForm;
use App\UI\Service\Response\ResponseFactory;
use GuzzleHttp\Exception\RequestException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model as Model;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * Class SchoolProgramGetFinishedBySpecialistController.
 *
 * @package App\UI\Controller\Api\Skill
 */
class SchoolProgramGetFinishedBySpecialistController extends AbstractController
{
    /**
     * @var SchoolProgramGetService
     */
    private SchoolProgramGetService $schoolProgramGetService;

    /**
     * SchoolProgramGetFinishedBySpecialistController constructor.
     *
     * @param SchoolProgramGetService $schoolProgramGetService
     */
    public function __construct(SchoolProgramGetService $schoolProgramGetService)
    {
        $this->schoolProgramGetService = $schoolProgramGetService;
    }

    /**
     * @SWG\Tag(
     *     name="School Program",
     *     description="Получение завершенных курсов для определенного специалиста."
     * )
     *
     * @SWG\Parameter(
     *     in="query",
     *     required=true,
     *     name="id",
     *     type="integer",
     *     description="ID специалиста"
     * ),
     *
     * @SWG\Response(
     *     response=200,
     *     description="OK",
     *     @SWG\Schema(
     *         type="object"
     *     )
     * ),
     * @SWG\Response(
     *     response=500,
     *     description="Internal Server Error",
     *     @SWG\Schema(ref="#/definitions/JsonResponseException")
     * ),
     *
     * @SWG\Response(
     *     response=424,
     *     description="Filed dependency",
     *     @SWG\Schema(ref="#/definitions/JsonResponseError")
     * ),
     *
     * @Route("api/v1/school-program_get-finished-by-specialist-id", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws BadRequestHttpException
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        $form = $this->createForm(SchoolProgramGetFinishedBySpecialistForm::class)
            ->submit($request->query->all());
        RequestFormValidationHelper::validate($form);

        try {
            $result = $this->schoolProgramGetService->getFinishedBySpecialistId(
                (int) $request->get('id'),
            );
        } catch (RequestException $exception) {
            throw new HttpException(Response::HTTP_FAILED_DEPENDENCY, $exception->getMessage());
        } catch (NotFoundException $exception) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }

        return ResponseFactory::createOkResponse($request, $result);
    }
}
