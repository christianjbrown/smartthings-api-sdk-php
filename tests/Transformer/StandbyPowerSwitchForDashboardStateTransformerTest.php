<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardState;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StandbyPowerSwitchForDashboardStateTransformer;
use ChristianBrown\SmartThings\Transformer\StandbyPowerSwitchForDashboardStateTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(StandbyPowerSwitchForDashboardState::class)]
#[CoversClass(StandbyPowerSwitchForDashboardStateTransformer::class)]
final class StandbyPowerSwitchForDashboardStateTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_VALUE => 'test-value',
            StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_ON => 'test-on',
            StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_OFF => 'test-off',
            StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_LABEL => 'test-label',
            StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
        ];

        $transformer = new StandbyPowerSwitchForDashboardStateTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame('test-on', $actual->getOn());
        self::assertSame('test-off', $actual->getOff());
        self::assertSame('test-label', $actual->getLabel());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new StandbyPowerSwitchForDashboardStateTransformer($alternativeItemTransformer);
        $base = [StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_ON => 'test-on', StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_OFF => 'test-off'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new StandbyPowerSwitchForDashboardStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'valueAbsent' => [[StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_ON => 'test-on', StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_OFF => 'test-off'], 'getValue', null];
        yield 'valueWrongType' => [[StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_ON => 'test-on', StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_OFF => 'test-off', StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_VALUE => 42], 'getValue', null];
        yield 'onAbsent' => [[StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_OFF => 'test-off'], 'getOn', null];
        yield 'onWrongType' => [[StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_OFF => 'test-off', StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_ON => 42], 'getOn', null];
        yield 'offAbsent' => [[StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_ON => 'test-on'], 'getOff', null];
        yield 'offWrongType' => [[StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_ON => 'test-on', StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_OFF => 42], 'getOff', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new StandbyPowerSwitchForDashboardStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_ON => 'test-on', StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_OFF => 'test-off'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'labelValid' => [[StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_LABEL => 'test-label'], 'getLabel', 'test-label'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new StandbyPowerSwitchForDashboardStateTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_ON => 'test-on', StandbyPowerSwitchForDashboardStateTransformerInterface::KEY_OFF => 'test-off']);

        self::assertNull($actual->getValueType());
        self::assertNull($actual->getLabel());
        self::assertNull($actual->getAlternatives());
    }
}
