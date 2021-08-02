<?php

declare(strict_types=1);

namespace App\Application\Id2;

use App\Application\Id2\Assembler\Id2EventAssembler;
use App\Application\Id2\Dto\Id2EventDto;
use App\Domain\Entity\Id2\Id2Event;
use App\Domain\Repository\Id2\Id2EventRepositoryInterface;

/**
 * Class Id2EventService.
 *
 * @package App\Application\Id2Event
 */
class Id2EventService
{
    /**
     * @var Id2EventRepositoryInterface
     */
    private Id2EventRepositoryInterface $repository;

    /**
     * @var Id2EventAssembler
     */
    private Id2EventAssembler $assembler;

    /**
     * Id2EventService constructor.
     *
     * @param Id2EventRepositoryInterface $repository
     * @param Id2EventAssembler $assembler
     */
    public function __construct(
        Id2EventRepositoryInterface $repository,
        Id2EventAssembler $assembler
    ) {
        $this->repository = $repository;
        $this->assembler = $assembler;
    }

    /**
     * @param string[] $names
     * @return Id2EventDto[]
     */
    public function searchId2Events(array $names): array
    {
        $id2EventsDto = [];
        $id2Events = $this->repository->findAllEvents();
        foreach ($id2Events as $id2Event) {
            if ($names === [] || in_array($id2Event->getName(), $names)) {
                $id2EventsDto[] = $this->assembler->assemble($id2Event);
            }
        }

        return $id2EventsDto;
    }
}
