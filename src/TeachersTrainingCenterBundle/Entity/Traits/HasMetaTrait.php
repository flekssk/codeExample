<?php

namespace TeachersTrainingCenterBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait HasMetaTrait
{
    /**
     * @var array|null|integer|string
     *
     * @ORM\Column(type="json", nullable=true, options={"comment":"json значение", "jsonb"=true})
     */
    private $meta;

    public function setMeta($meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    public function getMeta()
    {
        return $this->meta;
    }
}
