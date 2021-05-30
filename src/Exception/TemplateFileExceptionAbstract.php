<?php

namespace Jascha030\PTempo\Exception;

use Throwable;

/**
 * Class TemplateFileExceptionAbstract
 * @package Jascha030\PTempo\Exception
 */
abstract class TemplateFileExceptionAbstract extends \Exception implements TemplateFileExceptionInterface
{
    /**
     * TemplateFileExceptionAbstract constructor.
     *
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        parent::__construct(static::createMessage($filePath));
    }

    /**
     * Creates the message from templateString
     *
     * @param string $filePath
     *
     * @return string
     */
    public static function createMessage(string $filePath): string
    {
        return sprintf(static::getTemplateString(), $filePath);
    }
}
