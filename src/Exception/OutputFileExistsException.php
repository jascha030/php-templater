<?php

namespace Jascha030\PTemplater\Exception;

use Jascha030\PTemplater\Templater\Templater;

/**
 * Class OutputFileExistsException
 * @package Jascha030\PTemplater\Exception
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
