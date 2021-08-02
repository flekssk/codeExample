<?php

namespace App\Application\Specialist\SpecialistOrder\SpecialistOrderGenerator;

use App\Application\Specialist\SpecialistOrder\SpecialistOrderGenerator\Exception\OrderGeneratorException;
use App\Domain\Entity\Specialist\Order;
use App\Domain\Entity\Specialist\Specialist;
use App\Domain\Entity\Specialist\ValueObject\OrderNumber;
use App\Domain\Entity\Specialist\ValueObject\OrderType;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use App\Domain\Repository\NotFoundException;
use App\Domain\Repository\Specialist\SpecialistOrderRepositoryInterface;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use App\Domain\Service\Specialist\SpecialistStatusCalcServiceInterface;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class SpecialistOrderGeneratorService.
 *
 * @package App\Application\Specialist\SpecialistOrder.
 */
class SpecialistOrderGeneratorService implements SpecialistOrderGeneratorServiceInterface
{
    /**
     * @var SpecialistOrderRepositoryInterface
     */
    private SpecialistOrderRepositoryInterface $specialistOrderRepository;

    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $specialistRepository;

    /** @var SpecialistStatusCalcServiceInterface */
    private SpecialistStatusCalcServiceInterface $calcService;

    /**
     * SpecialistOrderGeneratorService constructor.
     * @param SpecialistOrderRepositoryInterface $specialistOrderRepository
     * @param SpecialistRepositoryInterface $specialistRepository
     * @param SpecialistStatusCalcServiceInterface $calcService
     */
    public function __construct(
        SpecialistOrderRepositoryInterface $specialistOrderRepository,
        SpecialistRepositoryInterface $specialistRepository,
        SpecialistStatusCalcServiceInterface $calcService
    ) {
        $this->specialistOrderRepository = $specialistOrderRepository;
        $this->specialistRepository = $specialistRepository;
        $this->calcService = $calcService;
    }

    /**
     * @inheritDoc
     */
    public function generateInclusionOrder(Specialist $specialist): void
    {
        $currentDate = new DateTimeImmutable();
        $orderNumber = OrderNumber::createFromDateAndSpecialistId($currentDate, $specialist->getId());

        // Создание и сохранение сущности.
        $order = new Order(
            $orderNumber,
            new OrderType(OrderType::INCLUSION),
            $currentDate,
            new ArrayCollection([$specialist])
        );

        $this->specialistOrderRepository->save($order);
    }

    /**
     * @inheritDoc
     */
    public function generateIssueOfADocumentOrder(array $documents): void
    {
        // Проверка на пустоту входящего массива.
        if (empty($documents)) {
            throw new OrderGeneratorException('Массив $documents не может быть пустым');
        }

        // Получить ID последнего приказа, что бы сгенерировать номер для нового приказа на его основе.
        $lastOrder = $this->specialistOrderRepository->findOneBy([], ['id' => 'desc']);
        $lastOrderId = $lastOrder ? $lastOrder->getId() : 0;

        // Текущая дата и номер приказа.
        $currentDate = new DateTimeImmutable();
        $orderNumber = OrderNumber::createNumberForIssueOfADocumentOrder($currentDate, reset($documents)->getNumber(), $lastOrderId);

        // Собирается список специалистов.
        $specialists = [];
        /** @var SpecialistDocument $document */
        foreach ($documents as $document) {
            $id = $document->getSpecialistId();

            // Получение специалиста из БД.
            try {
                $specialist = $this->specialistRepository->get($id);
            } catch (NotFoundException $e) {
                continue;
            }

            // Проверка на наличие специалиста в списке (такое возможно, так как приказы одного типа,
            // например "Диплом", никак между собой не отличаются.
            if (in_array($specialist, $specialists, true)) {
                continue;
            }

            $specialists[] = $specialist;
        }

        // Создание приказа при условии наличия специалистов.
        if (count($specialists)) {
            // Создание и сохранение сущности.
            $order = new Order(
                $orderNumber,
                new OrderType(OrderType::ISSUE_OF_A_DOCUMENT),
                $currentDate,
                new ArrayCollection($specialists),
                reset($documents)->getTemplateId()
            );

            $this->specialistOrderRepository->save($order);
        }
    }
}
