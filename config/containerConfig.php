<?php

namespace Jascha030\PTempo;

use Jascha030\PTempo\Templater\Templater;
use Symfony\Component\Filesystem\Filesystem;

return [
    Templater::class => static function () {
        $fileSystem = new Filesystem();
        return new Templater($fileSystem);
    }
];
