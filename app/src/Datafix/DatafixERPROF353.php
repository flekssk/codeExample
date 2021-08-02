<?php

namespace App\Datafix;

use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DatafixERPROF353.
 *
 * @package App\Datafix
 */
class DatafixERPROF353 implements DatafixInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * DatafixERPROF353 constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->write('Запустили очистку дубликатов документов' . PHP_EOL);

        $duplicatedDocuments = $this->entityManager
            ->createQueryBuilder()
            ->select('sd.number as number')
            ->from(SpecialistDocument::class, 'sd')
            ->groupBy('sd.specialistId, sd.number')
            ->having('count(sd.number) > 1')
            ->getQuery()
            ->execute();

        if (count($duplicatedDocuments)) {
            $duplicatedDocumentNumbers = array_map(
                static function ($item) {
                    return "'" . $item['number'] . "'";
                },
                $duplicatedDocuments
            );

            $output->write('Найдено ' . count($duplicatedDocuments) . ' документов с дубликатами' . PHP_EOL);

            $excludeIds = $this->entityManager
                ->createQueryBuilder()
                ->select('min(sd.id) as id')
                ->from(SpecialistDocument::class, 'sd')
                ->where('sd.number IN (' . implode(', ', $duplicatedDocumentNumbers) . ')')
                ->groupBy('sd.number')
                ->getQuery()
                ->execute();

            $excludeIds = array_map(
                static function ($item) {
                    return $item['id'];
                },
                $excludeIds
            );

            $rowsAffected = 0;
            if ($excludeIds) {
                $rowsAffected = $this->entityManager
                    ->createQueryBuilder()
                    ->delete()
                    ->from(SpecialistDocument::class, 'sd')
                    ->where('sd.number IN (' . implode(', ', $duplicatedDocumentNumbers) . ')')
                    ->andWhere('sd.id NOT IN (' . implode(', ', $excludeIds) . ')')
                    ->getQuery()
                    ->execute();
            }

            $output->write('Удалено ' . $rowsAffected . ' дубликатов ' . PHP_EOL);
        } else {
            $output->write('Дублей документов не найдено ' . PHP_EOL);
        }
    }
}
