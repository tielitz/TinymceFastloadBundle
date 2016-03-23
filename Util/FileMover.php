<?php

namespace Gwinn\TinymceFastloadBundle\Util;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Gwinn\TinymceFastloadBundle\FilenameGenerator\FilenameGeneratorInterface;
use Gwinn\TinymceFastloadBundle\Exception\InvalidMappingException;

class FileMover
{
    /**
     * @var string
     */
    private $filenameGenerator;

    /**
     * Sets the use fileGenerator
     *
     * @param  string                  $filenameGenerator Classpath for the filenameGenerator
     * @throws InvalidMappingException
     */
    public function setFilenameGenerator($filenameGenerator)
    {
        if (class_exists($filenameGenerator)) {
            $refl = new \ReflectionClass($filenameGenerator);
            if ($refl->implementsInterface('Gwinn\TinymceFastloadBundle\FilenameGenerator\FilenameGeneratorInterface')) {
                $this->filenameGenerator = $filenameGenerator;
                return;
            }
        }

        $msg = 'The FilenameGenerator for FileMover must be an existing class implementing FileGeneratorInterface.';
        throw new InvalidMappingException($msg);
    }

    /**
     * Moves the file to the targetPath. Creates the path if it doesn't exist
     *
     * @param  UploadedFile   $file       The file to move
     * @param  string $targetPath The target path
     * @return UploadedFile               Moved file
     */
    public function move(UploadedFile $file, $targetPath)
    {
        $filenameWithoutExt = substr($file->getClientOriginalName(), 0, strrpos($file->getClientOriginalName(), '.'));
        $fileExtension      = '.'.$file->getClientOriginalExtension();

        $generator = $this->filenameGenerator;
        $filename  = $generator::generate($filenameWithoutExt, $fileExtension, $file);

        if (!file_exists($targetPath) && !is_dir($targetPath)) {
            $logger->info('TinyMCE creating directory '.$targetPath);
            mkdir($targetPath);
        }

        return $file->move($targetPath, $filename);
    }
}