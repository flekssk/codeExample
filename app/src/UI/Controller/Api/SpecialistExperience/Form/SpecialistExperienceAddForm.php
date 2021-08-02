<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\SpecialistExperience\Form;

use App\UI\Form\Constraints\Is32BitInteger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Url;

/**
 * Class SpecialistExperienceAddForm.
 *
 * @package App\UI\Controller\Api\SpecialistExperience\Form
 */
class SpecialistExperienceAddForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('specialistId', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Positive(),
                    new Is32BitInteger(),
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
