<?php

declare(strict_types=1);

namespace App\UI\Controller\Api\Specialist\Model;

use App\UI\Models\PaginationRequestModel;

/**
 * Class SpecialistPaginatedSearchModel.
 *
 * @package App\UI\Controller\Api\Specialist\Model
 */
class SpecialistPaginatedSearchModel extends PaginationRequestModel
{
    /**
     * @var string
     */
    public ?string $searchString = "";

    /**
     * @var string
     */
    public ?string $company = "";

    /**
     * @var string
     */
    public ?string $position = "";

    /**
     * @var string
     */
    public ?string $id2Position = "";

    /**
     * @var string
     */
    public ?string $document = "";

    /**
     * @var string
     */
    public ?string $region = "";

    /**
     * @var int|null
     */
    public ?int $status = null;
}
