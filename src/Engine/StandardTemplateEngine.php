<?php

namespace Jascha030\PTempo\Engine;

class TemplateEngine implements TemplateEngineInterface
{
    public function boilerplate(string $templatePath, array $userInput = []): string
    {
        $template = file_get_contents($templatePath);

        foreach ($userInput as $key => $value) {
            $template = str_replace("{{$key}}", $value, $template);
        }

        return $template;
    }
}
