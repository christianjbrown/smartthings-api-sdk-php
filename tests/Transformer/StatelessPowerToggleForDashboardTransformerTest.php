<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\StatelessPowerToggleForDashboard;
use ChristianBrown\SmartThings\Transformer\StatelessPowerToggleForDashboardTransformer;
use ChristianBrown\SmartThings\Transformer\StatelessPowerToggleForDashboardTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(StatelessPowerToggleForDashboard::class)]
#[CoversClass(StatelessPowerToggleForDashboardTransformer::class)]
final class StatelessPowerToggleForDashboardTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            StatelessPowerToggleForDashboardTransformerInterface::KEY_COMMAND => 'test-command',
            StatelessPowerToggleForDashboardTransformerInterface::KEY_ARGUMENT => 'test-argument',
            StatelessPowerToggleForDashboardTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
        ];

        $transformer = new StatelessPowerToggleForDashboardTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-argument', $actual->getArgument());
        self::assertSame('test-argument-type', $actual->getArgumentType());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new StatelessPowerToggleForDashboardTransformer();

        $actual = $transformer->transform([StatelessPowerToggleForDashboardTransformerInterface::KEY_COMMAND => 'test-command'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'argumentAbsent' => [[], 'getArgument', null];
        yield 'argumentWrongType' => [[StatelessPowerToggleForDashboardTransformerInterface::KEY_ARGUMENT => 42], 'getArgument', null];
        yield 'argumentValid' => [[StatelessPowerToggleForDashboardTransformerInterface::KEY_ARGUMENT => 'test-argument'], 'getArgument', 'test-argument'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[StatelessPowerToggleForDashboardTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[StatelessPowerToggleForDashboardTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new StatelessPowerToggleForDashboardTransformer();

        $actual = $transformer->transform([StatelessPowerToggleForDashboardTransformerInterface::KEY_COMMAND => 'test-command']);

        self::assertNull($actual->getArgument());
        self::assertNull($actual->getArgumentType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new StatelessPowerToggleForDashboardTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'commandAbsent' => [[], sprintf(StatelessPowerToggleForDashboardTransformerInterface::UNEXPECTED_STRING_SPRINTF, StatelessPowerToggleForDashboardTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[StatelessPowerToggleForDashboardTransformerInterface::KEY_COMMAND => 42], sprintf(StatelessPowerToggleForDashboardTransformerInterface::UNEXPECTED_STRING_SPRINTF, StatelessPowerToggleForDashboardTransformerInterface::KEY_COMMAND)];
    }
}
