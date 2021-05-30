<?php

namespace Jascha030\PTempo\Exception;

use Throwable;

class InvalidFilePathException extends \Exception implements TemplateExceptionInterface
{
    public static function getMessageTemplate(): string
    {
        return 'Couldn\'t open template, Invalid file path: "%s".';
    }
}
