<?php

namespace App\Command\Specialist;

use App\Application\Specialist\SpecialistSync\SpecialistSyncService;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SpecialistSyncCommand.
 *
 * @package App\Command\Specialist
 */
class SpecialistSyncCommand extends Command
{
    /**
     * Количество специалистов в батче для обновления.
     */
    private const BATCH_SIZE = 500;

    /**
     * Ожидание между запросами батчей в секундах.
     */
    private const TIMEOUT = 5;

    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $specialistRepository;

    /**
     * @var SpecialistSyncService
     */
    private SpecialistSyncService $specialistSyncService;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * SpecialistSyncCommand constructor.
     *
     * @param SpecialistRepositoryInterface $specialistRepository
     * @param SpecialistSyncService $specialistSyncService
     * @param LoggerInterface $logger
     */
    public function __construct(
        SpecialistRepositoryInterface $specialistRepository,
        SpecialistSyncService $specialistSyncService,
        LoggerInterface $logger
    ) {
        $this->specialistRepository = $specialistRepository;
        $this->specialistSyncService = $specialistSyncService;
        $this->logger = $logger;

        parent::__construct();
    }

    /**
     * Configuration.
     */
    protected function configure(): void
    {
        $this->setName('app:specialist:sync-id2')
            ->setDescription('Синхронизация данных о специалистах с id2')
            ->addOption('criteriaName', 'name', InputOption::VALUE_REQUIRED, 'Название критерия выборки специалистов')
            ->addOption('criteriaValue', 'val', InputOption::VALUE_REQUIRED, 'Значение критерия выборки специалистов')
            ->addOption('limit', 'l', InputOption::VALUE_REQUIRED, 'Общее количество специалистов для обновления')
            ->addOption('batchSize', 'b', null, 'Количество специалистов в батче для обновления, по умолчанию - 500')
            ->addOption('timeout', 't', null, 'Ожидание между запросами батчей в секундах, по умолчанию - 5');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     *
     * @psalm-suppress InvalidArgument
     * @psalm-suppress PossiblyInvalidCast
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $criteriaName = $input->getOption('criteriaName');
        $criteriaValue = !$input->getOption('criteriaValue') ? null : $input->getOption('criteriaValue');
        $limit = $input->getOption('limit') ?: null;
        $batchSize = (int) $input->getOption('batchSize') ?: self::BATCH_SIZE;
        $timeout = (int) $input->getOption('timeout') ?: self::TIMEOUT;

        // Стандартный критерий что бы собрать всех специалистов, если другой критерий не указан.
        $criteria = 's.id IS NOT NULL';
        if ($criteriaName && $criteriaValue) {
            $criteria = "s.{$criteriaName} = {$criteriaValue}";
        }

        $specialists = $this->specialistRepository->findAllSpecialistsIDs($criteria, $limit);

        $batches = array_chunk($specialists, $batchSize);

        $output->write('begin update...');
        $this->logger->info('Sync specialists - begin update...');

        foreach ($batches as $batch) {
            /** @var array $specialist */
            foreach ($batch as $specialist) {
                try {
                    $this->specialistSyncService->syncUserWithId2ById($specialist['id']);
                } catch (Exception $e) {
                    $this->logger->error("Ошибка при обработке специалиста с ID {$specialist['id']}: " . $e->getMessage());
                    continue;
                }
            }

            sleep($timeout);
        }

        $processedCount = count($specialists);

        $output->write('done.');
        $this->logger->warning("[CMD] Sync specialists - done, processed {$processedCount} item(s).");

        return 0;
    }
}
