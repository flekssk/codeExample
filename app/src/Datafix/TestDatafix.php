<?php

namespace App\Datafix;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TestDatafix.
 *
 * @package App\Datafix
 */
class TestDatafix implements DatafixInterface
{
    /**
     * @inheritDoc
     */
    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->write('Test datafix done' . PHP_EOL);
    }
}
