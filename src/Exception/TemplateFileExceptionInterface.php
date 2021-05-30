<?php

namespace Jascha030\PTempo\Exception;

/**
 * Interface TemplateFileExceptionInterface
 * @package Jascha030\PTempo\Exception
 */
interface TemplateFileExceptionInterface
{
    /**
     * Provide a path string to be injected in the template string
     *
     * @param string $fileName
     */
    public function __construct(string $fileName);

    /**
     * Provide template string to be injected with $filePath.
     *
     * @return string
     */
    public static function getTemplateString(): string;

    /**
     * Creates the message, to be passed to \Exception constructor
     *
     * @param string $filePath
     *
     * @return string
     */
    public static function createMessage(string $filePath): string;
}
