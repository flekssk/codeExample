<?php
declare(strict_types=1);

namespace App\UI\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ExampleProductCheckIdForm
 * @package App\Infrastructure\Api\Form
 */
class SignInTokenForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('token', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }
}
