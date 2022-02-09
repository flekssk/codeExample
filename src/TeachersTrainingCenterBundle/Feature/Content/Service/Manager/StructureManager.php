<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\Content\Service\Manager;

use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\StructureManager as OldStructureManager;
use TeachersTrainingCenterBundle\Feature\Content\Model\Collection\StructureCollection;

class StructureManager
{
    private OldStructureManager $structureManager;

    public function __construct(OldStructureManager $structureManager)
    {
        $this->structureManager = $structureManager;
    }

    public function getStructure(int $userId): StructureCollection
    {
        return new StructureCollection($this->structureManager->getStructure($userId));
    }
}
