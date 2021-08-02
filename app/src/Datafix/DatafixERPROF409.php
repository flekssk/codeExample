<?php

namespace App\Datafix;

use App\Domain\Entity\Skill\Skill;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DatafixERPROF409.
 *
 * @package App\Datafix
 */
class DatafixERPROF409 implements DatafixInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * DatafixERPROF409 constructor.
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
        $output->write('Удаление старых навыков...' . PHP_EOL);

        $this->entityManager
            ->createQueryBuilder()
            ->delete()
            ->from(Skill::class, 's')
            ->where('s.macroSkillId IS NULL')
            ->getQuery()
            ->execute();

        $output->write('Удаление старых навыков успешно завершено.' . PHP_EOL);
    }
}
