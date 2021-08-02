<?php

declare(strict_types=1);

namespace App\Application\Id2\Assembler;

use App\Domain\Entity\Id2\Id2Event;
use App\Application\Id2\Dto\Id2EventDto;

/**
 * Class Id2EventAssembler.
 *
 * @package \App\Application\Id2Event\Assembler
 */
class Id2EventAssembler
{

    /**
     * @param Id2Event $id2Event
     * @return Id2EventDto
     */
    public function assemble(Id2Event $id2Event): Id2EventDto
    {
        $dto = new Id2EventDto();
        $dto->name = $id2Event->getName();
        $dto->action = $id2Event->getAction();
        $dto->category1 = $id2Event->getCategory1();
        $dto->category2 = $id2Event->getCategory2();

        return $dto;
    }
}
