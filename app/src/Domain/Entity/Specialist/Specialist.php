<?php

declare(strict_types=1);

namespace App\Domain\Entity\Specialist;

use App\Domain\Entity\Position\Position;
use App\Domain\Entity\Region\Region;
use App\Domain\Entity\Specialist\ValueObject\Status;
use App\Domain\Entity\SpecialistWorkSchedule\SpecialistWorkSchedule;
use App\Domain\Entity\ValueObject\Gender;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Specialist.
 *
 * @Vich\Uploadable()
 * @package App\Domain\Entity\Specialist
 */
class Specialist
{
    /**
     * Id пользователя в id2.
     *
     * @var int
     */
    private int $id;

    /**
     * Имя.
     *
     * @var string|null
     */
    private ?string $firstName;

    /**
     * Фамилия.
     *
     * @var string|null
     */
    private ?string $secondName;

    /**
     * Отчество.
     *
     * @var string|null
     */
    private ?string $middleName;

    /**
     * Пол.
     *
     * @var int|null
     */
    private ?int $gender;

    /**
     * Регион.
     *
     * @var string|null
     */
    private ?string $region;

    /**
     * Дата рождения.
     *
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $dateOfBirth;

    /**
     * Должность в id2.
     *
     * @var string|null
     */
    private ?string $id2Position;

    /**
     * Должность.
     *
     * @var string|null
     */
    private ?string $position = '';

    /**
     * Вид занятости.
     *
     * @var SpecialistOccupationType|null
     */
    private ?SpecialistOccupationType $employmentType = null;

    /**
     * Режим работы.
     *
     * @var SpecialistWorkSchedule|null
     */
    private ?SpecialistWorkSchedule $schedule = null;

    /**
     * Статус специалиста.
     *
     * @var int
     */
    private int $status;

    /**
     * Ссылка на аватар.
     *
     * @var string|null
     */
    private ?string $avatar;

    /**
     * @Vich\UploadableField(mapping="specialist_avatar", fileNameProperty="avatar")
     * @var File|null
     */
    private ?File $avatarFile;

    /**
     * @var string|null
     */
    private ?string $company;

    /**
     * @var Order[]|Collection
     */
    private $orders;

    /**
     * Дата создания.
     *
     * @var DateTimeInterface
     */
    private DateTimeInterface $createdAt;

    /**
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $updatedAt = null;

    /**
     * Дата последней проверки доступа.
     *
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $dateCheckAccess = null;

    /**
     * Количество просмотров карточки специалиста.
     *
     * @var int
     */
    private int $viewCount = 0;

    /**
     * Specialist constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
        $this->orders = new ArrayCollection();
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * @return Gender|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getGender(): ?Gender
    {
        return $this->gender === null ? null : new Gender($this->gender);
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getGenderName(): string
    {
        return $this->getGender() ? $this->getGender()->getName() : '';
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @return bool
     */
    public function isHasRegion(): bool
    {
        $result = false;

        if (!is_null($this->region)) {
            $result = true;
        }

        return $result;
    }

    /**
     * @return \DateTimeInterface|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getDateOfBirth(): ?DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getId2Position(): ?string
    {
        return $this->id2Position ?? null;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getPosition(): ?string
    {
        return $this->position;
    }

    /**
     * Проверка есть ли должность у специалиста.
     *
     * @return bool
     */
    public function isHasPosition(): bool
    {
        return !empty($this->position);
    }

    /**
     * @return SpecialistOccupationType|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getEmploymentType(): ?SpecialistOccupationType
    {
        return $this->employmentType;
    }

    /**
     * @return SpecialistWorkSchedule|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getSchedule(): ?SpecialistWorkSchedule
    {
        return $this->schedule;
    }

    /**
     * @param string|null $firstName
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string|null $secondName
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setSecondName(?string $secondName): void
    {
        $this->secondName = $secondName;
    }

    /**
     * @param string|null $middleName
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setMiddleName(?string $middleName): void
    {
        $this->middleName = $middleName;
    }

    /**
     * @param Gender|null $gender
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setGender(?Gender $gender): void
    {
        $this->gender = $gender === null ? null : $gender->getValue();
    }

    /**
     * @param string|null $region
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    /**
     * @param DateTimeInterface|null $dateOfBirth
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setDateOfBirth(?DateTimeInterface $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @param string|null $id2Position
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setId2Position(?string $id2Position): void
    {
        $this->id2Position = $id2Position;
    }

    /**
     * @param string|null $position
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setPosition(?string $position): void
    {
        $this->position = $position;
    }

    /**
     * @param SpecialistOccupationType|null $employmentType
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setEmploymentType(?SpecialistOccupationType $employmentType): void
    {
        $this->employmentType = $employmentType;
    }

    /**
     * @return DateTimeInterface
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTimeInterface|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface|null $updatedAt
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function getAvatar(): ?string
    {
        return $this->avatar ?? null;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function getAvatarUrl(): string
    {
        return $this->getAvatar() ?: '';
    }

    /**
     * @param string|null $avatar
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return File|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getAvatarFile(): ?File
    {
        return isset($this->avatarFile) ? $this->avatarFile : null;
    }

    /**
     * @param File|null $avatarFile
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setAvatarFile(?File $avatarFile): void
    {
        $this->avatarFile = $avatarFile;

        if ($avatarFile) {
            $this->setUpdatedAt(new \DateTimeImmutable());
        }
    }

    /**
     * @param SpecialistWorkSchedule|null $schedule
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setSchedule(?SpecialistWorkSchedule $schedule): void
    {
        $this->schedule = $schedule;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Status
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getStatus(): Status
    {
        return new Status($this->status);
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getStatusName(): string
    {
        return $this->getStatus()->getStatusName();
    }

    /**
     * @param Status $status
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setStatus(Status $status): void
    {
        $this->status = $status->getStatusId();
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * @param string|null $company
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setCompany(?string $company): void
    {
        $this->company = $company;
    }

    /**
     * @param Order[]|Collection $orders
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setOrders($orders): void
    {
        $this->orders = $orders;
    }

    /**
     * @return Order[]
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getOrders(): array
    {
        return is_array($this->orders) ? $this->orders : $this->orders->toArray();
    }

    /**
     * @return DateTimeInterface|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getDateCheckAccess(): ?DateTimeInterface
    {
        return $this->dateCheckAccess;
    }

    /**
     * @param DateTimeInterface|null $dateCheckAccess
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setDateCheckAccess(?DateTimeInterface $dateCheckAccess): void
    {
        $this->dateCheckAccess = $dateCheckAccess;
    }

    /**
     * Увеличивает значение количества просмотров.
     *
     * @return void
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function incrementViewCount(): void
    {
        $this->viewCount++;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getViewCount(): int
    {
        return $this->viewCount;
    }
}
