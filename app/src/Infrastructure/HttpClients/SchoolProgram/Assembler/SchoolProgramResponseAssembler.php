<?php

namespace App\Infrastructure\HttpClients\SchoolProgram\Assembler;

use App\Infrastructure\HttpClients\SchoolProgram\Dto\SchoolProgramResponseDto;
use Exception;

/**
 * Class SchoolProgramResponseAssembler.
 *
 * @package App\Infrastructure\HttpClients\SchoolProgram\Assembler
 */
class SchoolProgramResponseAssembler implements SchoolProgramResponseAssemblerInterface
{
    public const EN_DIPLOM = 'Diplom';
    public const EN_CERTIFICATE = 'Certificate';

    public const RU_DIPLOM = 'Диплом';
    public const RU_CERTIFICATE = 'Удостоверение';
    public const RU_DEFAULT_DOCUMENT_TYPE = 'Сертификат';

    public array $ruDocumentTypes = [
        self::EN_DIPLOM => self::RU_DIPLOM,
        self::EN_CERTIFICATE => self::RU_CERTIFICATE,
    ];

    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    public function assemble(object $item): SchoolProgramResponseDto
    {
        $dto = new SchoolProgramResponseDto();

        $dto->programId = $item->programId;
        $dto->programTitle = $item->programTitle;
        $dto->programPost = $item->programPost;
        $dto->defaultDurationInMonths = intdiv($item->defaultDurationInDays, 30);
        $dto->defaultDurationInHours = $item->defaultDurationInHours;

        $documentType = self::RU_DEFAULT_DOCUMENT_TYPE;
        if (isset($this->ruDocumentTypes[$item->documentType])) {
            $documentType = $this->ruDocumentTypes[$item->documentType];
        }
        $dto->documentType = $documentType;

        $dto->programLink = $item->programLink;

        return $dto;
    }
}
