<?php

declare(strict_types=1);

return static function (string $file) {
    $locations = [
        dirname($file) . '/vendor/autoload.php',
        dirname($file, 2) .  '/autoload.php',
        getenv('HOME') . '/.composer/vendor/autoload.php',
    ];

    foreach ($locations as $autoloaderPath) {
        if (is_file($autoloaderPath)) {
            return $autoloaderPath;
        }
    }

    $errorMsg = sprintf(
        'Couldn\'t find Composer\'s Autoloader file in any of the following paths: 
                %s, please make sure you run the %s or %s commands.',
        implode(', ', $locations),
        '<pre>composer install --prefer-source</pre>',
        '<pre>composer dump-autoload</pre>'
    );

    throw new \RuntimeException($errorMsg);
};
