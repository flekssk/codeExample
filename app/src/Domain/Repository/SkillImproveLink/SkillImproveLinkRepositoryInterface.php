<?php

namespace App\Domain\Repository\SkillImproveLink;

use App\Domain\Entity\SkillImproveLink\SkillImproveLink;

/**
 * Interface SkillImproveLinkRepositoryInterface.
 *
 * @method SkillImproveLink[]    findAll()
 * @method SkillImproveLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillImproveLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillImproveLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Domain\Repository\SkillImproveLink
 */
interface SkillImproveLinkRepositoryInterface
{
    /**
     * @param SkillImproveLink $skillImproveLink
     */
    public function save(SkillImproveLink $skillImproveLink): void;

    /**
     * @param SkillImproveLink $skillImproveLink
     *
     * @return void
     */
    public function delete(SkillImproveLink $skillImproveLink): void;

    /**
     * @param array $criteria
     *
     * @return void
     */
    public function deleteBy(array $criteria): void;

    /**
     * @param string $id
     *
     * @return SkillImproveLink|null
     */
    public function findById(string $id): ?SkillImproveLink;

    /**
     * @param string $id
     *
     * @return SkillImproveLink[]
     */
    public function findBySkillId(string $id): array;

    /**
     * @param int $id
     *
     * @return SkillImproveLink[]
     */
    public function findBySchoolId(int $id): array;

    /**
     * @param string $skillId
     * @param int $schoolId
     *
     * @return SkillImproveLink|null
     */
    public function findBySkillIdAndSchoolId(string $skillId, int $schoolId): ?SkillImproveLink;

    /**
     * @return void
     */
    public function beginTransaction(): void;

    /**
     * @return void
     */
    public function commit(): void;

    /**
     * @return void
     */
    public function rollback(): void;
}
