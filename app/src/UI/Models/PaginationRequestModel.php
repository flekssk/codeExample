<?php

declare(strict_types=1);

namespace App\UI\Models;

use Swagger\Annotations as SWG;

/**
 * Class PaginationRequestModel
 * @package App\UI\Models
 *
 * @SWG\Definition(
 *     required={"page", "perPage"}
 * )
 */
class PaginationRequestModel implements \ArrayAccess
{
    /**
     * @var integer
     */
    public ?int $page = 1;

    /**
     * @var integer
     */
    public ?int $perPage = 50;

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }
}
