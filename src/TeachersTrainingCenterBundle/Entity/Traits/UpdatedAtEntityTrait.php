<?php

namespace TeachersTrainingCenterBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks
 */
trait UpdatedAtEntityTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function refreshUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
