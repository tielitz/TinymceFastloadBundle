<?php

namespace Gwinn\TinymceFastloadBundle\Util;

use Symfony\Component\HttpFoundation\File\File;
use Gwinn\TinymceFastloadBundle\FilenameGenerator\FilenameGeneratorInterface;

class FileMover
{
    /**
     * @var string
     */
    private $filenameGenerator;


    public function setFilenameGenerator($filenameGenerator)
    {
        if (class_exists($filenameGenerator)) {
            $refl = new \ReflectionClass($filenameGenerator);
            if ($refl->implementsInterface('Gwinn\TinymceFastloadBundle\FilenameGenerator\FilenameGeneratorInterface')) {
                $this->filenameGenerator = $filenameGenerator;
            }
        }
    }

    /**
     * Moves the file to the targetPath. Creates the path if it doesn't exist
     *
     * @param  File   $file       The file to move
     * @param  string $targetPath The target path
     * @return File               Moved file
     */
    public function move(File $file, $targetPath)
    {
        $filenameWithoutExt = substr($file->getExtension(), 0, strrpos($file->getExtension(), '.'));
        $fileExtension      = $file->getExtension();

        $filename = $this->filenameGenerator->generate($filenameWithoutExt, $fileExtension, $file);

        if (!file_exists($targetPath) && !is_dir($targetPath)) {
            $logger->info('TinyMCE creating directory '.$targetPath);
            mkdir($targetPath);
        }

        return $fileOrig->move($targetPath, $filename);
    }
}