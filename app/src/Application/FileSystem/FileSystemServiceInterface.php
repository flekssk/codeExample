<?php

namespace App\Application\FileSystem;

/**
 * Interface FileSystemServiceInterface.
 *
 * @package App\Application\FileSystemService
 */
interface FileSystemServiceInterface
{
    /**
     * @param string $file
     * @param string $newFileName
     *
     * @return string
     */
    public function rename(string $file, string $newFileName): string;


    /**
     * @param string $file
     */
    public function remove(string $file): void;
}
