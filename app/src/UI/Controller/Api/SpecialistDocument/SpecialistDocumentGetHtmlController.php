<?php

namespace App\UI\Controller\Api\SpecialistDocument;

use App\Application\Exception\ValidationException;
use App\Application\FileGenerator\Exception\FileGeneratorException;
use App\Application\RequestFormValidationHelper;
use App\Application\SpecialistDocument\SpecialistDocumentService;
use App\UI\Controller\Api\SpecialistDocument\Form\SpecialistDocumentGetForm;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model as Model;
use Symfony\Component\Routing\Annotation\Route as Route;
use App\UI\Service\Response\ResponseFactory;

/**
 * Class SpecialistDocumentGetHtmlController
 * @package App\UI\Controller\Api\SpecialistDocument
 */
class SpecialistDocumentGetHtmlController extends AbstractController implements AccessibleFromPublicInterface
{

    /**
     * @var SpecialistDocumentService
     */
    private SpecialistDocumentService $service;

    /**
     * SpecialistDocumentGetAllController constructor.
     *
     * @param SpecialistDocumentService $service
     */
    public function __construct(
        SpecialistDocumentService $service
    ) {
        $this->service = $service;
    }

    /**
     * Получение сгенерированной картинки документа.
     *
     * @SWG\Tag(name="Order", description="Получение сгенерированного html документа"),
     * @SWG\Parameter(
     *     in="query",
     *     required=true,
     *     name="id",
     *     type="string",
     *     description="ID"
     * )
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
     *                         type="string"
     *                     )
     *                 )
     *             )
     *         }
     *     )
     * )
     * @SWG\Response(response=400, description="Bad Request", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=500, description="Internal Server Error", @SWG\Schema(ref="#/definitions/JsonResponseException")),
     *
     * @Route("/api/v1/specialist-document-html_get-by-id", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     * @throws FileGeneratorException
     *
     * @throws ValidationException
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(SpecialistDocumentGetForm::class)
            ->submit($request->query->all());
        RequestFormValidationHelper::validate($form);

        $result = $this->service->getDocumentHtmlById((int)$request->get('id'));

        return ResponseFactory::createOkResponse($request, $result);
    }
}
