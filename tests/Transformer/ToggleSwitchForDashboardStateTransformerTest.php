<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardState;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardStateTransformer;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardStateTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ToggleSwitchForDashboardState::class)]
#[CoversClass(ToggleSwitchForDashboardStateTransformer::class)]
final class ToggleSwitchForDashboardStateTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            ToggleSwitchForDashboardStateTransformerInterface::KEY_VALUE => 'test-value',
            ToggleSwitchForDashboardStateTransformerInterface::KEY_ON => 'test-on',
            ToggleSwitchForDashboardStateTransformerInterface::KEY_OFF => 'test-off',
            ToggleSwitchForDashboardStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            ToggleSwitchForDashboardStateTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
        ];

        $transformer = new ToggleSwitchForDashboardStateTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-on', $actual->getOn());
        self::assertSame('test-off', $actual->getOff());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new ToggleSwitchForDashboardStateTransformer($alternativeItemTransformer);
        $base = [ToggleSwitchForDashboardStateTransformerInterface::KEY_ON => 'test-on', ToggleSwitchForDashboardStateTransformerInterface::KEY_OFF => 'test-off'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [ToggleSwitchForDashboardStateTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [ToggleSwitchForDashboardStateTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ToggleSwitchForDashboardStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([ToggleSwitchForDashboardStateTransformerInterface::KEY_ON => 'test-on', ToggleSwitchForDashboardStateTransformerInterface::KEY_OFF => 'test-off'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[ToggleSwitchForDashboardStateTransformerInterface::KEY_VALUE => 42], 'getValue', null];
        yield 'valueValid' => [[ToggleSwitchForDashboardStateTransformerInterface::KEY_VALUE => 'test-value'], 'getValue', 'test-value'];
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[ToggleSwitchForDashboardStateTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[ToggleSwitchForDashboardStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new ToggleSwitchForDashboardStateTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([ToggleSwitchForDashboardStateTransformerInterface::KEY_ON => 'test-on', ToggleSwitchForDashboardStateTransformerInterface::KEY_OFF => 'test-off']);

        self::assertNull($actual->getValue());
        self::assertNull($actual->getValueType());
        self::assertNull($actual->getAlternatives());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ToggleSwitchForDashboardStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'onAbsent' => [[ToggleSwitchForDashboardStateTransformerInterface::KEY_OFF => 'test-off'], sprintf(ToggleSwitchForDashboardStateTransformerInterface::UNEXPECTED_STRING_SPRINTF, ToggleSwitchForDashboardStateTransformerInterface::KEY_ON)];
        yield 'onWrongType' => [[ToggleSwitchForDashboardStateTransformerInterface::KEY_OFF => 'test-off', ToggleSwitchForDashboardStateTransformerInterface::KEY_ON => 42], sprintf(ToggleSwitchForDashboardStateTransformerInterface::UNEXPECTED_STRING_SPRINTF, ToggleSwitchForDashboardStateTransformerInterface::KEY_ON)];
        yield 'offAbsent' => [[ToggleSwitchForDashboardStateTransformerInterface::KEY_ON => 'test-on'], sprintf(ToggleSwitchForDashboardStateTransformerInterface::UNEXPECTED_STRING_SPRINTF, ToggleSwitchForDashboardStateTransformerInterface::KEY_OFF)];
        yield 'offWrongType' => [[ToggleSwitchForDashboardStateTransformerInterface::KEY_ON => 'test-on', ToggleSwitchForDashboardStateTransformerInterface::KEY_OFF => 42], sprintf(ToggleSwitchForDashboardStateTransformerInterface::UNEXPECTED_STRING_SPRINTF, ToggleSwitchForDashboardStateTransformerInterface::KEY_OFF)];
    }
}
