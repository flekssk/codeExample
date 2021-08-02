<?php

namespace App\Application\Skill\SkillSort;

use App\Application\Skill\SkillSort\Dto\SkillSortDto;
use App\Domain\Repository\NotFoundException;
use App\Domain\Repository\Skill\SkillRepositoryInterface;

/**
 * Class SkillSortServiceInterface.
 *
 * @package App\Application\Skill\SkillSort
 */
class SkillSortService implements SkillSortServiceInterface
{
    /**
     * @var SkillRepositoryInterface
     */
    private SkillRepositoryInterface $skillRepository;

    /**
     * SkillSortService constructor.
     *
     * @param SkillRepositoryInterface $skillRepository
     */
    public function __construct(
        SkillRepositoryInterface $skillRepository
    ) {
        $this->skillRepository = $skillRepository;
    }

    /**
     * @param SkillSortDto $dto
     *
     * @return bool
     */
    public function saveMacroSkills(SkillSortDto $dto): bool
    {
        $skillEntities = $this->skillRepository->findBy(['macroSkillId' => $dto->id]);

        if (empty($skillEntities)) {
            throw new NotFoundException("Навыки с macro_skill_id = {$dto->id} не найден.");
        }

        foreach ($skillEntities as $skillEntity) {
            $skillEntity->setMacroWeight($dto->index);
            $this->skillRepository->save($skillEntity);
        }

        return true;
    }

    /**
     * @param SkillSortDto $dto
     *
     * @return bool
     */
    public function saveSkills(SkillSortDto $dto): bool
    {
        $skillEntity = $this->skillRepository->findOneBy(['id' => $dto->id]);

        if (!$skillEntity) {
            throw new NotFoundException("Навыки с id = {$dto->id} не найден.");
        }

        $skillEntity->setWeight($dto->index);
        $this->skillRepository->save($skillEntity);

        return true;
    }
}
