<?php

namespace App\UI\Form;

use App\Domain\Entity\School\School;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;

/**
 * Class SkillImproveLinkForm.
 *
 * @package App\UI\Form
 */
class SkillImproveLinkForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('schoolId', EntityType::class, [
                'label' => 'Школа',
                'class' => School::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.id', 'ASC');
                },
                'constraints' => [
                    new NotBlank(),
                    new Required(),
                ],
            ])
            ->add('link', TextType::class, [
                'label' => 'Ссылка',
                'constraints' => [
                    new NotBlank(),
                    new Required(),
                ],
            ]);
    }
}
