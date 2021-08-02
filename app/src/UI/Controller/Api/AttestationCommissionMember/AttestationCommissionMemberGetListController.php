<?php

namespace App\UI\Controller\Api\AttestationCommissionMember;

use App\Application\AttestationCommissionMember\AttestationCommissionMemberService;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model as Model;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * Class AttestationCommissionMemberGetListController.
 *
 * @package App\UI\Controller\Api\AttestationCommissionMember
 */
class AttestationCommissionMemberGetListController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var AttestationCommissionMemberService
     */
    private AttestationCommissionMemberService $attestationCommissionMemberService;

    /**
     * AttestationCommissionMemberGetListController constructor.
     *
     * @param AttestationCommissionMemberService $attestationCommissionMemberService
     */
    public function __construct(
        AttestationCommissionMemberService $attestationCommissionMemberService
    ) {
        $this->attestationCommissionMemberService = $attestationCommissionMemberService;
    }

    /**
     * Get list of attestation commission members.
     *
     * @SWG\Tag(name="AttestationCommissionMember", description="Get AttestationCommissionMember list"),
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
     *                          property="result",
     *                          ref=@Model(type=\App\Application\AttestationCommissionMember\Dto\AttestationCommissionMemberResultDto::class)
     *                     )
     *                 )
     *             )
     *         }
     *     )
     * ),
     * @SWG\Response(response=400, description="Bad Request", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=404, description="Not found", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=500, description="Internal Server Error",
     *     @SWG\Schema(ref="#/definitions/JsonResponseException")),
     *
     * @Route("/api/v1/attestation-commission-member_get-list", methods={"GET"})
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $members = $this->attestationCommissionMemberService->getAll();

        return ResponseFactory::createOkResponse($request, $members);
    }
}
