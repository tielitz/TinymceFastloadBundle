<?php

namespace Gwinn\TinymceFastloadBundle\FilenameGenerator;

interface FilenameGeneratorInterface
{
    /**
     * Generates a new filename
     *
     * @param  string $filename   Filename without extension
     * @param  string $extension  Extension with dot: .jpg, .gif, etc
     * @param  object $object
     *
     * @return string
     */
    public static function generate($filename, $extension, $object);
}