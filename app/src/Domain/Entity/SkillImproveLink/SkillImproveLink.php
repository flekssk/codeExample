<?php

namespace App\Domain\Entity\SkillImproveLink;

/**
 * Class SkillImproveLink.
 *
 * @package App\Domain\Entity\SkillImproveLink
 */
class SkillImproveLink
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $skillId;

    /**
     * @var int
     */
    private int $schoolId;

    /**
     * @var string
     */
    private string $link;

    /**
     * SkillImproveLink constructor.
     *
     * @param string $skillId
     * @param int $schoolId
     * @param string $link
     */
    public function __construct(string $skillId, int $schoolId, string $link)
    {
        $this->skillId = $skillId;
        $this->schoolId = $schoolId;
        $this->link = $link;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getSkillId(): string
    {
        return $this->skillId;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getSchoolId(): int
    {
        return $this->schoolId;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getLink(): string
    {
        return $this->link;
    }
}
