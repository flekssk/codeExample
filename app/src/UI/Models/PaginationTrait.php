<?php

declare(strict_types=1);

namespace App\UI\Models;

trait PaginationTrait
{
    /**
     * @var PaginationRequestModel
     */
    public $pagination;

    public function __construct()
    {
        $this->pagination = new PaginationRequestModel();
    }
}
