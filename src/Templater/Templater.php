<?php

namespace Jascha030\PTempo\Templater;

use Jascha030\PTempo\Engine\StandardTemplateEngine;
use Jascha030\PTempo\Engine\TwigTemplateEngine;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class Templater
 * @package Jascha030\PTempo\Templater
 */
final class Templater
{
    /**
     * Available implementations of TemplateEngineInterface
     */
    public const TEMPLATE_ENGINES = [
        StandardTemplateEngine::class,
        TwigTemplateEngine::class
    ];

    private Filesystem $fileSystem;

    private StandardTemplateEngine $templateEngine;

    public function __construct(Filesystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function setEngine(StandardTemplateEngine $engine): self
    {
        $this->templateEngine = $engine;

        return $this;
    }

    public function renderTemplate(string $templatePath, array $userInput, ?string $outputPath = null): void
    {
        if (! $this->fileSystem->exists($templatePath)) {
            // todo: throw custom exception
        }

        $template = $this->templateEngine->boilerplate($templatePath, $userInput);

        if (! $outputPath) {
            $outputPath = $templatePath;
        }

        $this->fileSystem->dumpFile($outputPath, $template);
    }
}
