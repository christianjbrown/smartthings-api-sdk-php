<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommand;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardCommandTransformer;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ToggleSwitchForDashboardCommand::class)]
#[CoversClass(ToggleSwitchForDashboardCommandTransformer::class)]
final class ToggleSwitchForDashboardCommandTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ToggleSwitchForDashboardCommandTransformerInterface::KEY_NAME => 'test-name',
            ToggleSwitchForDashboardCommandTransformerInterface::KEY_ON => 'test-on',
            ToggleSwitchForDashboardCommandTransformerInterface::KEY_OFF => 'test-off',
            ToggleSwitchForDashboardCommandTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
        ];

        $transformer = new ToggleSwitchForDashboardCommandTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertSame('test-on', $actual->getOn());
        self::assertSame('test-off', $actual->getOff());
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
        $transformer = new ToggleSwitchForDashboardCommandTransformer();

        $actual = $transformer->transform([ToggleSwitchForDashboardCommandTransformerInterface::KEY_ON => 'test-on', ToggleSwitchForDashboardCommandTransformerInterface::KEY_OFF => 'test-off'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'nameAbsent' => [[], 'getName', null];
        yield 'nameWrongType' => [[ToggleSwitchForDashboardCommandTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'nameValid' => [[ToggleSwitchForDashboardCommandTransformerInterface::KEY_NAME => 'test-name'], 'getName', 'test-name'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[ToggleSwitchForDashboardCommandTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[ToggleSwitchForDashboardCommandTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new ToggleSwitchForDashboardCommandTransformer();

        $actual = $transformer->transform([ToggleSwitchForDashboardCommandTransformerInterface::KEY_ON => 'test-on', ToggleSwitchForDashboardCommandTransformerInterface::KEY_OFF => 'test-off']);

        self::assertNull($actual->getName());
        self::assertNull($actual->getArgumentType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ToggleSwitchForDashboardCommandTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'onAbsent' => [[ToggleSwitchForDashboardCommandTransformerInterface::KEY_OFF => 'test-off'], sprintf(ToggleSwitchForDashboardCommandTransformerInterface::UNEXPECTED_STRING_SPRINTF, ToggleSwitchForDashboardCommandTransformerInterface::KEY_ON)];
        yield 'onWrongType' => [[ToggleSwitchForDashboardCommandTransformerInterface::KEY_OFF => 'test-off', ToggleSwitchForDashboardCommandTransformerInterface::KEY_ON => 42], sprintf(ToggleSwitchForDashboardCommandTransformerInterface::UNEXPECTED_STRING_SPRINTF, ToggleSwitchForDashboardCommandTransformerInterface::KEY_ON)];
        yield 'offAbsent' => [[ToggleSwitchForDashboardCommandTransformerInterface::KEY_ON => 'test-on'], sprintf(ToggleSwitchForDashboardCommandTransformerInterface::UNEXPECTED_STRING_SPRINTF, ToggleSwitchForDashboardCommandTransformerInterface::KEY_OFF)];
        yield 'offWrongType' => [[ToggleSwitchForDashboardCommandTransformerInterface::KEY_ON => 'test-on', ToggleSwitchForDashboardCommandTransformerInterface::KEY_OFF => 42], sprintf(ToggleSwitchForDashboardCommandTransformerInterface::UNEXPECTED_STRING_SPRINTF, ToggleSwitchForDashboardCommandTransformerInterface::KEY_OFF)];
    }
}
