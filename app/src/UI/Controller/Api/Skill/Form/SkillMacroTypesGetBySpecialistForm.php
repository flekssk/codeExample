<?php

namespace App\UI\Controller\Api\Skill\Form;

use App\UI\Form\Constraints\Is32BitInteger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

/**
 * Class SkillMacroTypesGetBySpecialistForm.
 *
 * @package App\UI\Controller\Api\Specialist\Form
 */
class SkillMacroTypesGetBySpecialistForm extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'id',
                IntegerType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Positive(),
                        new Is32BitInteger(),
                    ],
                ]
            )->add(
                'hideEmptySkills',
                IntegerType::class,
                [
                    'constraints' => [
                        new Optional(),
                        new PositiveOrZero()
                    ],
                ]
            );
    }
}
