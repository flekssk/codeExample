<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\Helpers;

class Text
{
    public static function translit(?string $string): string
    {
        if ($string === null) {
            return '';
        }

        $cyr = array(
            'а', 'б', 'в', 'г', 'д', 'e', 'ё', 'ж', 'з', 'и', 'й',
            'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф',
            'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',

            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й',
            'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф',
            'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'
        );
        $lat = array(
            'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'zh', 'z', 'i', 'j',
            'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f',
            'h', 'cz', 'ch', 'sh', 'shh', '``', 'y`', '`', 'e`', 'yu', 'ya',

            'A', 'B', 'V', 'G', 'D', 'E', 'Yo', 'Zh', 'Z', 'I', 'J',
            'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F',
            'H', 'Cz', 'Ch', 'Sh', 'Shh', '``', 'Y`', '`', 'E`', 'Yu', 'Ya',
        );

        return str_replace($cyr, $lat, $string);
    }
}
