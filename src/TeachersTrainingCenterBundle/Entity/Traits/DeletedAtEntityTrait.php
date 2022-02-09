<?php

namespace TeachersTrainingCenterBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks
 */
trait DeletedAtEntityTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;

    public function isDeleted()
    {
        return !empty($this->deletedAt);
    }

    /**
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(\DateTime $deletedAt = null)
    {
        $this->deletedAt = !empty($deletedAt) ? $deletedAt : new \DateTime();
    }
}
