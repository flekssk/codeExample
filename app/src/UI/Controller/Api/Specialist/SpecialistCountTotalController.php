<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\Specialist;

use App\Application\Specialist\SpecialistCount\SpecialistCountService;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model as Model;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * Class SpecialistCountTotalController.
 *
 * @package App\UI\Controller\Api\Specialist
 */
class SpecialistCountTotalController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var SpecialistCountService
     */
    private SpecialistCountService $specialistCountService;

    /**
     * SpecialistTotalCountController constructor.
     *
     * @param SpecialistCountService $specialistCountService
     */
    public function __construct(SpecialistCountService $specialistCountService)
    {
        $this->specialistCountService = $specialistCountService;
    }

    /**
     * Count Specialist.
     *
     * @SWG\Tag(name="Specialist", description="Count Specialist"),
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
     *                         ref=@Model(type=\App\Application\Specialist\SpecialistCount\Dto\SpecialistCountDto::class)
     *                     )
     *                 )
     *             )
     *         }
     *     )
     * ),
     * @SWG\Response(response=500, description="Internal Server Error",
     *     @SWG\Schema(ref="#/definitions/JsonResponseException")),
     *
     * @Route("api/v1/specialist_count-total", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $result = $this->specialistCountService->total();

        return ResponseFactory::createOkResponse($request, $result);
    }
}
