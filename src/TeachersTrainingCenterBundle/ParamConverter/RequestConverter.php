<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;

class RequestConverter implements ParamConverterInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $class = $configuration->getClass();

        $requestObject = new $class();
        $requestObject->loadFromRawJsonRequest($request);
        $requestObject->loadFromRequest($request);
        $requestObject->loadFromQuery($request);

        $violations = $this->validator->validate($requestObject);

        $request->attributes->set($configuration->getName(), $requestObject);
        $request->attributes->set('validationErrors', $violations);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return !is_null($configuration->getClass()) &&
            in_array(SafeLoadFieldsTrait::class, class_uses($configuration->getClass()), true);
    }
}
