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
final class Templater implements TemplaterInterface
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

    /**
     * Used to temporarily store file contents for rollback.
     *
     * @var array
     */
    private array $backup;

    /**
     * Templater constructor.
     */
    public function __construct(?TemplateEngineInterface $engine = null)
    {
        $this->fileSystem = new Filesystem();

        $this->backup = [];

        if ($engine) {
            $this->setEngine($engine);
        }
    }

    public function setEngine(TemplateEngineInterface $engine): TemplaterInterface
    {
        $this->templateEngine = $engine;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Jascha030\PTemplater\Exception\InvalidFilePathFileException
     * @throws \Jascha030\PTemplater\Exception\OutputFileExistsException
     * @throws \Exception
     */
    public function renderTemplate(string $template, array $input, bool $overwrite = false, $outputPath = null): string {
        if ($outputPath && $outputPath instanceof \SplFileInfo) {
            $outputPath = $outputPath->getRealPath();
        }

        if (! $this->fileSystem->exists($template)) {
            throw new InvalidFilePathFileException($template);
        }

        $templateFileInfo = new \SplFileInfo($template);

        if (! $templateFileInfo->isWritable()) {
            throw new \Exception("New content could not be written for file: \"{$templateFileInfo->getFilename()}\".");
        }

        $this->backup[$templateFileInfo->getRealPath()] = @file_get_contents($templateFileInfo->getRealPath());

        $renderedData = $this->templateEngine->renderTemplateData($template, $input);

        if ($overwrite) {
            if (! $outputPath) {
                $outputPath = $template;
            }

            return $this->overWriteFile($outputPath, $renderedData);
        }

        if ($outputPath) {
            return $this->writeNewFile($outputPath, $renderedData);
        }

        return $renderedData;
    }

    /**
     * Write generated templateData to new file.
     * @throws \Jascha030\PTemplater\Exception\OutputFileExistsException
     */
    private function writeNewFile(string $outputPath, string $renderData): \SplFileInfo
    {
        if ($this->fileSystem->exists($outputPath)) {
            throw new OutputFileExistsException($outputPath);
        }

        $this->fileSystem->touch($outputPath);
        $this->fileSystem->dumpFile($outputPath, $renderData);

        return new \SplFileInfo($outputPath);
    }

    /**
     * Get set templating engine, defaults to StandardTemplateEngine.
     * @return \Jascha030\PTemplater\Engine\TemplateEngineInterface
     */
    public function getTemplateEngine(): TemplateEngineInterface
    {
        if (! isset($this->templateEngine)) {
            $this->templateEngine = new StandardTemplateEngine();
        }

        return $this->templateEngine;
    }

    public function getBackupCache(): array
    {
        return $this->backup;
    }

    /**
     * Remove temp file backups for rollback.
     */
    public function clearBackupCache(): void
    {
        $this->backup = [];
    }

    /**
     * Revert files to original state on failure.
     */
    public function rollBackFiles(): void
    {
        foreach ($this->backup as $filePath => $originalContents) {
            @file_put_contents($filePath, $originalContents);
        }

        $this->clearBackupCache();
    }
}
