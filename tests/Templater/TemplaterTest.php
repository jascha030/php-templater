<?php

declare(strict_types=1);

namespace Templater;

use Jascha030\PTemplater\Engine\StandardTemplateEngine;
use Jascha030\PTemplater\Engine\TwigTemplateEngine;
use Jascha030\PTemplater\Templater\Templater;
use Jascha030\PTemplater\Templater\TemplaterInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class TemplaterTest
 * @package Templater
 */
class TemplaterTest extends TestCase
{
    public function testConstruction(): TemplaterInterface
    {
        $templater        = new Templater();
        $defaultTemplater = new Templater(new StandardTemplateEngine());
        $templaterTwig    = new Templater(new TwigTemplateEngine(dirname(__FILE__, 2) . '/Fixture/templates/twig'));

        self::assertInstanceOf(TemplaterInterface::class, $templater);
        self::assertInstanceOf(TemplaterInterface::class, $defaultTemplater);
        self::assertInstanceOf(TemplaterInterface::class, $templaterTwig);

        self::assertInstanceOf(TwigTemplateEngine::class, $templaterTwig->getTemplateEngine());
        self::assertInstanceOf(StandardTemplateEngine::class, $defaultTemplater->getTemplateEngine());
        self::assertEquals($defaultTemplater->getTemplateEngine(), $templater->getTemplateEngine());

        return $templater;
    }

    public function testSetTemplater(): void
    {
        $templater = new Templater();
        $templater->setEngine(new TwigTemplateEngine(dirname(__FILE__, 2) . '/Fixture/templates/twig'));

        self::assertInstanceOf(TwigTemplateEngine::class, $templater->getTemplateEngine());
    }


}
