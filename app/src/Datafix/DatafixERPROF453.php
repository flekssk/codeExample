<?php

namespace App\Datafix;

use App\Domain\Entity\SiteOption;
use App\Domain\Repository\SiteOptionRepositoryInterface;
use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DatafixERPROF453.
 *
 * @package App\Datafix
 */
class DatafixERPROF453 implements DatafixInterface
{
    /**
     * @var SiteOptionRepositoryInterface
     */
    private SiteOptionRepositoryInterface $siteOptionRepository;

    /**
     * DatafixERPROF453 constructor.
     *
     * @param SiteOptionRepositoryInterface $siteOptionRepository
     */
    public function __construct(SiteOptionRepositoryInterface $siteOptionRepository)
    {
        $this->siteOptionRepository = $siteOptionRepository;
    }

    /**
     * @inheritDoc
     */
    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $siteOption = new SiteOption('searchPagePositionPlaceholder');
        $siteOption->setDescription('Значение плейсхолдера у поля "Должность" на странице поиска');
        $siteOption->setValue('Бухгалтер');

        try {
            $this->siteOptionRepository->save($siteOption);
        } catch (Exception $e) {
            $output->write('Ошибка при выполнении датафикса:' . $e->getMessage() . PHP_EOL);
        }
    }
}
