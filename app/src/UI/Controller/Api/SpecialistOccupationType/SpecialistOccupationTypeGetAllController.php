<?php

namespace App\UI\Controller\Api\SpecialistOccupationType;

use App\UI\Controller\Api\SpecialistOccupationType\Dto\SpecialistOccupationTypeResponseDto;
use App\UI\Controller\Api\SpecialistOccupationType\Assembler\SpecialistOccupationTypeResponseAssembler;
use App\UI\Controller\Api\SpecialistOccupationType\SpecialistOccupationTypeService;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model as Model;
use Symfony\Component\Routing\Annotation\Route as Route;
use App\UI\Service\Response\ResponseFactory;

/**
 * Class SpecialistOccupationTypeGetAllController.
 */
class SpecialistOccupationTypeGetAllController implements AccessibleFromPublicInterface
{

    /**
     * @var SpecialistOccupationTypeService
     */
    private SpecialistOccupationTypeService $service;

    /**
     * SpecialistOccupationTypeGetAllController constructor.
     *
     * @param SpecialistOccupationTypeService $service
     */
    public function __construct(
        SpecialistOccupationTypeService $service
    ) {
        $this->service = $service;
    }

    /**
     * Возвращает список всех типов занятости.
     *
     * @SWG\Tag(name="SpecialistOccupationType", description="Возвращает список всех типов занятости"),
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
     *                         ref=@Model(type=\App\UI\Controller\Api\SpecialistOccupationType\Dto\SpecialistOccupationTypeResponseDto::class)
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
     * @Route("/api/v1/specialist-occupation-type_get-all", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $result = $this->service->getAll();

        return ResponseFactory::createOkResponse($request, $result);
    }
}
