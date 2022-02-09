<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Skyeng\IdClient\Model\API\UserBasic;
use TeachersTrainingCenterBundle\Entity\User;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param int[] $userIds
     *
     * @return User[]
     */
    public function findUsers(array $userIds): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('u')
            ->from($this->getClassName(), 'u')
            ->where($qb->expr()->in('u.id', ':userIds'));

        $qb->setParameter('userIds', $userIds);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param UserBasic[] $newUsers
     *
     * @return User[]
     */
    public function createUsersFromIdModel(array $newUsers): array
    {
        $users = [];
        foreach ($newUsers as $newUser) {
            $users[] = $this->createUserFromIdModel($newUser);
        }

        $this->getEntityManager()->flush();

        return $users;
    }

    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    private function createUserFromIdModel(UserBasic $newUser): User
    {
        $user = (new User())
            ->setId($newUser->getId())
            ->setAvatarUrl($newUser->getAvatarUrl())
            ->setLocale($newUser->getLocale())
            ->setName($newUser->getName())
            ->setSurname($newUser->getSurname())
            ->setTimezone($newUser->getTimezone());
        $this->getEntityManager()->persist($user);

        return $user;
    }
}
