<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\SiteOption;

use App\Application\SiteOption\SiteOptionGetService;
use App\UI\Controller\Api\SiteOption\Assembler\SiteOptionListResponseAssemblerInterface;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model as Model;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * Class SiteOptionGetController.
 *
 * @package App\UI\Controller\Api\SiteOption
 */
class SiteOptionGetController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var SiteOptionGetService
     */
    private SiteOptionGetService $siteOptionGetService;

    /**
     * OptionGetMainPageTextController constructor.
     *
     * @param SiteOptionGetService                     $siteOptionGetService
     */
    public function __construct(
        SiteOptionGetService $siteOptionGetService
    ) {
        $this->siteOptionGetService = $siteOptionGetService;
    }

    /**
     * @SWG\Tag(
     *     name="SiteOption",
     *     description="Получение опции сайта."
     * )
     *
     *
     * @SWG\Parameter(
     *     in="query",
     *     required=false,
     *     type="array",
     *     name="name[]",
     *     collectionFormat="multi",
     *     items=@SWG\Schema(
     *          allOf={
     *              @SWG\Property(
     *                  type="string"
     *              )
     *          }
     *     )
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
     *                         ref=@Model(type=\App\Application\SiteOption\Dto\SiteOptionListResultDto::class)
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
     * @Route("api/v1/option/site-option_get", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        /**
         * Mixed используется так как InputBag::get() по факту может вернуть массив,
         * но в аннотации тип возвращаемого значения указан string|null, на что ругается psalm.
         *
         * @var mixed $options
         */
        $options = $request->query->get('name');

        if (!empty($options)) {
            $result = $this->siteOptionGetService->findByNames($options);
        } else {
            $result = $this->siteOptionGetService->findAll();
        }

        return ResponseFactory::createOkResponse($request, $result);
    }
}
