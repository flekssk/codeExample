<?php

namespace App\Domain\Entity\ValueObject;

use DomainException;
use JsonSerializable;

/**
 * Class Url.
 *
 * @package App\Domain\Entity\ValueObject
 */
class Url implements JsonSerializable
{
    /**
     * @var string
     */
    private string $url;

    /**
     * Url constructor.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->validate($url);

        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return (string)$this->url;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->url;
    }

    /**
     * @param Url $file
     *
     * @return bool
     */
    public function isEqual(Url $file): bool
    {
        return $this->url === (string) $file;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    protected function validate(string $url): void
    {
        if (!empty($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
            throw new DomainException(sprintf('Неверный формат URL "%s"', $url));
        }
    }
}
