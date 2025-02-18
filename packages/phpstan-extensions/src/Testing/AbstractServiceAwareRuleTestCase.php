<?php

declare(strict_types=1);

namespace Symplify\PHPStanExtensions\Testing;

use PHPStan\DependencyInjection\Container;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Symplify\PHPStanExtensions\DependencyInjection\PHPStanContainerFactory;
use Symplify\PHPStanExtensions\Exception\SwappedArgumentsException;

/**
 * @template TRule of \PHPStan\Rules\Rule
 * @template-extends RuleTestCase<TRule>
 *
 * @deprecated Use getAdditionalConfigFiles(), \PHPStan\Testing\RuleTestCase and self::getContainer()->getByType() instead
 */
abstract class AbstractServiceAwareRuleTestCase extends RuleTestCase
{
    /**
     * @var array<string, Container>
     */
    private static array $containersByConfig = [];

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        $parentConfigs = parent::getAdditionalConfigFiles();
        return array_merge(
            $parentConfigs,
            [__DIR__ . '/../../config/bleeding-edge-enable-connecting-node-visitor.neon']
        );
    }

    /**
     * @param class-string<TRule> $ruleClass
     * @return TRule
     */
    protected function getRuleFromConfig(string $ruleClass, string $config): Rule
    {
        if (\str_contains($config, '\\') && file_exists($ruleClass)) {
            $message = sprintf('Swapped arguments in "%s()" method', __METHOD__);
            throw new SwappedArgumentsException($message);
        }

        $container = $this->getServiceContainer($config);

        return $container->getByType($ruleClass);
    }

    private function getServiceContainer(string $config): Container
    {
        if (isset(self::$containersByConfig[$config])) {
            return self::$containersByConfig[$config];
        }

        $phpStanContainerFactory = new PHPStanContainerFactory();
        $container = $phpStanContainerFactory->createContainer([$config]);
        self::$containersByConfig[$config] = $container;

        return $container;
    }
}
