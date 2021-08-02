<?php
declare(strict_types=1);

namespace App\UI\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class PaginationForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SUBMIT, static function (FormEvent $event) {
            /** @var array $data */
            $data = $event->getData();
            $form = $event->getForm();

            if (!is_array($data)) {
                return;
            }

            if (array_key_exists('page', $data)) {

                $form->add('page', IntegerType::class, [
                    'constraints' => [
                        new GreaterThan(0),
                    ],
                ]);
            }

            if (array_key_exists('perPage', $data)) {

                $form->add('perPage', IntegerType::class, [
                    'constraints' => [
                        new GreaterThan(0),
                        new LessThanOrEqual(100),
                    ],
                ]);
            }
        });
    }
}
