<?php

namespace App\Infrastructure\HttpClients\Skills;

/**
 * Class SkillsClientDummy.
 *
 * @package App\Infrastructure\HttpClients\Skills
 */
class SkillsClientDummy implements SkillsClientInterface
{
    public function getByRegistryId(string $guid)
    {
        $firstSkill = new \stdClass();
        $firstSkill->id = 14;
        $firstSkill->name = 'Test';
        $firstSkill->macro_skill_id = '1da80835-8566-4f43-a722-fa83af8223ef';
        $firstSkill->macro_skill_name = 'Бухгалтерский и налоговый учет, отчетность';
        $firstSkill->macro_type_id = '915db6b8-0d33-4c21-a2ba-2fcbee1d88ee';
        $firstSkill->macro_type_name = 'Профессиональный рост';
        $firstSkill->reestr_id = 'acb8e49a-c541-4311-9e29-c44917014a07';
        $firstSkill->reestr_name = 'Бухгалтерия коммерческая';

        $secondSkill = new \stdClass();
        $secondSkill->id = 15;
        $secondSkill->name = 'Test';
        $secondSkill->macro_skill_id = '1da80835-8566-4f43-a722-fa83af8223ef';
        $secondSkill->macro_skill_name = 'Бухгалтерский и налоговый учет, отчетность';
        $secondSkill->macro_type_id = '915db6b8-0d33-4c21-a2ba-2fcbee1d88ee';
        $secondSkill->macro_type_name = 'Профессиональный рост';
        $secondSkill->reestr_id = 'acb8e49a-c541-4311-9e29-c44917014a07';
        $secondSkill->reestr_name = 'Бухгалтерия коммерческая';

        return [
            $firstSkill,
            $secondSkill,
        ];
    }

    public function getByUserId(int $id)
    {
        return [];
    }
}
