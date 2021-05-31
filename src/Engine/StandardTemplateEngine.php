<?php

namespace Jascha030\PTemplater\Engine;

/**
 * Class StandardTemplateEngine
 * Simple default template engine using plain php to render data.
 *
 * @package Jascha030\PTemplater\Engine
 */
class StandardTemplateEngine implements TemplateEngineInterface
{
    public function renderTemplateData(string $templatePath, array $userInput = []): string
    {
        $template = @file_get_contents($templatePath);

        foreach ($userInput as $key => $value) {
            $template = str_replace("{{$key}}", $value, $template);
        }

        return $template;
    }
}
