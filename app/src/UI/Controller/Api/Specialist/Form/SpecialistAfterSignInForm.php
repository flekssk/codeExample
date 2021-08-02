<?php

namespace App\UI\Controller\Api\Specialist\Form;

use App\UI\Form\Constraints\Is32BitInteger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

/**
 * Class SpecialistAfterSignInForm.
 *
 * @package App\UI\Controller\Api\Specialist\Form
 */
class SpecialistAfterSignInForm extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'userId',
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
