<?php

namespace App\UI\Form\Constraints;

use Symfony\Component\Validator\Constraints\Range;

/**
 * Class Is32BitInteger.
 *
 * Проверяет на вхождение в границы значения 32-х битного integer.
 *
 * @package App\UI\Form\Constraints
 */
class Is32BitInteger extends Range
{
    private const MAX_VALUE = 2147483647;
    private const MIN_VALUE = -2147483648;

    /**
     * Integer32Bit constructor.
     */
    public function __construct()
    {
        $options = [
            'max' => self::MAX_VALUE,
            'min' => self::MIN_VALUE,
            'notInRangeMessage' => 'Значение должно быть равно ' . self::MAX_VALUE . ' или меньше.'
        ];

        parent::__construct($options);
    }

    /**
     * @return string
     */
    public function validatedBy()
    {
        return parent::class . 'Validator';
    }
}
