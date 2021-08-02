<?php

namespace App\Infrastructure\HttpClients\School;

use App\Infrastructure\HttpClients\School\Assembler\SchoolResponseAssemblerInterface;
use App\Infrastructure\HttpClients\School\Client\SchoolClientInterface;
use App\Infrastructure\HttpClients\School\Dto\SchoolResponseDto;

/**
 * Class SchoolService.
 *
 * @package App\Infrastructure\HttpClients\School
 */
class SchoolService
{
    /**
     * @var SchoolClientInterface
     */
    private SchoolClientInterface $schoolClient;

    /**
     * @var SchoolResponseAssemblerInterface
     */
    private SchoolResponseAssemblerInterface $schoolResponseAssembler;

    public function __construct(
        SchoolClientInterface $schoolClient,
        SchoolResponseAssemblerInterface $schoolResponseAssembler
    ) {
        $this->schoolClient = $schoolClient;
        $this->schoolResponseAssembler = $schoolResponseAssembler;
    }

    /**
     * @return SchoolResponseDto[]
     */
    public function getAll(): array
    {
        $schools = [];
        $response = $this->schoolClient->getAll();

        foreach ($response as $item) {
            $schools[] = $this->schoolResponseAssembler->assemble($item->id, $item->name);
        }

        return $schools;
    }
}
