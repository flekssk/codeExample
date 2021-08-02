<?php

namespace App\Domain\Repository\Skill;

use App\Domain\Entity\Skill\Skill;

/**
 * Interface SkillRepositoryInterface.
 *
 * @method Skill[]    findAll()
 * @method Skill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Domain\Repository\Skill
 */
interface SkillRepositoryInterface
{
    /**
     * @param Skill $skill
     */
    public function save(Skill $skill): void;

    /**
     * @param Skill $skill
     *
     * @return Skill
     */
    public function replace(Skill $skill): Skill;

    /**
     * @param string $id
     *
     * @return Skill|null
     */
    public function findById(string $id): ?Skill;

    /**
     * @return Skill[]
     */
    public function getSkillsWithMacroSkillId(): array;

    /**
     * @return array
     */
    public function getMacroSkills(): array;

    /**
     * @param string $id
     *
     * @return array
     */
    public function getAllSkillsByMacroSkillId(string $id): array;
}
