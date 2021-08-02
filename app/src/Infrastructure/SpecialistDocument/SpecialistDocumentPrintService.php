<?php

namespace App\Infrastructure\SpecialistDocument;

use App\Application\FileGenerator\FileGeneratorServiceInterface;
use App\Application\SpecialistDocument\SpecialistDocumentPrintServiceInterface;
use App\Application\TemplateRenderer\TemplateRendererServiceInterface;
use App\Domain\Entity\DocumentTemplate\DocumentTemplate;
use App\Domain\Entity\DocumentType\DocumentType;
use App\Domain\Entity\Specialist\Specialist;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use App\Infrastructure\FileSystem\FileSystemService;
use DateTimeInterface;

class SpecialistDocumentPrintService implements SpecialistDocumentPrintServiceInterface
{
    private const BASE_PATH = 'document/';
    private const DEFAULT_PATH = 'default';

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
     * SpecialistDocumentPrintService constructor.
     * @param TemplateRendererServiceInterface $templateRendererService
     * @param FileGeneratorServiceInterface $fileGeneratorService
     * @param FileSystemService $fileSystem
     */
    public function __construct(
        TemplateRendererServiceInterface $templateRendererService,
        FileGeneratorServiceInterface $fileGeneratorService,
        FileSystemService $fileSystem
    ) {
        $this->templateRendererService = $templateRendererService;
        $this->fileGeneratorService = $fileGeneratorService;
        $this->fileSystem = $fileSystem;
    }

    /**
     * @inheritDoc
     */
    public function getPicture(SpecialistDocument $document, DocumentType $documentType, Specialist $specialist): \SplFileInfo
    {
        $template = $this->getHtmlTemplate($documentType->getTemplateName());
        $variables = $this->getVariables($document, $documentType->getDocumentTemplate(), $documentType, $specialist);
        $html = $this->templateRendererService->render($template, $variables);
        $pictureFile = $this->fileGeneratorService->generateImage($html);
        $fileName = $document->getName();
        $updatedFile = $this->fileSystem->rename($pictureFile, $fileName);

        return new \SplFileInfo($updatedFile);
    }

    /**
     * @inheritDoc
     */
    public function getHtml(SpecialistDocument $document, DocumentType $documentType, Specialist $specialist): string
    {
        $template = $this->getHtmlTemplate($documentType->getTemplateName());
        $variables = $this->getVariables($document, $documentType->getDocumentTemplate(), $documentType, $specialist);
        return $this->templateRendererService->renderWithoutImages($template, $variables);
    }

    /**
     * @param string $templateId
     * @return string
     */
    private function getHtmlTemplate(string $templateId): string
    {
        if (empty($templateId)) {
            $templateId = self::DEFAULT_PATH;
        }

        return self::BASE_PATH . $templateId;
    }

    /**
     * @param SpecialistDocument $document
     * @param DocumentTemplate $documentTemplate
     * @param DocumentType $documentType
     * @param Specialist $specialist
     *
     * @return array
     */
    private function getVariables(SpecialistDocument $document, DocumentTemplate $documentTemplate, DocumentType $documentType, Specialist $specialist): array
    {
        return [
            '%DOMAIN_HOST%' => '', //getenv('AWS_S3_URL'), //@todo Сделано так в целях экономии времени перед релизом, переделать на корректное получение хоста.
            '%DOCUMENT_TYPE%' => $documentType->getName(),
            '%DOCUMENT_TITLE%' => $document->getName(),
            '%FIO%' => $this->getFio(
                $specialist->getFirstName(),
                $specialist->getSecondName(),
                $specialist->getMiddleName()
            ),
            '%DOCUMENT_NUM%' => $document->getNumber(),
            '%DOCUMENT_EDATE%' => $document->getEndDate()->format('d.m.Y'),
            '%DOCUMENT_EDATE_Long_RU%' => $this->getDateWithRussianMonthName($document->getEndDate()),
            '%DOCUMENT_DISCHIP%' => $document->getDisciplinesName(),
            '%DOCUMENT_HOURS%' => $document->getHours(),
            '%DOCUMENT_eduDateStart%' => $this->getDateWithRussianMonthName($document->getEduDateStart()),
            '%DOCUMENT_eduDateEnd%' => $this->getDateWithRussianMonthName($document->getEduDateEnd()),
            '%DOCUMENT_SDATE_SHOT%' => $document->getEduDateStart()->format('d.m.Y'),
            '%DOCUMENT_EYEAR%' => $documentTemplate->getYear()->format('Y'),
            '%DOCUMENT_BG_IMAGE%' => $documentType->getImageBackground(),
        ];
    }

    /**
     * @param string|null $firstName
     * @param string|null $secondName
     * @param string|null $middleName
     * @return string
     */
    private function getFio(?string $firstName, ?string $secondName, ?string $middleName): string
    {
        return (string)$firstName . ' ' . (string)$middleName . (empty($secondName) ? '' : ' ') . "<span>" . (string)$secondName . "</span>";
    }

    /**
     * Получить дату с русским названием месяца.
     *
     * @param DateTimeInterface $date
     *
     * @return string
     */
    private function getDateWithRussianMonthName(DateTimeInterface $date): string
    {
        $russianNames = [
            'января',
            'февраля',
            'марта',
            'апреля',
            'мая',
            'июня',
            'июля',
            'августа',
            'сентября',
            'октября',
            'ноября',
            'декабря',
        ];
        $day = $date->format('d');
        $month = (int) $date->format('m');
        $year = $date->format('Y');

        return "{$day} {$russianNames[$month - 1]} ${year}";
    }
}
