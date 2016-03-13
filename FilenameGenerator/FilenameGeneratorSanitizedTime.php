<?php

namespace Gwinn\TinymceFastloadBundle\FilenameGenerator;

use Gwinn\TinymceFastloadBundle\Util\FilenameSanitizer;

class FilenameGeneratorSanitizedTime implements FilenameGeneratorInterface
{
    /**
     * @inheritDoc
     */
    public static function generate($filename, $extension, $object)
    {
        return time().'-'.FilenameSanitizer::sanitize($filename).$extension;
    }
}