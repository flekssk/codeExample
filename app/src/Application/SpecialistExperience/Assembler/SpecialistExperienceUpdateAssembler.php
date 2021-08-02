<?php

declare(strict_types=1);

namespace App\Application\SpecialistExperience\Assembler;

use Exception;
use DateTimeImmutable;
use App\Application\SpecialistExperience\Dto\SpecialistExperienceUpdateDto;
use App\Domain\Repository\NotFoundException;
use App\Domain\Repository\SpecialistExperience\SpecialistExperienceRepositoryInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SpecialistExperienceUpdateAssembler.
 *
 * @package App\Application\SpecialistExperience\Assembler
 */
class SpecialistExperienceUpdateAssembler implements SpecialistExperienceUpdateAssemblerInterface
{
    /**
     * @var SpecialistExperienceRepositoryInterface
     */
    private SpecialistExperienceRepositoryInterface $specialistExperienceRepository;

    /**
     * SpecialistExperienceUpdateAssembler constructor.
     *
     * @param SpecialistExperienceRepositoryInterface $specialistExperienceRepository
     */
    public function __construct(
        SpecialistExperienceRepositoryInterface $specialistExperienceRepository
    ) {
        $this->specialistExperienceRepository = $specialistExperienceRepository;
    }

    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    public function assemble(array $options): SpecialistExperienceUpdateDto
    {
        $this->validateOptions($options);

        $dto = new SpecialistExperienceUpdateDto();

        $dto->id = (int) $options['id'];
        $dto->company = trim($options['company']);
        $dto->startDate = new DateTimeImmutable($options['startDate']);
        $dto->endDate = isset($options['endDate']) && $options['endDate'] ? new DateTimeImmutable($options['endDate']) : null;

        return $dto;
    }

    /**
     * Проверка переданных значений.
     *
     * @param array $options
     *
     * @throws Exception
     * @throws InvalidOptionsException
     * @throws NotFoundException
     */
    private function validateOptions(array $options): void
    {
        $specialistExperience = $this->specialistExperienceRepository->get((int) $options['id']);

        $resolver = new OptionsResolver();

        // Задать дефолтные значения для полей.
        $resolver->setDefaults([
            'id' => $specialistExperience->getId(),
            'company' => $specialistExperience->getCompany(),
            'specialistId' => $specialistExperience->getSpecialistId(),
            'startDate' => $specialistExperience->getStartDate()->format('Y-m-d'),
            'endDate' => $specialistExperience->getEndDate() ? $specialistExperience->getEndDate()->format('Y-m-d') : null,
        ]);

        // Задать допустимые типы для полей.
        $resolver->setAllowedTypes('company', ['string']);
        $resolver->setAllowedTypes('specialistId', ['int']);
        $resolver->setAllowedTypes('startDate', ['string']);
        $resolver->setAllowedTypes('endDate', ['string', 'null']);

        $resolver->setAllowedValues('company', function ($value) {
            $value = trim($value);

            if ($value === '') {
                return false;
            }

            if (strlen($value) >= 256) {
                return false;
            }

            return true;
        });
        // Проверки startDate и endDate не объединены в одну функцию так как у каждого параметра есть свои нюансы,
        // например startDate не может быть пустой строкой, а endDate может.
        $resolver->setAllowedValues('startDate', function ($value) {
            // Если передан null - не продолжать проверку.
            if ($value == null) {
                return false;
            }

            return $this->checkDate($value);
        });
        $resolver->setAllowedValues('endDate', function ($value) {
            // Если передан null - не продолжать проверку.
            if ($value == null) {
                return true;
            }

            return $this->checkDate($value);
        });

        $resolver->resolve($options);

        // Проверить что дата начала не больше даты окончания.
        if (empty($options['endDate']) === false) {
            $startDate = new DateTimeImmutable($options['startDate']);
            $endDate = new DateTimeImmutable($options['endDate']);
            if ($startDate > $endDate) {
                throw new InvalidOptionsException('Дата начала работы не может быть больше даты окончания работы.');
            }
        }
    }

    /**
     * Проверка даты.
     *
     * @param string $value
     *
     * @return bool
     *
     * @throws InvalidOptionsException
     */
    private function checkDate(string $value): bool
    {
        // Вычисление разницы $value и текущей даты.
        try {
            $now = new DateTimeImmutable();
            $date = new DateTimeImmutable($value);
        } catch (Exception $e) {
            throw new InvalidOptionsException('Ошибка валидации даты, убедитесь что используется формат YYYY-MM или YYYY-MM-DD: ' . $e->getMessage());
        }

        return $now > $date;
    }
}
