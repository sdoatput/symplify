<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\DowngradeLevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([DowngradeLevelSetList::DOWN_TO_PHP_72]);

    $rectorConfig->skip([
        '*/Tests/*',
        '*/tests/*',
        __DIR__ . '/../../tests',
        # missing "optional" dependency and never used here
        '*/symfony/framework-bundle/KernelBrowser.php',
        '*/symfony/http-kernel/HttpKernelBrowser.php',
        '*/symfony/cache/*',
        // fails on DOMCaster
        '*/symfony/var-dumper/*',
        '*/symfony/var-exporter/*',
        '*/symfony/error-handler/*',
        '*/symfony/event-dispatcher/*',
        '*/symfony/event-dispatcher-contracts/*',
        '*/symfony/http-foundation/*',
    ]);
};
