<?php

namespace Jascha030\PTempo\Exception;

use Jascha030\PTempo\Templater\Templater;

/**
 * Class OutputFileExistsException
 * @package Jascha030\PTempo\Exception
 */
class OutputFileExistsException extends TemplateFileExceptionAbstract
{
    /**
     * {@inheritdoc}
     */
    public static function getTemplateString(): string
    {
        $class = Templater::class;

        return 'Output file: "%s" already exists. If you want to overwrite the outputFile, enable "$overwrite" in ' . $class . '::renderTemplate()';
    }
}
