<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\Specialist;

use App\Application\RequestFormValidationHelper;
use App\Application\Specialist\SpecialistSearch\SpecialistSearchService;
use App\Infrastructure\Persistence\Sphinx\Repository\Specialist\Assembler\SpecialistSearchAssemblerInterface;
use App\UI\Controller\Api\Specialist\Assembler\SpecialistSearchListResponseAssemblerInterface;
use App\UI\Controller\Api\Specialist\Form\SpecialistPaginatedFindForm;
use App\UI\Controller\Api\Specialist\Model\SpecialistPaginatedSearchModel;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class SpecialistSearchController.
 *
 * @package App\UI\Controller\Api\Specialist
 */
class SpecialistSearchController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var SpecialistSearchService
     */
    private SpecialistSearchService $specialistFindService;

    /**
     * @var SpecialistSearchAssemblerInterface
     */
    private SpecialistSearchAssemblerInterface $specialistSearchAssembler;

    /**
     * @var SpecialistSearchListResponseAssemblerInterface
     */
    private SpecialistSearchListResponseAssemblerInterface $searchListResponseAssembler;

    /**
     * SpecialistFindController constructor.
     *
     * @param SpecialistSearchService                        $specialistSearchService
     * @param SpecialistSearchAssemblerInterface             $specialistSearchAssembler
     * @param SpecialistSearchListResponseAssemblerInterface $searchListResponseAssembler
     */
    public function __construct(
        SpecialistSearchService $specialistSearchService,
        SpecialistSearchAssemblerInterface $specialistSearchAssembler,
        SpecialistSearchListResponseAssemblerInterface $searchListResponseAssembler
    ) {
        $this->specialistFindService = $specialistSearchService;
        $this->specialistSearchAssembler = $specialistSearchAssembler;
        $this->searchListResponseAssembler = $searchListResponseAssembler;
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @throws \App\Application\Exception\ValidationException
     *
     * @SWG\Parameter(
     *     in="query",
     *     name="searchString",
     *     type="string",
     *     description="Поисковая строка"
     * )
     *
     * @SWG\Parameter(
     *     in="query",
     *     name="company",
     *     type="string",
     *     description="Название компании"
     * )
     *
     * @SWG\Parameter(
     *     in="query",
     *     name="position",
     *     type="string",
     *     description="Должность"
     * )
     *
     * @SWG\Parameter(
     *     in="query",
     *     name="document",
     *     type="string",
     *     description="Номер документа"
     * )
     *
     * @SWG\Parameter(
     *     in="query",
     *     name="region",
     *     type="string",
     *     description="Регион"
     * )
     *
     * @SWG\Parameter(
     *     in="query",
     *     name="status",
     *     type="integer",
     *     description="Статус"
     * )
     *
     * @SWG\Parameter(
     *     in="query",
     *     name="page",
     *     type="integer",
     *     description="Номер страницы с результатами для пагинации"
     * )
     *
     * @SWG\Parameter(
     *     in="query",
     *     name="perPage",
     *     type="integer",
     *     description="Количество записей в результате для пагинации"
     * )
     *
     * @SWG\Tag(name="Specialist", description="Search specilist by criteria"),
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
     *                     allOf={
     *                         @SWG\Schema(
     *                             @SWG\Property(
     *                                 property="result",
     *                                 ref=@Model(type=\App\Application\Specialist\Dto\SpecialistResultDto::class)
     *                             ),
     *                             @SWG\Property(
     *                                 property="page",
     *                                 type="integer"
     *                             ),
     *                             @SWG\Property(
     *                                 property="perPage",
     *                                 type="integer"
     *                             ),
     *                             @SWG\Property(
     *                                 property="totalCount",
     *                                 type="integer"
     *                             )
     *                         )
     *                     }
     *                 )
     *             )
     *         }
     *     )
     * ),
     * @SWG\Response(response=500, description="Internal Server Error",
     *     @SWG\Schema(ref="#/definitions/JsonResponseException")),
     * ),
     *
     * @Route("api/v1/specialist_search", methods={"GET"})
     */
    public function __invoke(Request $request)
    {
        $model = new SpecialistPaginatedSearchModel();
        $form = $this->createForm(SpecialistPaginatedFindForm::class, $model)
            ->submit($request->query->all());
        RequestFormValidationHelper::validate($form);

        $findDto = $this->specialistSearchAssembler->assemble(
            $model->searchString ?? '',
            $model->company ?? '',
            $model->id2Position ?? '',
            $model->document ?? '',
            $model->region ?? '',
            $model->status
        );

        $limit = (int) $model->perPage;
        $offset = (int) $model->perPage * (int) $model->page - (int) $model->perPage;

        $result = $this->specialistFindService->find($findDto, $limit, $offset);
        $responseDto = $this->searchListResponseAssembler->assemble($result);

        return ResponseFactory::createPaginatedOkResponse(
            $request,
            $responseDto->result,
            $responseDto->page,
            $responseDto->perPage,
            $responseDto->totalCount,
        );
    }
}
