<?php

namespace App\Command\DataTransfer;

use App\Domain\Entity\Specialist\Specialist;
use App\Domain\Entity\Specialist\ValueObject\Status;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SpecialistDataTransferCommand.
 *
 * @package App\Command\DataTransfer
 */
class SpecialistDataTransferCommand extends Command
{
    /**
     * Путь до файла с данными.
     */
    private const FILE_PATH = '/var/www/src/Command/DataTransfer/data/erglav_reestr.csv';

    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $specialistRepository;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * SpecialistDataTransferCommand constructor.
     *
     * @param SpecialistRepositoryInterface $specialistRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        SpecialistRepositoryInterface $specialistRepository,
        LoggerInterface $logger
    ) {
        $this->specialistRepository = $specialistRepository;
        $this->logger = $logger;

        parent::__construct();
    }

    /**
     * Configuration.
     */
    protected function configure(): void
    {
        $this->setName('app:data-transfer:specialist')
            ->setDescription('Загрузка данных о специалистах')
            ->addArgument('filePath', InputArgument::OPTIONAL, 'Путь до CSV файла с данными');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     *
     * @throws Exception
     *
     * @psalm-suppress PossiblyInvalidCast
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('filePath') ?: self::FILE_PATH;

        $csvReader = new CsvReader((string) $filePath);

        foreach ($csvReader->getData() as $data) {
            if (!isset($data['user_id'])) {
                continue;
            }

            $id = $data['user_id'];

            $specialistExists = $this->specialistRepository->has($id);
            if ($specialistExists) {
                $this->logger->warning("Специалист с ID {$id} уже существует.");
                continue;
            }

            $specialist = new Specialist($id);

            // По умолчанию устанавливается 0, обновить статус можно командой app:status:update.
            $specialist->setStatus(new Status(0));

            $this->specialistRepository->save($specialist);
        }

        return 0;
    }
}
