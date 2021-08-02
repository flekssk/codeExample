<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\SpecialistWorkSchedule;

use App\Domain\Entity\SpecialistWorkSchedule\SpecialistWorkSchedule;
use App\Domain\Repository\NotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class SpecialistWorkScheduleRepository.
 *
 * @method SpecialistWorkSchedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialistWorkSchedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialistWorkSchedule[]    findAll()
 * @method SpecialistWorkSchedules[]   findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialistWorkScheduleRepository extends ServiceEntityRepository implements
    SpecialistWorkScheduleRepositoryInterface
{

    /**
     * Class constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialistWorkSchedule::class);
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): SpecialistWorkSchedule
    {
        $schedule = $this->find($id);

        if (is_null($schedule)) {
            throw new NotFoundException("Расписание работы с id {$id} не найдено.");
        }

        return $schedule;
    }
}
