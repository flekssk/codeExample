<?php

namespace App\Datafix;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface DatafixInterface.
 *
 * @package App\Datafix
 */
interface DatafixInterface
{
    /**
     * Метод применения datafix
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output): void;
}
