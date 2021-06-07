<?php

namespace Jascha030\PTemplater\Templater;

use Jascha030\PTemplater\Engine\StandardTemplateEngine;
use Jascha030\PTemplater\Engine\TemplateEngineInterface;
use Jascha030\PTemplater\Engine\TwigTemplateEngine;
use Jascha030\PTemplater\Exception\InvalidFilePathFileException;
use Jascha030\PTemplater\Exception\OutputFileExistsException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class Templater
 * @package Jascha030\PTemplater\Templater
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

    private TemplateEngineInterface $templateEngine;

    public function __construct(Filesystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function setEngine(TemplateEngineInterface $engine): self
    {
        $this->templateEngine = $engine;

        return $this;
    }

    /**
     * @throws \Jascha030\PTemplater\Exception\InvalidFilePathFileException
     * @throws \Jascha030\PTemplater\Exception\OutputFileExistsException
     */
    public function renderTemplate(
        string $templatePath,
        array $userInput,
        bool $overwrite = false,
        ?string $outputPath = null
    ): string {
        if (! $this->fileSystem->exists($templatePath)) {
            throw new InvalidFilePathFileException($templatePath);
        }

        if (! $outputPath && $overwrite) {
            $outputPath = $templatePath;
        }

        if (! $overwrite && $this->fileSystem->exists($outputPath)) {
            throw new OutputFileExistsException($outputPath);
        }

        $template = $this->getTemplateEngine()->renderTemplateData($templatePath, $userInput);

        if (! $outputPath) {
            return $template;
        }

        if (! $this->fileSystem->exists($outputPath)) {
            $this->fileSystem->touch($outputPath);
        } else {
            $backup = file_get_contents($outputPath);
            // Todo: store backup somewhere, (maybe redis?).
        }

        $this->fileSystem->dumpFile($outputPath, $template);

        return (new \SplFileInfo($outputPath))->getRealPath();
    }

    private function getTemplateEngine(): TemplateEngineInterface
    {
        if (! isset($this->templateEngine)) {
            $this->templateEngine = new StandardTemplateEngine();
        }

        return $this->templateEngine;
    }
}
