<?php

namespace App\Tests\unit\App\Domain\Entity\Skill;

use App\Domain\Entity\Skill\Skill;
use Codeception\Test\Unit;

/**
 * Class DocumentTypeTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\Skill
 * @covers  \App\Domain\Entity\Skill\Skill
 */
class SkillTest extends Unit
{
    /**
     * Test create entity.
     */
    public function testCreateEntity()
    {
        $skill = new Skill(
            '1',
            'Name',
            null,
            null,
            null,
            null,
            null,
            null
        );


        $this->assertEquals('1', $skill->getId());
        $this->assertEquals('Name', $skill->getName());

        $skill->setName('AnotherName');
        $this->assertEquals('AnotherName', $skill->getName());
    }
}
