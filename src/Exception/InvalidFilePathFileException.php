<?php

namespace Jascha030\PTempo\Exception;

/**
 * Class InvalidFilePathFileException
 * @package Jascha030\PTempo\Exception
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
