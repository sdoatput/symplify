<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ClassNotation\FinalInternalClassFixer;
use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocAnnotationRemoveFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/config.php');

    $services = $containerConfigurator->services();

    $services->defaults()
        ->public()
        ->autowire()
        ->autoconfigure();

    $services->set(FinalInternalClassFixer::class);

    $services->load('Symplify\CodingStandard\Fixer\\', __DIR__ . '/../src/Fixer')
        ->exclude([
            __DIR__ . '/../src/Fixer/Annotation',
            __DIR__ . '/../src/Fixer/Spacing/StandaloneLineConstructorParamFixer.php',
        ]);

    $services->set(GeneralPhpdocAnnotationRemoveFixer::class)
        ->call('configure', [[
            'annotations' => ['throws', 'author', 'package', 'group', 'covers'],
        ]]);
};
