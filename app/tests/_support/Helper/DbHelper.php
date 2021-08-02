<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use Codeception\Module;
use Codeception\Module\Doctrine2;
use PHPUnit\Framework\Assert;

class DbHelper extends Module
{
    /**
     * @param string $table
     * @param array $values
     * @return array|null
     * @throws \Codeception\Exception\ModuleException
     */
    public function grabRecord(string $table, array $values = []): ?array
    {
        /** @var Doctrine2 $module */
        $module = $this->getModule('Doctrine2');
        $conn = $module->_getEntityManager()->getConnection();

        $qb = $conn->createQueryBuilder();
        $qb->select('*')
            ->from($table);

        foreach ($values as $key => $value) {
            $qb->andWhere("$key = :$key")
                ->setParameter($key, $value);
        }

        $result = $qb->execute()->fetchAll();

        if (!$result) {
            return null;
        }

        return $result[0];
    }

    /**
     * @param string $table
     * @return array|null
     * @throws \Codeception\Exception\ModuleException
     */
    public function grabNumRecords(string $table, array $values = []): ?int
    {
        /** @var Doctrine2 $module */
        $module = $this->getModule('Doctrine2');
        $conn = $module->_getEntityManager()->getConnection();

        $qb = $conn->createQueryBuilder();
        $qb->select('*')
            ->from($table);

        foreach ($values as $key => $value) {
            $qb->andWhere("$key = :$key")
                ->setParameter($key, $value);
        }

        $result = $qb->execute()->rowCount();

        if (!$result) {
            return null;
        }

        return $result;
    }

    /**
     * See data into DB.
     *
     * @param string $table
     * @param array $values
     * @throws \Codeception\Exception\ModuleException
     */
    public function seeRecord(string $table, array $values = []): void
    {
        if ($this->grabRecord($table, $values) === null) {
            Assert::fail("Could not find $table with " . json_encode($values));
        }

        $this->assertTrue(true);
    }


    /**
     * Dont see data into DB.
     *
     * @param string $table
     * @param array $values
     * @throws \Codeception\Exception\ModuleException
     */
    public function dontSeeRecord(string $table, array $values = []): void
    {
        if ($this->grabRecord($table, $values) !== null) {
            Assert::fail("Unexpectedly found matching $table with " . json_encode($values));
        }

        $this->assertTrue(true);
    }
}
