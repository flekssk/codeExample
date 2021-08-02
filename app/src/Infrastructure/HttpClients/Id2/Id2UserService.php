<?php

namespace App\Infrastructure\HttpClients\Id2;

use App\Infrastructure\HttpClients\Id2\Assembler\Id2UserAssemblerInterface;
use App\Infrastructure\HttpClients\Id2\Dto\Id2UserDto;

/**
 * Class Id2UserService.
 *
 * @package App\Infrastructure\HttpClients\Id2
 */
class Id2UserService implements Id2UserServiceInterface
{
    /**
     * @var Id2UserAssemblerInterface
     */
    private Id2UserAssemblerInterface $id2UserAssembler;

    /**
     * @var Id2ApiClientInterface
     */
    private Id2ApiClientInterface $id2ApiClient;

    /**
     * Id2UserService constructor.
     *
     * @param Id2ApiClientInterface     $id2ApiClient
     * @param Id2UserAssemblerInterface $id2UserAssembler
     */
    public function __construct(
        Id2ApiClientInterface $id2ApiClient,
        Id2UserAssemblerInterface $id2UserAssembler
    ) {
        $this->id2ApiClient = $id2ApiClient;
        $this->id2UserAssembler = $id2UserAssembler;
    }

    /**
     * @param int $id
     *
     * @return Id2UserDto
     */
    public function getUserById(int $id): Id2UserDto
    {
        $response = $this->id2ApiClient->getUser($id);
        $dto = $this->id2UserAssembler->assemble($response);

        return $dto;
    }
}
