<?php

namespace App\Tests\unit\App\Domain\Entity\SkillImproveLink;

use App\Domain\Entity\SkillImproveLink\SkillImproveLink;
use Codeception\Test\Unit;

/**
 * Class SkillImproveLinkTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\SkillImproveLink
 * @covers  \App\Domain\Entity\SkillImproveLink\SkillImproveLink
 */
class SkillImproveLinkTest extends Unit
{
    /**
     * Test create entity.
     */
    public function testCreateEntity()
    {
        $skillImproveLink = new SkillImproveLink(
            '50683838-8456-4a81-9a4e-05fdedd9d3e1',
            1,
            'https://www.google.com/'
        );

        $this->assertEquals('50683838-8456-4a81-9a4e-05fdedd9d3e1', $skillImproveLink->getSkillId());
        $this->assertEquals(1, $skillImproveLink->getSchoolId());
        $this->assertEquals('https://www.google.com/', $skillImproveLink->getLink());
    }
}
