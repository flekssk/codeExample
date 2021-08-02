<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\Specialist\Form;

use App\UI\Form\Constraints\Is32BitInteger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class SpecialistPaginatedFindForm.
 *
 * @package App\UI\Controller\Api\Specialist\Form
 */
class SpecialistPaginatedFindForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'searchString',
                TextType::class,
                [
                    'constraints' => [
                        new Optional(),
                    ],
                ]
            )
            ->add(
                'company',
                TextType::class,
                [
                    'constraints' => [
                        new Optional(),
                    ],
                ]
            )
            ->add(
                'region',
                TextType::class,
                [
                    'constraints' => [
                        new Optional(),
                    ],
                ]
            )
            ->add(
                'document',
                TextType::class,
                [
                    'constraints' => [
                        new Optional(),
                    ],
                ]
            )
            ->add(
                'position',
                TextType::class,
                [
                    'constraints' => [
                        new Optional(),
                    ],
                ]
            )
            ->add(
                'id2Position',
                TextType::class,
                [
                    'constraints' => [
                        new Optional(),
                    ],
                ]
            )
            ->add(
                'status',
                IntegerType::class,
                [
                    'constraints' => [
                        new Optional(),
                    ],
                ]
            )
            ->add(
                'page',
                IntegerType::class,
                [
                    'constraints' => [
                        new NotNull(),
                        new Is32BitInteger(),
                    ],
                ]
            )
            ->add(
                'perPage',
                IntegerType::class,
                [
                    'constraints' => [
                        new NotNull(),
                        new Is32BitInteger(),
                    ],
                ]
            );
    }
}
