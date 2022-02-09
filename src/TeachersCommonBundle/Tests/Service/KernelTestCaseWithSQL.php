<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Tests\Service;

use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

class KernelTestCaseWithSQL extends KernelTestCase
{
    protected ManagerRegistry $doctrine;

    public function setUp(): void
    {
        self::bootKernel();

        /** @var ManagerRegistry $doctrine */
        $doctrine = self::$container->get('doctrine');
        $this->doctrine = $doctrine;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification
     */
    protected function sqlQuery(string $query, array $params = [], array $types = []): array
    {
        return $this->getConnection()->fetchAllAssociative($query, $params, $types);
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     */
    protected function sqlExec(string $query, array $params = [], array $types = []): int
    {
        return $this->getConnection()->executeStatement($query, $params, $types);
    }

    protected function getConnection(): Connection
    {
        /** @var Connection $conn */
        $conn = $this->doctrine->getConnection();

        return $conn;
    }

    protected function restartSequence(string $sequenceName, int $initialValue = 1): void
    {
        $this->sqlExec(
            sprintf(
                'ALTER SEQUENCE %s RESTART WITH %d',
                $this->getConnection()->quoteIdentifier($sequenceName),
                $initialValue
            )
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->getConnection()->close();
    }
}
