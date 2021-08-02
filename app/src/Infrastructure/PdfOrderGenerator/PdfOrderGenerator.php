<?php

namespace App\Infrastructure\PdfOrderGenerator;

use App\Application\FileGenerator\FileGeneratorServiceInterface;
use App\Application\PdfOrderGenerator\PdfOrderGeneratorInterface;
use App\Application\TemplateRenderer\TemplateRendererServiceInterface;
use App\Domain\Entity\Specialist\Order;
use App\Domain\Entity\Specialist\ValueObject\OrderType;
use App\Domain\Repository\DocumentTemplate\DocumentTemplateRepositoryInterface;
use App\Domain\Repository\Specialist\SpecialistOrderRepositoryInterface;
use App\Infrastructure\FileSystem\FileSystemService;
use App\Infrastructure\PdfOrderGenerator\Exception\PdfOrderGeneratorException;
use SplFileInfo;

/**
 * Class PdfOrderGenerator.
 *
 * @package App\Infrastructure\PdfOrderGenerator
 */
class PdfOrderGenerator implements PdfOrderGeneratorInterface
{
    /**
     * @var SpecialistOrderRepositoryInterface
     */
    private SpecialistOrderRepositoryInterface $specialistOrderRepository;

    /**
     * @var DocumentTemplateRepositoryInterface
     */
    private DocumentTemplateRepositoryInterface $documentTemplateRepository;

    /**
     * @var TemplateRendererServiceInterface
     */
    private TemplateRendererServiceInterface $templateRendererService;

    /**
     * @var FileGeneratorServiceInterface
     */
    private FileGeneratorServiceInterface $fileGeneratorService;

    /**
     * @var FileSystemService
     */
    private FileSystemService $fileSystem;

    /**
     * SpecialistOrderGeneratorService constructor.
     *
     * @param SpecialistOrderRepositoryInterface $specialistOrderRepository
     * @param DocumentTemplateRepositoryInterface $documentTemplateRepository
     * @param TemplateRendererServiceInterface $templateRenderHelper
     * @param FileGeneratorServiceInterface $fileGeneratorService
     * @param FileSystemService $fileSystem
     */
    public function __construct(
        SpecialistOrderRepositoryInterface $specialistOrderRepository,
        DocumentTemplateRepositoryInterface $documentTemplateRepository,
        TemplateRendererServiceInterface $templateRenderHelper,
        FileGeneratorServiceInterface $fileGeneratorService,
        FileSystemService $fileSystem
    ) {
        $this->specialistOrderRepository = $specialistOrderRepository;
        $this->documentTemplateRepository = $documentTemplateRepository;
        $this->templateRendererService = $templateRenderHelper;
        $this->fileGeneratorService = $fileGeneratorService;
        $this->fileSystem = $fileSystem;
    }

    /**
     * @inheritDoc
     */
    public function generatePdfByOrderId(int $id): SplFileInfo
    {
        $order = $this->specialistOrderRepository->findById($id);

        $specialists = [];
        foreach ($order->getSpecialists() as $specialist) {
            $specialistName = implode(
                ' ',
                [
                    $specialist->getSecondName(),
                    $specialist->getFirstName(),
                    $specialist->getMiddleName()
                ]
            );

            $specialists[] = $specialistName;
        }

        if ($order->getType()->getValue() == OrderType::INCLUSION) {
            $content = $this->getContentForInclusionOrder($order, $specialists);
        } else {
            $content = $this->getContentForIssueOfADocumentOrder($order, $specialists);
        }

        // Генерация PDF документа.
        $file = $this->fileGeneratorService->generatePdf($content);

        // Изменить имя файла.
        $fileName = "order_{$order->getType()->getValue()}_{$order->getId()}";
        $updatedFile = $this->fileSystem->rename($file, $fileName);

        return new SplFileInfo($updatedFile);
    }

    /**
     * @param Order $order
     * @param array $specialists
     * @return string
     */
    private function getContentForInclusionOrder(Order $order, array $specialists): string
    {
        $templateName = OrderType::INCLUSION;

        // Генерация шаблона.
        $variables = [
            '%ORDER_DATE%' => $order->getDate()->format('d.m.Y'),
            '%ORDER_NUMBER%' => $order->getNumber()->getValue(),
            '%ORDER_USERS_LIST%' => $this->createSpecialistList($specialists),
            '%ORDER_USERS_ZPT%' => implode(', ', $specialists),
        ];

        return $this->templateRendererService->render("order/{$templateName}", $variables);
    }

    /**
     * @param Order $order
     * @param array $specialists
     * @return string
     *
     * @throws PdfOrderGeneratorException
     */
    private function getContentForIssueOfADocumentOrder(Order $order, array $specialists): string
    {
        $templateName = OrderType::ISSUE_OF_A_DOCUMENT;
        $templateId = $order->getTemplateId();

        if (!$templateId) {
            throw new PdfOrderGeneratorException("templateId у приказа с ID {$order->getId()} не может быть null");
        }

        $documentTemplate = $this->documentTemplateRepository->findById($templateId);

        if (!$documentTemplate) {
            throw new PdfOrderGeneratorException("Указан неверный templateId у приказа с ID {$order->getId()}");
        }

        // Генерация шаблона.
        $variables = [
            '%ORDER_DATE%' => $order->getDate()->format('d.m.Y'),
            '%ORDER_NUMBER%' => $order->getNumber()->getValue(),
            '%ORDER_USERS_LIST%' => $this->createSpecialistList($specialists),
            '%DOCUMENT_TYPE_NAME%' => $documentTemplate->getName(),
            '%DOCUMENT_TYPE_DISCIPLINE%' => $documentTemplate->getDisciplinesName(),
        ];

        return $this->templateRendererService->render("order/{$templateName}", $variables);
    }

    /**
     * @param array $specialists
     * @return string
     */
    private function createSpecialistList(array $specialists): string
    {
        $specialistsList = '<ol>';
        foreach ($specialists as $specialist) {
            $specialistsList .= "<li>{$specialist}</li>";
        }
        $specialistsList .= '</ol><br>';

        return $specialistsList;
    }
}
