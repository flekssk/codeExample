<?php

namespace App\Tests\integrational\Application\Position;

use Codeception\TestCase\Test;
use App\Domain\Entity\Position\Position;
use App\Application\Position\PositionService;
use App\Infrastructure\Persistence\Doctrine\Repository\Position\PositionRepository;
use App\Infrastructure\HttpClients\Crm\CrmProxyInterface;
use App\Application\Position\Assembler\PositionResultAssembler;

/**
 * Class PositionServiceTest.
 *
 * @covers \App\Application\Position\PositionService
 */
class PositionServiceTest extends Test
{

    /**
     * Check update data in DB.
     * Данный тест нужно отрефакторить. Первая проблема - при добавлении записей в фикстуру position кол-во сравневыемых
     * записей становится больше на 1 (нужно править expected в assert). Вторая проблема - в тесте вызывается метод
     * replace репозитория PositionRepository.php, данный метод ничего не знает о параметре id (при это в фикстурах очевидно указан id записи в таблице),
     * соответственно возникает ошибка: [Doctrine\DBAL\Exception\UniqueConstraintViolationException]
     * An exception occurred while executing 'INSERT INTO positions (id, name, guid) VALUES (?, ?, ?)' with params [1, "Name", "ID_3"]:
     * SQLSTATE[23505]: Unique violation: 7 ERROR:  duplicate key value violates unique constraint "positions_pkey" DETAIL:  Key (id)=(1) already exists.
     * @skip
     */
    public function testCheckUpdateDataInDB()
    {
        $crmProxy = new class () implements CrmProxyInterface {

            public function getPositions(): array
            {
                $result = [];
                for ($i = 3; $i < 5; $i++) {
                    $position = new Position();
                    $position->setId($i);
                    $position->setGuid("ID_{$i}");
                    $position->setName('Name');
                    $result[] = $position;
                }

                return $result;
            }
        };

        $repository = $this->getRepository();
        $assembler = new PositionResultAssembler();
        $positionService = new PositionService($crmProxy, $repository, $assembler);
        $positionService->update();

        $this->assertEquals(4, $repository->count([]));
    }

    /**
     * @return PositionRepository
     * @throws \Codeception\Exception\ModuleException
     */
    private function getRepository(): PositionRepository
    {
        /** @var \Codeception\Module\Symfony $module */
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        return $container->get(PositionRepository::class);
    }
}
