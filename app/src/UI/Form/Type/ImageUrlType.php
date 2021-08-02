<?php

namespace App\UI\Form\Type;

use App\UI\Form\DataTransformer\ImageUrlTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ImageUrlType.
 *
 * @package App\UI\Form\Type
 */
class ImageUrlType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        // По умолчанию, DataTransformer'ы применяются от последнего к первому.
        // В нашем случае это приводит к ошибкам, так как изменяется тип возвращаемого значения
        // и другие DataTransformer'ы не могут его обработать.
        // Поэтому было принято решение менять порядок DataTransformer'ов и добавлять кастомный первым,
        // тем самым он будет отрабатывать в последнюю очередь.
        $transformers = $builder->getViewTransformers();
        $builder->resetViewTransformers();
        $builder->addViewTransformer(new ImageUrlTransformer());

        foreach ($transformers as $transformer) {
            $builder->addViewTransformer($transformer);
        }
    }

    /**
     * @return string
     */
    public function getParent(): string
    {
        return TextType::class;
    }
}
