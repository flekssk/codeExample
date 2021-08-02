<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\Id2;

use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use Exception;
use App\Application\Id2\Id2EventService;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class Id2EventGetController
 * @package App\UI\Controller\Api\Id2Event
 */
class Id2EventGetController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var Id2EventService
     */
    private Id2EventService $id2EventService;

    public function __construct(
        Id2EventService $id2EventService
    ) {
        $this->id2EventService = $id2EventService;
    }

    /**
     * Get Id2Event.
     *
     * @param Request $request
     *
     * @SWG\Parameter(
     *     in="query",
     *     name="name",
     *     type="array",
     *     description="Запрошенные события",
     *     @SWG\Items(type="string")
     * ),
     *
     * @SWG\Tag(name="Id2Event", description="Get Id2Event"),
     **
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
     *                     ref=@Model(type=\App\Application\Id2\Dto\Id2EventDto::class)
     *                 )
     *             )
     *         }
     *     )
     * ),
     * @SWG\Response(response=400, description="Bad Request", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=404, description="Not found", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=500, description="Internal Server Error", @SWG\Schema(ref="#/definitions/JsonResponseException")),
     *
     * @Route("api/v1/id2_event_get", methods={"GET"})
     *
     * @param Request $request
     *
     * @throws Exception
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $id2Event = $this->id2EventService->searchId2Events((array)$request->get('name'));

        return ResponseFactory::createOkResponse($request, $id2Event);
    }
}
