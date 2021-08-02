<?php

namespace App\Application\Specialist\SpecialistOrder;

use App\Application\Specialist\SpecialistOrder\Assembler\SpecialistOrderListResultAssemblerInterface;
use App\Application\Specialist\SpecialistOrder\Assembler\SpecialistOrderResultAssemblerInterface;
use App\Application\Specialist\SpecialistOrder\SpecialistOrderGenerator\SpecialistOrderGeneratorServiceInterface;
use App\Domain\Entity\DocumentTemplate\DocumentTemplate;
use App\Domain\Entity\Specialist\ValueObject\OrderType;
use App\Domain\Repository\DocumentTemplate\DocumentTemplateRepositoryInterface;
use App\Domain\Repository\NotFoundException;
use App\Domain\Repository\SiteOptionRepositoryInterface;
use App\Domain\Repository\Specialist\SpecialistOrderRepositoryInterface;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use App\Domain\Repository\SpecialistDocument\SpecialistDocumentRepositoryInterface;
use DateTimeInterface;
use Generator;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * Class SpecialistOrderService.
 *
 * @package App\Application\Specialist\SpecialistOrder
 */
class SpecialistOrderService
{
    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $specialistRepository;

    /**
     * @var SpecialistOrderListResultAssemblerInterface
     */
    private SpecialistOrderListResultAssemblerInterface $orderListResultAssembler;

    /**
     * @var SpecialistOrderResultAssemblerInterface
     */
    private SpecialistOrderResultAssemblerInterface $orderResultAssembler;

    /**
     * @var SpecialistOrderGeneratorServiceInterface
     */
    private SpecialistOrderGeneratorServiceInterface $specialistOrderGeneratorService;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var SpecialistOrderRepositoryInterface
     */
    private SpecialistOrderRepositoryInterface $specialistOrderRepository;

    /**
     * @var SpecialistDocumentRepositoryInterface
     */
    private SpecialistDocumentRepositoryInterface $specialistDocumentRepository;
    /**
     * @var DocumentTemplateRepositoryInterface
     */
    private DocumentTemplateRepositoryInterface $documentTemplateRepository;
    /**
     * @var SiteOptionRepositoryInterface
     */
    private SiteOptionRepositoryInterface $siteOptionRepository;

    /**
     * SpecialistOrderService constructor.
     * @param SpecialistRepositoryInterface $specialistRepository
     * @param SpecialistOrderListResultAssemblerInterface $orderListResultAssembler
     * @param SpecialistOrderResultAssemblerInterface $orderResultAssembler
     * @param SpecialistOrderGeneratorServiceInterface $specialistOrderGeneratorService
     * @param SpecialistOrderRepositoryInterface $specialistOrderRepository
     * @param SpecialistDocumentRepositoryInterface $specialistDocumentRepository
     * @param DocumentTemplateRepositoryInterface $documentTemplateRepository
     * @param SiteOptionRepositoryInterface $siteOptionRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        SpecialistRepositoryInterface $specialistRepository,
        SpecialistOrderListResultAssemblerInterface $orderListResultAssembler,
        SpecialistOrderResultAssemblerInterface $orderResultAssembler,
        SpecialistOrderGeneratorServiceInterface $specialistOrderGeneratorService,
        SpecialistOrderRepositoryInterface $specialistOrderRepository,
        SpecialistDocumentRepositoryInterface $specialistDocumentRepository,
        DocumentTemplateRepositoryInterface $documentTemplateRepository,
        SiteOptionRepositoryInterface $siteOptionRepository,
        LoggerInterface $logger
    ) {
        $this->specialistRepository = $specialistRepository;
        $this->orderListResultAssembler = $orderListResultAssembler;
        $this->orderResultAssembler = $orderResultAssembler;
        $this->specialistOrderGeneratorService = $specialistOrderGeneratorService;
        $this->specialistOrderRepository = $specialistOrderRepository;
        $this->specialistDocumentRepository = $specialistDocumentRepository;
        $this->documentTemplateRepository = $documentTemplateRepository;
        $this->siteOptionRepository = $siteOptionRepository;
        $this->logger = $logger;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getByUserId(int $id): array
    {
        if (!$this->specialistRepository->has($id)) {
            throw new NotFoundException("Пользователь с id {$id} не найден.");
        }

        $specialist = $this->specialistRepository->get($id);

        $orders = $specialist->getOrders();
        $orderList = [];
        foreach ($orders as $order) {
            $type = $order->getType();

            if ($type == OrderType::INCLUSION) {
                try {
                    $name = (string)$this->siteOptionRepository->findOneByName('inclusionLabel')->getValue();
                } catch (NotFoundException $exception) {
                    $name = OrderType::INCLUSION_LABEL;
                }
            } else {
                try {
                    $name = (string)$this->siteOptionRepository->findOneByName('issueOfADocumentLabel')->getValue();
                } catch (NotFoundException $exception) {
                    $name = OrderType::ISSUE_OF_A_DOCUMENT_LABEL;
                }
                $documentTemplate = $this->documentTemplateRepository->find($order->getTemplateId());
                if ($documentTemplate) {
                    $name .=  ' ' . $documentTemplate->getName();
                }
            }

            $url = "/order/{$order->getId()}.pdf";

            $orderList[] = $this->orderResultAssembler->assemble($order, $name, $url);
        }

        return $orderList;
    }

    /**
     * Генерация приказов о включении пользователей в Реестр.
     *
     * @param DateTimeInterface $dateFrom
     *
     * @return Generator
     */
    public function generateInclusionOrders(DateTimeInterface $dateFrom): Generator
    {
        // Поиск специалистов относительно даты создания.
        $specialistsIDs = $this->specialistRepository->findSpecialistsIDsByCreationDateRange($dateFrom);

        foreach ($specialistsIDs as $specialistID) {
            $specialist = $this->specialistRepository->find($specialistID);

            if (!$specialist) {
                yield false;
                continue;
            }

            $existingOrders = $this->specialistOrderRepository->findBySpecialistIdAndOrderType((string) $specialist->getId(), OrderType::INCLUSION);

            if (count($existingOrders)) {
                yield false;
                continue;
            }

            try {
                $this->specialistOrderGeneratorService->generateInclusionOrder($specialist);
                yield true;
            } catch (Throwable $e) {
                $this->logger->error("Не удалось сгенерировать документ для специалиста с ID {$specialist->getId()}: {$e->getMessage()}");
                yield false;
            }
        }

        return;
    }

    /**
     * Получить количество пользователей для генерации приказа о включении.
     *
     * @param DateTimeInterface $dateFrom
     *
     * @return int
     */
    public function getNumberOfSpecialistForInclusion(DateTimeInterface $dateFrom): int
    {
        return count($this->specialistRepository->findSpecialistsIDsByCreationDateRange($dateFrom));
    }

    /**
     * Генерация приказов о выдаче документа.
     *
     * @param DateTimeInterface $dateFrom
     */
    public function generateIssueOfADocumentOrders(DateTimeInterface $dateFrom): Generator
    {
        $documentTemplates = $this->documentTemplateRepository->findAll();

        /** @var DocumentTemplate $documentTemplate */
        foreach ($documentTemplates as $documentTemplate) {
            $documentsIDs = $this->specialistDocumentRepository->findSpecialistsIDsFromDateAndByTemplate($dateFrom, $documentTemplate->getId());

            // Пропускаем, если не найдено документов для данной даты и шаблона.
            if (empty($documentsIDs)) {
                yield false;
                continue;
            }

            $documents = [];
            foreach ($documentsIDs as $documentID) {
                $documents[] = $this->specialistDocumentRepository->find($documentID);
            }

            try {
                $this->specialistOrderGeneratorService->generateIssueOfADocumentOrder($documents);
                yield true;
            } catch (Throwable $e) {
                $this->logger->error("Не удалось сгенерировать документ для шаблона с ID {$documentTemplate->getId()}: {$e->getMessage()}");
                yield false;
            }
        }

        return;
    }

    /**
     * Получить количество документов для генерации приказов о выдаче.
     *
     * @param DateTimeInterface $dateFrom
     *
     * @return int
     */
    public function getNumberOfOrdersToIssue(DateTimeInterface $dateFrom): int
    {
        $totalAmount = 0;
        $documentTemplates = $this->documentTemplateRepository->findAll();

        /** @var DocumentTemplate $documentTemplate */
        foreach ($documentTemplates as $documentTemplate) {
            $totalAmount += count($this->specialistDocumentRepository->findSpecialistsIDsFromDateAndByTemplate($dateFrom, $documentTemplate->getId()));
        }

        return $totalAmount;
    }
}
