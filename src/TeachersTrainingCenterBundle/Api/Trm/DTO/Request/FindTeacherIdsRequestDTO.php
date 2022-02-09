<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Api\Trm\DTO\Request;

use TeachersTrainingCenterBundle\Api\Trm\DTO\OrderByClauseDTO;

class FindTeacherIdsRequestDTO
{
    /**
     * @var string[]
     */
    public array $expressions;

    public int $page;

    /**
     * @var OrderByClauseDTO[]|null
     */
    public ?array $orderBy = [];

    public bool $shouldSearchInInactiveProfiles;

    public bool $debug;

    public ?int $recordsPerPage = 1;

    /**
     * @param string[] $expressions
     * @param OrderByClauseDTO[]|null $orderBy
     */
    public function __construct(
        array $expressions,
        int $page = 1,
        ?array $orderBy = [],
        bool $shouldSearchInInactiveProfiles = false,
        bool $debug = false,
        ?int $recordsPerPage = 50
    ) {
        $this->expressions = $expressions;
        $this->page = $page;
        $this->orderBy = $orderBy;
        $this->shouldSearchInInactiveProfiles = $shouldSearchInInactiveProfiles;
        $this->debug = $debug;
        $this->recordsPerPage = $recordsPerPage;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
    }
}
