<?php

namespace Jascha030\PTemplater;

use Psr\Container\ContainerInterface;
use function DI\factory;
use Symfony\Component\Filesystem\Filesystem;
use Jascha030\PTemplater\Engine\TwigTemplateEngine;
use Jascha030\PTemplater\Templater\Templater;

return [
    Templater::class => static function () {
        $fileSystem = new Filesystem();

        return new Templater($fileSystem);
    },
    TwigTemplateEngine::class => factory(static function (ContainerInterface $c) {
       return new TwigTemplateEngine($c->get('template.dir'));
    }),
];
