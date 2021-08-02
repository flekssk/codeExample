<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\SpecialistExperience\Form;

use App\UI\Form\Constraints\Is32BitInteger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;

/**
 * Class SpecialistExperienceGetForm.
 *
 * @package App\UI\Controller\Api\SpecialistExperience\Form
 */
class SpecialistExperienceGetForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'id',
                IntegerType::class,
                [
                    'constraints' => [
                        new NotNull(),
                        new Positive(),
                        new Is32BitInteger(),
                    ],
                ]
            );
    }
}
