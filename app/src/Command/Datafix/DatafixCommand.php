<?php

namespace App\Command\Datafix;

use App\Datafix\DatafixInterface;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DatafixCommand.
 *
 * @package App\Command\Datafix
 */
class DatafixCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * DatafixCommand constructor.
     *
     * @param ContainerInterface $container
     * @param LoggerInterface $logger
     */
    public function __construct(ContainerInterface $container, LoggerInterface $logger)
    {
        $this->container = $container;
        $this->logger = $logger;

        parent::__construct('datafix');
    }

    /**
     * Configuration.
     */
    protected function configure(): void
    {
        $this->setName('app:datafix:execute')
            ->setDescription('Выполняет datafix')
            ->addArgument('datafixClass', InputArgument::REQUIRED, 'Класс datafix');
    }

    /**
     * Аргумент datafixClass должен быть именем класса без namespace
     * Вид команды для запуска "app:datafix:execute --x-host='ru-ru.er_glavbukh_ru' TextDatafix"
     *
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $className = $input->getArgument('datafixClass');
        } catch (InvalidArgumentException $exception) {
            throw new InvalidArgumentException(
                'Укажите аргумент "datafixClass" - название класса с реализацией работы с данными (имя класса без namespace, например TextDatafix).'
            );
        }

        $className = is_string($className) ? '\\App\\Datafix\\' .  $className : '';

        if (!class_exists($className)) {
            throw new InvalidArgumentException(sprintf('Datafix с классом %s не существует.', $className));
        }

        $datafix = $this->container->get(trim($className, '\\'));
        if (!$datafix instanceof DatafixInterface) {
            throw new InvalidArgumentException(sprintf('Класс должен реализовывать интерфейс %s', DatafixInterface::class));
        }

        $output->writeln(sprintf('Запущен datafix %s...', $className));
        $this->logger->warning(sprintf('Запущен datafix %s...', $className));

        $datafix->execute($input, $output);

        return 0;
    }
}
