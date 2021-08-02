<?php

namespace App\UI\Controller\Api\SpecialistOccupationType;

use App\Application\Specialist\SpecialistOccupationType\SpecialistOccupationTypeService as AppSpecialistOccupationTypeService;
use App\UI\Controller\Api\SpecialistOccupationType\Assembler\SpecialistOccupationTypeResponseAssembler;
use App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;

/**
 * Class SpecialistOccupationTypeService.
 */
class SpecialistOccupationTypeService implements AccessibleFromPublicInterface
{

    /**
     * @var SpecialistOccupationTypeResponseAssembler
     */
    private SpecialistOccupationTypeResponseAssembler $assembler;

    /**
     * @var AppSpecialistOccupationTypeService
     */
    private AppSpecialistOccupationTypeService $service;

    /**
     * SpecialistOccupationTypeGetAllController constructor.
     *
     * @param AppSpecialistOccupationTypeService $service
     * @param SpecialistOccupationTypeResponseAssembler $assembler
     */
    public function __construct(
        AppSpecialistOccupationTypeService $service,
        SpecialistOccupationTypeResponseAssembler $assembler
    ) {
        $this->service = $service;
        $this->assembler = $assembler;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $result = [];
        $dtoObjects = $this->service->getAll();
        foreach ($dtoObjects as $resultDto) {
            $result[] = $this->assembler->assemble($resultDto);
        }
        return $result;
    }
}
