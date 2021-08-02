<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\Specialist\Form;

use App\UI\Form\Constraints\Is32BitInteger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

/**
 * Class SpecialistUpdateForm.
 *
 * @package App\UI\Controller\Api\Specialist\Form
 */
class SpecialistUpdateForm extends AbstractType
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
            ->add('position', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('employmentType', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Positive(),
                    new Is32BitInteger(),
                ],
            ])
            ->add('workSchedule', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Positive(),
                    new Is32BitInteger(),
                ],
            ]);
    }
}
