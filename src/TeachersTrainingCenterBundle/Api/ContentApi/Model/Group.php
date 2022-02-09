<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Api\ContentApi\Model;

/** @psalm-immutable */
class Group
{
    /**
     * @requred
     */
    public int $id;

    public int $sortOrder;

    public string $title;

    /**
     * @requred
     */
    public string $titleEn;
}
