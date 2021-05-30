<?php

namespace Jascha030\PTempo\Templater;

use Jascha030\PTempo\Engine\StandardTemplateEngine;
use Jascha030\PTempo\Engine\TemplateEngineInterface;
use Jascha030\PTempo\Engine\TwigTemplateEngine;
use Jascha030\PTempo\Exception\InvalidFilePathFileException;
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
        TwigTemplateEngine::class,
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

    /**
     * @throws \Jascha030\PTempo\Exception\InvalidFilePathFileException
     */
    public function renderTemplate(
        string $templatePath,
        array $userInput,
        bool $overwrite = false,
        ?string $outputPath = null
    ): void {
        if (! $this->fileSystem->exists($templatePath)) {
            throw new InvalidFilePathFileException($templatePath);
        }

        $template = $this->getTemplateEngine()->boilerplate($templatePath, $userInput);

        if (! $outputPath) {
            $outputPath = $templatePath;
        }

        if ($overwrite && $this->fileSystem->exists($outputPath)) {

        }

        $this->fileSystem->dumpFile($outputPath, $template);
    }

    private function getTemplateEngine(): TemplateEngineInterface
    {
        if (! isset($this->templateEngine)) {
            $this->templateEngine = new StandardTemplateEngine();
        }

        return $this->templateEngine;
    }
}
