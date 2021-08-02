<?php

declare(strict_types=1);

namespace App\UI\Service\Validator;

use Symfony\Component\Form\FormFactoryInterface;

class Validator implements ValidatorInterface
{
    /** @var FormFactoryInterface */
    private FormFactoryInterface $formFactory;

    /**
     * Validator constructor.
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @inheritDoc
     */
    public function validate(string $formClass, array $data, object $model = null): void
    {
        $form = $this->formFactory->create($formClass, $model)->submit($data);
        RequestFormValidationHelper::validate($form);
    }

}
