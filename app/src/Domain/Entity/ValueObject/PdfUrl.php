<?php

namespace App\Domain\Entity\ValueObject;

use Laminas\EventManager\Exception\DomainException;

/**
 * Class PdfUrl.
 *
 * @package App\Domain\Entity\ValueObject
 */
class PdfUrl extends Url
{
    /**
     * Расширение pdf файла.
     */
    const PDF_EXTENSION = 'pdf';

    public function __construct(string $url)
    {
        $extension = pathinfo($url, PATHINFO_EXTENSION);
        if ($extension !== self::PDF_EXTENSION) {
            throw new DomainException("Ссылка {$url} не ведет на pdf файл");
        }

        parent::__construct($url);
    }
}
