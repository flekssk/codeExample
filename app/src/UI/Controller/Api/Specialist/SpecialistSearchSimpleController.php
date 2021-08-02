<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\Specialist;

use App\Application\Specialist\SpecialistSearch\SpecialistFindService;
use App\Infrastructure\Persistence\Sphinx\Repository\Specialist\Assembler\SpecialistSearchAssemblerInterface;
use App\Application\Specialist\SpecialistAutocomplete\SpecialistAutocompleteService;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route as Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model as Model;

/**
 * Class SpecialistSearchSimpleController.
 *
 * @package App\UI\Controller\Api\Specialist
 */
class SpecialistSearchSimpleController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * Кол-во записей по умолчанию.
     */
    const DEFAULT_COUNT = 20;

    /**
     * @var SpecialistAutocompleteService
     */
    private SpecialistAutocompleteService $service;

    /**
     * @var SpecialistSearchAssemblerInterface
     */
    private SpecialistSearchAssemblerInterface $assembler;

    /**
     * SpecialistFindController constructor.
     *
     * @param SpecialistAutocompleteService      $service
     * @param SpecialistSearchAssemblerInterface $assembler
     */
    public function __construct(
        SpecialistAutocompleteService $service,
        SpecialistSearchAssemblerInterface $assembler
    ) {
        $this->service = $service;
        $this->assembler = $assembler;
    }

    /**
     * @param Request $request
     *
     * @SWG\Parameter(
     *     in="query",
     *     required=false,
     *     name="searchString",
     *     type="string",
     *     description="Поисковая строка"
     * )
     *
     * @SWG\Parameter(
     *     in="query",
     *     required=false,
     *     name="region",
     *     type="string",
     *     description="Регион"
     * )
     *
     * @SWG\Parameter(
     *     in="query",
     *     required=false,
     *     name="company",
     *     type="string",
     *     description="Компания"
     * )
     *
     * @SWG\Parameter(
     *     in="query",
     *     required=false,
     *     name="position",
     *     type="string",
     *     description="Должность"
     * )
     *
     * @SWG\Parameter(
     *     in="query",
     *     required=false,
     *     name="document",
     *     type="string",
     *     description="Номер документа"
     * )
     *
     * @SWG\Parameter(
     *     in="query",
     *     required=false,
     *     name="count",
     *     type="integer",
     *     description="Кол-во записей"
     * )
     *
     * @SWG\Tag(name="Specialist", description="Автокоплит для поиска специалистов"),
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
     *                         ref=@Model(type=\App\Application\Specialist\Dto\SpecialistAutocompleteDisplayDto::class)
     *                     )
     *                 )
     *             )
     *         }
     *     )
     * ),
     * @SWG\Response(response=400, description="Bad Request", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=500, description="Internal Server Error",
     *     @SWG\Schema(ref="#/definitions/JsonResponseException")),
     *
     * @return Response
     * @Route("/api/v1/specialist_search-simple", methods={"GET"})
     */
    public function __invoke(Request $request)
    {
        if (preg_match('/^\s+$/', $request->get('searchString', ''))) {
            $result = [];
        } else {
            $findDto = $this->assembler->assemble(
                $request->get('searchString', ''),
                $request->get('company', ''),
                $request->get('id2Position', ''),
                $request->get('document', ''),
                $request->get('region', ''),
                null
            );
            $count = (int) $request->get('count', self::DEFAULT_COUNT);
            $result = $this->service->find($findDto, $count);
        }

        return ResponseFactory::createOkResponse($request, $result);
    }
}
