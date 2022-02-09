<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TeachersTrainingCenterBundle\Service\ClearTestUserDataService;

class ClearTestUsersDataCommand extends Command
{
    /**
     * @var string[]
     */
    private array $testUsers;

    private ClearTestUserDataService $clearTestUserDataService;

    /**
     * @param string[] $testUsers
     */
    public function __construct(array $testUsers, ClearTestUserDataService $clearTestUserDataService)
    {
        parent::__construct();

        $this->testUsers = $testUsers;
        $this->clearTestUserDataService = $clearTestUserDataService;
    }

    protected function configure(): void
    {
        parent::configure();

        $this->setName('vimbox:core-rooms:clear-test-user-data');
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        foreach ($this->testUsers as $testUser) {
            $this->clearTestUserDataService->clearTestUserData((int) $testUser);
            $output->writeln("User $testUser data cleared\n");
        }
    }
}
