<?php

namespace TeachersTrainingCenterBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait CreatedAtEntityTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\PrePersist
     */
    public function refreshCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
