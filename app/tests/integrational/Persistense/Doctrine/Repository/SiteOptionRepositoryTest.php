<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\SiteOption;
use Codeception\TestCase\Test;

/**
 * Class SiteOptionRepositoryTest.
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository
 * @covers \App\Infrastructure\Persistence\Doctrine\Repository\SiteOptionRepository
 */
class SiteOptionRepositoryTest extends Test
{
    /**
     * Test get.
     *
     * @dataProvider correctOptionNameValueDataProvider
     *
     * @param string $name
     * @param string $value
     */
    public function testGet(string $name, string $value): void
    {
        $repository = $this->createRepository();

        $option = $repository->findOneByName($name);

        $this->assertInstanceOf(SiteOption::class, $option);
        $this->assertEquals($value, $option->getValue());
    }

    /**
     * @return \string[][]
     */
    public function correctOptionNameValueDataProvider(): array
    {
        return [
            [
                'mainPageText',
                'mainPageText',
            ],
        ];
    }

    /**
     * @return \string[][]
     */
    public function incorrectOptionNameValueDataProvider(): array
    {
        return [
            [
                'test',
                'test',
            ],
        ];
    }

    /**
     * @return SiteOptionRepository
     */
    private function createRepository(): SiteOptionRepository
    {
        /** @var \Codeception\Module\Symfony $module */
        $module = $this->getModule('Symfony');

        $container = $module->kernel->getContainer();

        return $container->get(SiteOptionRepository::class);
    }
}
