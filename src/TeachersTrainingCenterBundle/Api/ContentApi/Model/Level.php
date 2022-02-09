<?php

namespace TeachersTrainingCenterBundle\Api\ContentApi\Model;

class Level
{
    /**
     * @var int
     * @requred
     */
    private $id;

    /**
     * @var string
     * @requred
     */
    private $title;

    /**
     * @var string info about content changes inside course level
     */
    private $changes;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getChanges(): string
    {
        return $this->changes;
    }
}
