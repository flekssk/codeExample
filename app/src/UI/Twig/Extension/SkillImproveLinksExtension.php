<?php

namespace App\UI\Twig\Extension;

use App\Domain\Entity\Skill\Skill;
use App\Domain\Repository\School\SchoolRepositoryInterface;
use App\Domain\Repository\SkillImproveLink\SkillImproveLinkRepositoryInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class SkillImproveLinksExtension.
 *
 * @package App\UI\Twig\Extension
 */
class SkillImproveLinksExtension extends AbstractExtension
{
    /**
     * @var SkillImproveLinkRepositoryInterface
     */
    private SkillImproveLinkRepositoryInterface $skillImproveLinkRepository;

    /**
     * @var SchoolRepositoryInterface
     */
    private SchoolRepositoryInterface $schoolRepository;

    /**
     * SkillImproveLinksExtension constructor.
     *
     * @param SkillImproveLinkRepositoryInterface $skillImproveLinkRepository
     * @param SchoolRepositoryInterface $schoolRepository
     */
    public function __construct(
        SkillImproveLinkRepositoryInterface $skillImproveLinkRepository,
        SchoolRepositoryInterface $schoolRepository
    ) {
        $this->skillImproveLinkRepository = $skillImproveLinkRepository;
        $this->schoolRepository = $schoolRepository;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_skill_improve_links_by_skill', [$this, 'getSkillImproveLinksBySkill']),
        ];
    }

    /**
     * Получить список ссылок для определенного навыка.
     *
     * @param Skill $skill
     * @return array
     */
    public function getSkillImproveLinksBySkill(Skill $skill): array
    {
        $skillImproveLinks = $this->skillImproveLinkRepository->findBySkillId($skill->getId());

        $data = [];
        foreach ($skillImproveLinks as $skillImproveLink) {
            $schoolId = $skillImproveLink->getSchoolId();
            $schoolEntity = $this->schoolRepository->find($schoolId);
            $school = $schoolEntity ? $schoolEntity->getName() : '';

            $data[] = [
                'school' => $school,
                'link' => $skillImproveLink->getLink(),
            ];
        }

        return $data;
    }
}
