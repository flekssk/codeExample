<?php

namespace App\UI\Form;

use App\Domain\Repository\School\SchoolRepositoryInterface;
use App\Domain\Repository\Skill\SkillRepositoryInterface;
use App\Domain\Repository\SkillImproveLink\SkillImproveLinkRepositoryInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class SkillImproveLinkCollectionForm.
 *
 * @package App\UI\Form
 */
class SkillImproveLinkCollectionForm extends CollectionType
{
    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;

    /**
     * @var SkillRepositoryInterface
     */
    private SkillRepositoryInterface $skillRepository;

    /**
     * @var SchoolRepositoryInterface
     */
    private SchoolRepositoryInterface $schoolRepository;

    /**
     * @var SkillImproveLinkRepositoryInterface
     */
    private SkillImproveLinkRepositoryInterface $skillImproveLinkRepository;

    /**
     * SkillImproveLinkCollectionForm constructor.
     *
     * @param RequestStack $requestStack
     * @param SkillRepositoryInterface $skillRepository
     * @param SchoolRepositoryInterface $schoolRepository
     * @param SkillImproveLinkRepositoryInterface $skillImproveLinkRepository
     */
    public function __construct(
        RequestStack $requestStack,
        SkillRepositoryInterface $skillRepository,
        SchoolRepositoryInterface $schoolRepository,
        SkillImproveLinkRepositoryInterface $skillImproveLinkRepository
    ) {
        $this->requestStack = $requestStack;
        $this->skillRepository = $skillRepository;
        $this->schoolRepository = $schoolRepository;
        $this->skillImproveLinkRepository = $skillImproveLinkRepository;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Заполнение формы при ее отображении.
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $request = $this->requestStack->getCurrentRequest();

            if (!$request) {
                return;
            }

            $skillId = $request->query->get('id');
            $skillEntity = $this->skillRepository->find($skillId);

            if (!$skillEntity) {
                return;
            }

            $skillImproveLinks = $this->skillImproveLinkRepository->findBySkillId($skillEntity->getId());

            $data = [];
            foreach ($skillImproveLinks as $skillImproveLink) {
                $schoolId = $skillImproveLink->getSchoolId();
                $data[] = [
                    'schoolId' => $this->schoolRepository->find($schoolId),
                    'link' => $skillImproveLink->getLink(),
                ];
            }

            $event->setData($data);
        });
        parent::buildForm($builder, $options);
    }
}
