<?php

namespace App\UI\Controller\Api\Region\Form;

use App\UI\Form\Constraints\Is32BitInteger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Positive;

/**
 * Class RegionSearchForm.
 *
 * @package App\UI\Controller\Api\Region\Form
 */
class RegionSearchForm extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'constraints' => [],
            ]
        )->add(
            'count',
            IntegerType::class,
            [
                'constraints' => [
                    new Positive(),
                    new Is32BitInteger(),
                ],
            ]
        );
    }
}
