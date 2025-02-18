<?php

declare(strict_types=1);

namespace Symplify\PHPStanRules\Tests\Rules\Complexity\ForbiddenSameNamedAssignRule;

use Iterator;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Symplify\PHPStanRules\Rules\Complexity\ForbiddenSameNamedAssignRule;

/**
 * @extends RuleTestCase<ForbiddenSameNamedAssignRule>
 */
final class ForbiddenSameNamedAssignRuleTest extends RuleTestCase
{
    /**
     * @dataProvider provideData()
     * @param mixed[] $expectedErrorMessagesWithLines
     */
    public function testRule(string $filePath, array $expectedErrorMessagesWithLines): void
    {
        $this->analyse([$filePath], $expectedErrorMessagesWithLines);
    }

    public function provideData(): Iterator
    {
        yield [__DIR__ . '/Fixture/SkipScopedClosures.php', []];
        yield [__DIR__ . '/Fixture/SkipPositionNames.php', []];
        yield [__DIR__ . '/Fixture/SkipFunctionCall.php', []];
        yield [__DIR__ . '/Fixture/SkipInitialization.php', []];
        yield [__DIR__ . '/Fixture/SkipInitializationWithNull.php', []];
        yield [__DIR__ . '/Fixture/SkipInIf.php', []];
        yield [__DIR__ . '/Fixture/SkipInWhileOrFor.php', []];
        yield [__DIR__ . '/Fixture/SkipDifferentVariableNames.php', []];
        yield [__DIR__ . '/Fixture/SkipTestCase.php', []];
        yield [__DIR__ . '/Fixture/SkipSwitch.php', []];
        yield [__DIR__ . '/Fixture/SkipInlineIf.php', []];
        yield [__DIR__ . '/Fixture/SkipArrayFilterValues.php', []];

        $errorMessage = sprintf(ForbiddenSameNamedAssignRule::ERROR_MESSAGE, '$first');
        yield [__DIR__ . '/Fixture/SameVariableNames.php', [[$errorMessage, 9]]];
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ForbiddenSameNamedAssignRule::class);
    }
}
