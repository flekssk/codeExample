<?php

namespace App\UI\Controller\EasyAdmin;

use App\Domain\Entity\Skill\Skill;
use App\Domain\Repository\SkillImproveLink\SkillImproveLinkRepositoryInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use App\Domain\Entity\SkillImproveLink\SkillImproveLink;

/**
 * Class SkillController.
 *
 * @package App\UI\Controller\EasyAdmin
 */
class SkillController extends EasyAdminController
{
    /**
     * @var SkillImproveLinkRepositoryInterface
     */
    private SkillImproveLinkRepositoryInterface $skillImproveLinkRepository;

    /**
     * SkillController constructor.
     *
     * @param SkillImproveLinkRepositoryInterface $skillImproveLinkRepository
     */
    public function __construct(SkillImproveLinkRepositoryInterface $skillImproveLinkRepository)
    {
        $this->skillImproveLinkRepository = $skillImproveLinkRepository;
    }

    /**
     * Сохранение SkillImproveLink при сохранении навыка.
     *
     * @param object $entity
     */
    protected function updateEntity($entity): void
    {
        parent::updateEntity($entity);

        $params = $this->request->get('skill');
        $skillImproveLinks = $params['skillImproveLinks'];

        // Если пришел null - значит форма пустая и нужно удалить все связанные с навыком ссылки.
        if ($skillImproveLinks === null) {
            $this->skillImproveLinkRepository->deleteBy(['skillId' => $entity->getId()]);
        }

        if (is_array($skillImproveLinks)) {
            $this->skillImproveLinkRepository->beginTransaction();

            $this->skillImproveLinkRepository->deleteBy(['skillId' => $entity->getId()]);

            foreach ($skillImproveLinks as $skillImproveLink) {
                $newEntity = new SkillImproveLink(
                    $entity->getId(),
                    $skillImproveLink['schoolId'],
                    $skillImproveLink['link']
                );

                $this->skillImproveLinkRepository->save($newEntity);
            }

            $this->skillImproveLinkRepository->commit();
        }
    }
}
