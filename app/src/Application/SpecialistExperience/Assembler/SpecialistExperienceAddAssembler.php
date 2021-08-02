<?php

declare(strict_types=1);

namespace App\Application\SpecialistExperience\Assembler;

use App\Domain\Repository\NotFoundException;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use Exception;
use App\Application\SpecialistExperience\Dto\SpecialistExperienceAddDto;
use DateTimeImmutable;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SpecialistExperienceAddAssembler.
 *
 * @package App\Application\SpecialistExperience\Assembler
 */
class SpecialistExperienceAddAssembler implements SpecialistExperienceAddAssemblerInterface
{
    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $specialistRepository;

    /**
     * SpecialistExperienceAddAssembler constructor.
     *
     * @param SpecialistRepositoryInterface $specialistRepository
     */
    public function __construct(SpecialistRepositoryInterface $specialistRepository)
    {
        $this->specialistRepository = $specialistRepository;
    }

    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    public function assemble(array $options): SpecialistExperienceAddDto
    {
        $this->validateOptions($options);

        $dto = new SpecialistExperienceAddDto();

        $dto->specialistId = (int)$options['specialistId'];
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
        $resolver = new OptionsResolver();

        // Задать обязательные поля.
        $resolver->setRequired([
            'specialistId',
            'company',
            'startDate',
        ]);

        // Задать дефолтные значения для полей.
        $resolver->setDefaults([
            'endDate' => null,
        ]);

        // Задать допустимые типы для полей.
        $resolver->setAllowedTypes('specialistId', ['int']);
        $resolver->setAllowedTypes('company', ['string']);
        $resolver->setAllowedTypes('startDate', ['string']);
        $resolver->setAllowedTypes('endDate', ['string', 'null']);

        // Задать допустимые значения для полей.
        $resolver->setAllowedValues('specialistId', function ($value) {
            if ($value <= 0) {
                return false;
            }

            // Проверить существование специалиста с таким ID, если его нет - будет выброшено исключение.
            $this->specialistRepository->get($value);

            return true;
        });
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
            if ($value === null) {
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

        if ($now > $date) {
            return true;
        }

        return false;
    }
}
