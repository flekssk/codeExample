<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\Skill;

use App\Application\Skill\SkillGet\SkillGetService;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model as Model;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * Class SkillGetAllController.
 *
 * @package App\UI\Controller\Api\Skill
 */
class SkillGetAllController extends AbstractController
{
    /**
     * @var SkillGetService
     */
    private SkillGetService $skillGetService;

    /**
     * SkillGetAllController constructor.
     *
     * @param SkillGetService $skillGetService
     */
    public function __construct(SkillGetService $skillGetService)
    {
        $this->skillGetService = $skillGetService;
    }

    /**
     * @SWG\Tag(
     *     name="Skill",
     *     description="Получение навыков."
     * )
     *
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
     *                         property="data",
     *                         ref=@Model(type=\App\Application\Skill\SkillGet\Dto\SkillListResultDto::class)
     *                     )
     *                 )
     *             )
     *         }
     *     )
     * ),
     * @SWG\Response(
     *     response=500,
     *     description="Internal Server Error",
     *     @SWG\Schema(ref="#/definitions/JsonResponseException")
     * ),
     *
     * @Route("api/v1/skill_get-all", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $result = $this->skillGetService->getAll();

        return ResponseFactory::createOkResponse($request, $result);
    }
}
