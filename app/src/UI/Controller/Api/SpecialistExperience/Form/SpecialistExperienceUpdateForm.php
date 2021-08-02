<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\SpecialistExperience\Form;

use App\UI\Form\Constraints\Is32BitInteger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Positive;

/**
 * Class SpecialistExperienceUpdateForm.
 *
 * @package App\UI\Controller\Api\SpecialistExperience\Form
 */
class SpecialistExperienceUpdateForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Positive(),
                    new Is32BitInteger(),
                ],
            ])
            ->add('specialistId', IntegerType::class, [
                'constraints' => [
                    new Optional(),
                ],
            ])
            ->add('company', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('startDate', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('endDate', TextType::class);
    }
}
