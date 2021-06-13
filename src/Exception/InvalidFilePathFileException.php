<?php

namespace Jascha030\PTemplater\Exception;

/**
 * Class InvalidFilePathFileException
 * @package Jascha030\PTemplater\Exception
 */
class InvalidFilePathFileException extends TemplateFileExceptionAbstract
{
    /**
     * {@inheritdoc}
     */
    public static function getTemplateString(): string
    {
        return 'Couldn\'t open template, Invalid file path: "%s".';
    }
}
