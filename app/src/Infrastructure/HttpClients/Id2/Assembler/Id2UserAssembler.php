<?php

namespace App\Infrastructure\HttpClients\Id2\Assembler;

use App\Domain\Entity\ValueObject\Gender;
use App\Infrastructure\HttpClients\Id2\Dto\Id2UserDto;
use App\Infrastructure\HttpClients\Id2\Response\UserGetResponse;

/**
 * Class Id2UserAssembler.
 *
 * @package App\Infrastructure\HttpClients\Id2\Assembler
 */
class Id2UserAssembler implements Id2UserAssemblerInterface
{
    /**
     * Имя параметра имени региона в response.
     */
    const REGION_GUID_PROPERTY_NAME = 'regionguid';

    /**
     * Имя параметра имени региона в response.
     */
    const REGION_PROPERTY_NAME = 'region';

    /**
     * Имя параметра должности в response.
     */
    const POSITION_PROPERTY_NAME = 'post';

    const AVATAR_PATH = 'userpic';

    /**
     * Путь до картинок в кабинете id2.
     */
    const AVATAR_PROPERTY_NAME = 'avatar';

    /**
     * Путь до картинок в кабинете id2.
     */
    const COMPANY_PROPERTY_NAME = 'company';

    /**
     * @var string
     */
    private string $id2Url;

    /**
     * Id2UserAssembler constructor.
     *
     * @param string $id2Url
     */
    public function __construct(string $id2Url)
    {
        $this->id2Url = $id2Url;
    }

    /**
     * @param UserGetResponse $userGetResponse
     *
     * @return Id2UserDto
     */
    public function assemble(UserGetResponse $userGetResponse): Id2UserDto
    {
        $dto = new Id2UserDto();

        $dto->id = $userGetResponse->id;
        $dto->firstName = $userGetResponse->firstName;
        $dto->secondName = $userGetResponse->lastName;
        $dto->middleName = $userGetResponse->middleName;
        $dto->gender = !is_null($userGetResponse->gender) ? new Gender($userGetResponse->gender) : null;
        $dto->region = $this->getProperty($userGetResponse, self::REGION_PROPERTY_NAME);
        $dto->birthDate = $userGetResponse->birthDate;
        $dto->position = $this->getProperty($userGetResponse, self::POSITION_PROPERTY_NAME);
        $dto->company = $this->getProperty($userGetResponse, self::COMPANY_PROPERTY_NAME);

        $avatar = $this->getProperty($userGetResponse, self::AVATAR_PROPERTY_NAME);

        if ($avatar != '') {
            $avatar = rtrim($this->id2Url, '/') . '/' . self::AVATAR_PATH . '/' . $avatar;
        }

        $dto->avatar = $avatar;

        return $dto;
    }

    /**
     * Получаем свойство пользователя из Response
     *
     * @param UserGetResponse $userGetResponse
     * @param                 $name
     *
     * @return string
     */
    private function getProperty(UserGetResponse $userGetResponse, string $name): string
    {
        $result = '';

        foreach ($userGetResponse->properties as $property) {
            if (
                isset($property->key)
                && isset($property->value)
                && !empty($property->key)
                && $property->key === $name
            ) {
                $result = $property->value;
            }
        }

        return $result;
    }
}
