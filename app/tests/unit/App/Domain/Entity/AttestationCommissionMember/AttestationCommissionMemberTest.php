<?php

namespace App\Tests\unit\App\Domain\Entity\AttestationCommissionMember;

use App\Domain\Entity\AttestationCommissionMember\AttestationCommissionMember;
use App\Domain\Entity\ValueObject\ImageUrl;
use Codeception\Test\Unit;

/**
 * Class AttestationCommissionMemberTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\AttestationCommissionMember
 * @covers \App\Domain\Entity\AttestationCommissionMember\AttestationCommissionMember
 */
class AttestationCommissionMemberTest extends Unit
{
    /**
     * Test create entity.
     */
    public function testCreateEntity()
    {
        $member = new AttestationCommissionMember();
        $member->setId('1');
        $member->setFirstName('First Name');
        $member->setSecondName('Second Name');
        $member->setMiddleName('Middle Name');
        $member->setImageUrl('https://via.placeholder.com/150');
        $member->setDescription('Заместитель директора Департамента развития социального страхования Минтруда России');
        $member->setIsLeader(true);
        $member->setActive(true);

        $this->assertEquals('1', $member->getId());
        $this->assertEquals('First Name', $member->getFirstName());
        $this->assertEquals('Second Name', $member->getSecondName());
        $this->assertEquals('Middle Name', $member->getMiddleName());
        $this->assertEquals('https://via.placeholder.com/150', $member->getImageUrl());
        $this->assertEquals('Заместитель директора Департамента развития социального страхования Минтруда России', $member->getDescription());
        $this->assertEquals(true, $member->isLeader());
        $this->assertEquals(true, $member->isActive());
    }
}
