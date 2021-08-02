<?php

namespace App\Tests\unit\App\Domain\Entity\EntityRevision;

use App\Domain\Entity\EntityRevision\EntityRevision;
use App\Domain\Entity\EntityRevision\Exception\EntityRevisionIncorrectOperationException;
use Codeception\Test\Unit;

/**
 * Class EntityRevisionTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\EntityRevisionTest
 * @covers  \App\Domain\Entity\EntityRevision\EntityRevision
 */
class EntityRevisionTest extends Unit
{
    /**
     * Test create entity.
     */
    public function testCreateEntity()
    {
        $entity = new EntityRevision(
            1,
            'type',
            'content',
            EntityRevision::OPERATION_UPDATE,
            1,
        );

        $this->assertEquals(1, $entity->getEntityId());
        $this->assertEquals('type', $entity->getEntityType());
        $this->assertEquals('content', $entity->getContent());
        $this->assertEquals(EntityRevision::OPERATION_UPDATE, $entity->getOperation());
        $this->assertEquals(1, $entity->getUserId());
    }

    /**
     * Creating EntityRevision with incorrect operation should fail.
     */
    public function testCreatingEntityRevisionWithIncorrectOperationShouldFail()
    {
        $this->expectException(EntityRevisionIncorrectOperationException::class);

        new EntityRevision(
            1,
            'type',
            'content',
            'test operation',
            1,
        );
    }
}
