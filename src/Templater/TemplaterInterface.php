<?php

declare(strict_types=1);

namespace Jascha030\PTemplater\Templater;

use Jascha030\PTemplater\Engine\TemplateEngineInterface;

/**
 * Interface TemplaterInterface
 * @package Jascha030\PTemplater\Templater
 */
interface TemplaterInterface
{
    /**
     * @param \Jascha030\PTemplater\Engine\TemplateEngineInterface $engine
     *
     * @return \Jascha030\PTemplater\Templater\TemplaterInterface
     */
    public function setEngine(TemplateEngineInterface $engine): TemplaterInterface;

    /**
     * Renders template to file or string.
     *
     * @param string $template
     * @param array  $input
     * @param bool   $overwrite
     * @param null   $outputPath
     *
     * @return mixed
     */
    public function renderTemplate(string $template, array $input, bool $overwrite = false, $outputPath = null);
}
