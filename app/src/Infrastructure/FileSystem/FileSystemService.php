<?php

namespace App\Infrastructure\FileSystem;

use App\Application\FileSystem\FileSystemServiceInterface;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class FileSystemService.
 *
 * @package App\Infrastructure\FileSystem
 */
class FileSystemService implements FileSystemServiceInterface
{
    /**
     * @var Filesystem
     */
    private Filesystem $filesystem;

    /**
     * FileSystemService constructor.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @inheritDoc
     *
     * @throws IOException
     */
    public function rename(string $file, string $newFileName): string
    {
        // Соответствует "tmp_file" в "/tmp/tmp_file.pdf".
        $oldFileName = pathinfo($file, PATHINFO_FILENAME);

        // Заменить название файла на $newFileName.
        $newFile = str_replace($oldFileName, $newFileName, $file);

        // Переименовать файл.
        $this->filesystem->rename($file, $newFile, true);

        return $newFile;
    }

    /**
     * @inheritDoc
     *
     * @throws IOException
     */
    public function remove(string $file): void
    {
        $this->filesystem->remove($file);
    }
}
