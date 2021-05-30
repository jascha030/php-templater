<?php

namespace Jascha030\PTempo\Engine;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigTemplateEngine implements TemplateEngineInterface
{
    private Environment $twig;

    /**
     * TwigTemplateEngine constructor.
     *
     * @param string|array $loaderPath
     */
    public function __construct(string $loaderPath)
    {
        $loader     = new FilesystemLoader($loaderPath);
        $this->twig = new Environment($loader);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function renderTemplateData(string $templatePath, array $userInput): string
    {
        return $this->twig->render($templatePath, $userInput);
    }
}
