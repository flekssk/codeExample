<?php

namespace App\Tests\unit\App\Application\Skill\Assembler;

use App\Application\Skill\SkillSort\Assembler\SkillSortAssembler;
use App\Application\Skill\SkillSort\Dto\SkillSortDto;
use Codeception\TestCase\Test;

/**
 * Class SkillSortAssemblerTest.
 *
 * @package App\Tests\unit\App\Application\Skill\Assembler
 *
 * @covers \App\Application\Skill\SkillSort\Assembler\SkillSortAssembler
 */
class SkillSortAssemblerTest extends Test
{
    /**
     * @param array $data
     *
     * @dataProvider skillSortDataProvider
     */
    public function testAssemble(array $data): void
    {
        $assembler = new SkillSortAssembler();

        $skillSortDto = $assembler->assemble($data);

        $this->assertInstanceOf(SkillSortDto::class, $skillSortDto);

        $this->assertEquals($data['id'], $skillSortDto->id);
        $this->assertEquals($data['index'], $skillSortDto->index);
    }

    /**
     * @return array
     */
    public function skillSortDataProvider(): array
    {
        return [
            [
                [
                    'id' => 'test1',
                    'index' => 1,
                ],
                [
                    'id' => 'test2',
                    'index' => 2,
                ],
                [
                    'id' => 'test3',
                    'index' => 3,
                ],
            ],
        ];
    }
}
