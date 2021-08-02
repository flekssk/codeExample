<?php

namespace App\Tests\integrational\App\Application\Skill\SkillGet;

use App\Application\Skill\SkillGet\Dto\SkillResultDto;
use App\Application\Skill\SkillGet\SkillGetService;
use Codeception\TestCase\Test;

/**
 * Class SkillGetServiceTest.
 *
 * @package App\Tests\integrational\App\Application\Skill\SkillGet
 * @covers \App\Application\Skill\SkillGet\SkillGetService
 */
class SkillGetServiceTest extends Test
{
    /**
     * @throws \Codeception\Exception\ModuleException
     */
    public function testGetAllMacroSkills()
    {
        $skillGetService = $this->getService();
        $result = $skillGetService->getAllMacroSkills();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Ключевые навыки', $result);
        $this->assertArrayHasKey('Профессиональный рост', $result);

        $element = reset($result);
        $this->assertIsArray($element);
        $this->assertArrayHasKey('name', $element);
        $this->assertArrayHasKey('elements', $element);

        $skill = reset($element['elements']);
        $this->assertIsArray($skill);
        $this->assertArrayHasKey('macroSkillId', $skill);
        $this->assertArrayHasKey('macroSkillName', $skill);
        $this->assertArrayHasKey('macroWeight', $skill);
        $this->assertArrayHasKey('macroTypeName', $skill);
    }

    /**
     * @throws \Codeception\Exception\ModuleException
     */
    public function testGetAllSortedByMacroSkills()
    {
        $skillGetService = $this->getService();
        $result = $skillGetService->getAllSortedByMacroSkills();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Ключевые навыки', $result);
        $this->assertArrayHasKey('Профессиональный рост', $result);

        $macroElement = reset($result);
        $this->assertIsArray($macroElement);
        $this->assertArrayHasKey('name', $macroElement);
        $this->assertArrayHasKey('macroElements', $macroElement);

        $macroSkill = reset($macroElement['macroElements']);
        $this->assertIsArray($macroSkill);
        $this->assertArrayHasKey('name', $macroSkill);
        $this->assertArrayHasKey('elements', $macroSkill);

        $skill = reset($macroSkill['elements']);
        $this->assertIsArray($skill);
        $this->assertArrayHasKey('id', $skill);
        $this->assertArrayHasKey('name', $skill);
        $this->assertArrayHasKey('weight', $skill);
    }

    /**
     * @throws \Codeception\Exception\ModuleException
     */
    public function testGetBySpecialistId()
    {
        $skillGetService = $this->getService();
        $result = $skillGetService->getBySpecialistId('1990299');

        $this->assertIsArray($result);

        $macroType = reset($result);
        $this->assertArrayHasKey('id', $macroType);
        $this->assertArrayHasKey('name', $macroType);
        $this->assertArrayHasKey('macros', $macroType);
        $this->assertArrayHasKey('description', $macroType);

        $macros = reset($macroType['macros']);
        $this->assertArrayHasKey('id', $macros);
        $this->assertArrayHasKey('name', $macros);
        $this->assertArrayHasKey('skills', $macros);

        $skill = reset($macros['skills']);
        $this->assertArrayHasKey('id', $skill);
        $this->assertArrayHasKey('name', $skill);
        $this->assertArrayHasKey('percent', $skill);
        $this->assertArrayHasKey('degradation', $skill);
        $this->assertArrayHasKey('improveLink', $skill);
    }

    /**
     * @throws \Codeception\Exception\ModuleException
     */
    public function testGetAll()
    {
        $skillGetService = $this->getService();
        $result = $skillGetService->getAll();

        $this->assertIsArray($result);

        $skill = reset($result);
        $this->assertInstanceOf(SkillResultDto::class, $skill);
        $this->assertObjectHasAttribute('id', $skill);
        $this->assertObjectHasAttribute('name', $skill);
    }

    /**
     * @return SkillGetService
     *
     * @throws \Codeception\Exception\ModuleException
     */
    private function getService(): SkillGetService
    {
        /** @var \Codeception\Module\Symfony $module */
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        return $container->get(SkillGetService::class);
    }
}
