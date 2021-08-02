<?php

namespace App\UI\Form\DataTransformer;

use DateTimeImmutable;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class DateOfBirthTransformer.
 *
 * @package App\UI\Form\DataTransformer
 */
class DateOfBirthTransformer implements DataTransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform($value)
    {
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform($value)
    {
        // На форме нужно выводить только дату - день, месяц и год.
        // Если изменить тип в specialist.yaml - из формы будет приходить объект класса DateTime.
        // Так как в Doctrine поле имеет тип datetime_immutable, объект класса DateTime не может быть сохранен в это поле.
        // Для этого дата здесь преобразуется в DateTimeImmutable.
        $dateTime = new DateTimeImmutable();
        return $dateTime->setTimestamp($value->getTimestamp());
    }
}
