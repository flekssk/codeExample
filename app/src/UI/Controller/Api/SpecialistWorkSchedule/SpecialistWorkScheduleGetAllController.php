<?php

namespace App\UI\Controller\Api\SpecialistWorkSchedule;

use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\SpecialistWorkSchedule\SpecialistWorkScheduleService;
use App\UI\Controller\Api\SpecialistWorkSchedule\Assembler\SpecialistWorkScheduleAssembler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model as Model;
use Symfony\Component\Routing\Annotation\Route as Route;
use App\UI\Service\Response\ResponseFactory;

/**
 * Class SpecialistWorkScheduleGetAllController.
 */
class SpecialistWorkScheduleGetAllController extends AbstractController implements AccessibleFromPublicInterface
{

    /**
     * @var SpecialistWorkScheduleAssembler
     */
    private SpecialistWorkScheduleAssembler $assembler;

    /**
     * @var SpecialistWorkScheduleService
     */
    private SpecialistWorkScheduleService $service;

    /**
     * SpecialistWorkScheduleGetAllController constructor.
     *
     * @param SpecialistWorkScheduleService $service
     */
    public function __construct(
        SpecialistWorkScheduleService $service,
        SpecialistWorkScheduleAssembler $assembler
    ) {
        $this->service = $service;
        $this->assembler = $assembler;
    }

    /**
     * Возвращает список всех графиков работы.
     *
     * @SWG\Tag(name="SpecialistWorkSchedule", description="Возвращает список всех графиков работы"),
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
     *                         ref=@Model(type=\App\UI\Controller\Api\SpecialistWorkSchedule\Dto\SpecialistWorkScheduleDto::class)
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
     * @Route("/api/v1/specialist-work-schedule_get-all", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $result = [];
        $dtoObjects = $this->service->getAll();
        foreach ($dtoObjects as $resultDto) {
            $result[] = $this->assembler->assemble($resultDto);
        }

        return ResponseFactory::createOkResponse($request, $result);
    }
}
