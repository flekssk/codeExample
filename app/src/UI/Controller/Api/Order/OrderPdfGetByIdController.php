<?php

namespace App\UI\Controller\Api\Order;

use App\Application\Exception\ValidationException;
use App\Application\PdfOrderGenerator\PdfOrderGeneratorInterface;
use App\Application\RequestFormValidationHelper;
use App\UI\Controller\Api\Order\Form\OrderPdfGetByIdForm;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use App\UI\Service\Response\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * Class OrderPdfGetByIdController.
 */
class OrderPdfGetByIdController extends AbstractController implements AccessibleFromPublicInterface
{
    /**
     * @var PdfOrderGeneratorInterface
     */
    private PdfOrderGeneratorInterface $pdfOrderGenerator;

    /**
     * PositionSearchController constructor.
     *
     * @param PdfOrderGeneratorInterface $pdfOrderGenerator
     */
    public function __construct(PdfOrderGeneratorInterface $pdfOrderGenerator)
    {
        $this->pdfOrderGenerator = $pdfOrderGenerator;
    }

    /**
     * Получение сгенерированного PDF файла для приказа.
     *
     * @SWG\Tag(name="Order", description="Получение сгенерированного PDF файла для приказа"),
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
     *     )
     * )
     * @SWG\Response(response=400, description="Bad Request", @SWG\Schema(ref="#/definitions/JsonResponseError")),
     * @SWG\Response(response=500, description="Internal Server Error", @SWG\Schema(ref="#/definitions/JsonResponseException")),
     *
     * @Route("/api/v1/specialist-order-pdf_get-by-id", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws ValidationException
     */
    public function __invoke(Request $request): Response
    {
        $id = (int) $request->get('id');

        $form = $this->createForm(OrderPdfGetByIdForm::class)
            ->submit($request->query->all());
        RequestFormValidationHelper::validate($form);

        $result = $this->pdfOrderGenerator->generatePdfByOrderId($id);

        return ResponseFactory::createFileResponse($result, true);
    }
}
