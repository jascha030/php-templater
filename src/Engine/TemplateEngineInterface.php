<?php

namespace Jascha030\PTempo\Engine;

/**
 * Interface TemplateEngineInterface
 * @package Jascha030\PTempo\Engine
 */
interface TemplateEngineInterface
{
    /**
     * Method implementation responsible for rendering template data to a template.
     *
     * @param string $templatePath
     * @param array  $userInput
     *
     * @return string
     */
    public function renderTemplateData(string $templatePath, array $userInput): string;
}
