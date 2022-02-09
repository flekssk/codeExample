<?php

namespace TeachersTrainingCenterBundle\Service;

use TeachersTrainingCenterBundle\Entity\User;
use TeachersTrainingCenterBundle\RabbitMq\Consumer\User\Input\UserUpdatedMessage;
use TeachersTrainingCenterBundle\Repository\UserRepository;
use Skyeng\IdClient\DAO\API\UserDAO as IdUserDao;

class UserService
{
    /** @var UserRepository */
    private $userRepository;

    /** @var IdUserDao */
    private $idUserDao;

    public function __construct(UserRepository $userRepository, IdUserDao $idUserDao)
    {
        $this->userRepository = $userRepository;
        $this->idUserDao = $idUserDao;
    }

    /**
     * @param int[] $userIds
     * @return User[]
     */
    public function ensureUsersExistByIds(array $userIds): array
    {
        $users = $this->userRepository->findUsers($userIds);
        $existingUserIds = array_map(function (User $user) {
            return $user->getId();
        }, $users);
        $newUserIds = empty($users) ? $userIds : array_diff($userIds, $existingUserIds);
        $newUsers = $this->createNewUsersByIds($newUserIds);

        return array_merge($users, $newUsers);
    }

    public function updateUserFromMessage(UserUpdatedMessage $userUpdatedMessage): void
    {
        $user = $this->userRepository->find($userUpdatedMessage->id);
        if (!empty($user)) {
            foreach ($userUpdatedMessage->getFilledFields() as $filledField) {
                $user->setField($filledField, $userUpdatedMessage->{$filledField});
            }
            $this->userRepository->save($user);
        }
    }

    /**
     * @param int[] $newUserIds
     * @return User[]
     */
    public function createNewUsersByIds(array $newUserIds): array
    {
        $newUsers = [];
        if (!empty($newUserIds)) {
            $newUsersResponse = $this->idUserDao->getAll(null, null, $newUserIds);
            $newUsers = $this->userRepository->createUsersFromIdModel($newUsersResponse);
        }

        return $newUsers;
    }
}
