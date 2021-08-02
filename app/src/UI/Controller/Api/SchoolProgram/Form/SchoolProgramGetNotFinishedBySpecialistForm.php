<?php

namespace App\UI\Controller\Api\SchoolProgram\Form;

use App\UI\Form\Constraints\Is32BitInteger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

/**
 * Class SchoolProgramGetNotFinishedBySpecialistForm.
 *
 * @package App\UI\Controller\Api\SchoolProgram\Form
 */
class SchoolProgramGetNotFinishedBySpecialistForm extends AbstractType
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
            );
    }
}
