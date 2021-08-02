<?php

namespace App\Infrastructure\HttpClients\Id2;

use App\Domain\Entity\SpecialistAccess\SpecialistAccess;
use App\Domain\Repository\NotFoundException;
use App\Infrastructure\HttpClients\Id2\Assembler\Id2UserAssembler;
use App\Infrastructure\HttpClients\Id2\Response\UserGetResponse;

/**
 * Class Id2ClientDummy.
 *
 * @package App\Infrastructure\HttpClients\Id2
 */
class Id2ClientDummy implements Id2ApiClientInterface
{
    /**
     * @var int[]
     */
    private array $existedUserId = [
        1,
        1001,
    ];

    /**
     * @inheritDoc
     */
    public function getUser(int $id): UserGetResponse
    {
        if (!in_array($id, $this->existedUserId)) {
            throw new NotFoundException("Пользователь с id {$id} не найден в id2.");
        }

        $userGetResponse = new UserGetResponse();

        $userGetResponse->id = $id;
        $userGetResponse->firstName = 'firstName';
        $userGetResponse->lastName = 'lastName';
        $userGetResponse->middleName = 'middleName';
        $userGetResponse->gender = 1;
        $userGetResponse->birthDate = new \DateTimeImmutable();
        $userGetResponse->email = 'test@yandex.ru';
        $userGetResponse->phone = '+79999999999';
        $userGetResponse->properties = [
            [
                'key' => Id2UserAssembler::REGION_GUID_PROPERTY_NAME,
                'value' => 'testregion',
            ],
        ];

        return $userGetResponse;
    }
}
