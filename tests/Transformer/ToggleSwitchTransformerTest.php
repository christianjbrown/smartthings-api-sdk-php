<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardStateInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitch;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;
use ChristianBrown\SmartThings\Transformer\StandbyPowerSwitchForDashboardStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardCommandTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchTransformer;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ToggleSwitch::class)]
#[CoversClass(ToggleSwitchTransformer::class)]
final class ToggleSwitchTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $toggleSwitchForDashboardCommandModel = self::createStub(ToggleSwitchForDashboardCommandInterface::class);
        $toggleSwitchForDashboardCommandTransformer = self::createStub(ToggleSwitchForDashboardCommandTransformerInterface::class);
        $toggleSwitchForDashboardCommandTransformer->method('transform')->willReturn($toggleSwitchForDashboardCommandModel);
        $standbyPowerSwitchForDashboardStateModel = self::createStub(StandbyPowerSwitchForDashboardStateInterface::class);
        $standbyPowerSwitchForDashboardStateTransformer = self::createStub(StandbyPowerSwitchForDashboardStateTransformerInterface::class);
        $standbyPowerSwitchForDashboardStateTransformer->method('transform')->willReturn($standbyPowerSwitchForDashboardStateModel);
        $data = [
            ToggleSwitchTransformerInterface::KEY_COMMAND => ['test-nested'],
            ToggleSwitchTransformerInterface::KEY_STATE => ['test-nested'],
        ];

        $transformer = new ToggleSwitchTransformer($toggleSwitchForDashboardCommandTransformer, $standbyPowerSwitchForDashboardStateTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($toggleSwitchForDashboardCommandModel, $actual->getCommand());
        self::assertSame($standbyPowerSwitchForDashboardStateModel, $actual->getState());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new ToggleSwitchTransformer(self::createStub(ToggleSwitchForDashboardCommandTransformerInterface::class), self::createStub(StandbyPowerSwitchForDashboardStateTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'commandAbsent' => [[], 'getCommand', null];
        yield 'commandWrongType' => [[ToggleSwitchTransformerInterface::KEY_COMMAND => 'not-array'], 'getCommand', null];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $toggleSwitchForDashboardCommandModel = self::createStub(ToggleSwitchForDashboardCommandInterface::class);
        $toggleSwitchForDashboardCommandTransformer = self::createStub(ToggleSwitchForDashboardCommandTransformerInterface::class);
        $toggleSwitchForDashboardCommandTransformer->method('transform')->willReturn($toggleSwitchForDashboardCommandModel);
        $standbyPowerSwitchForDashboardStateModel = self::createStub(StandbyPowerSwitchForDashboardStateInterface::class);
        $standbyPowerSwitchForDashboardStateTransformer = self::createStub(StandbyPowerSwitchForDashboardStateTransformerInterface::class);
        $standbyPowerSwitchForDashboardStateTransformer->method('transform')->willReturn($standbyPowerSwitchForDashboardStateModel);
        $transformer = new ToggleSwitchTransformer($toggleSwitchForDashboardCommandTransformer, $standbyPowerSwitchForDashboardStateTransformer);

        $actual = $transformer->transform([ToggleSwitchTransformerInterface::KEY_COMMAND => ['test-nested']]);

        self::assertNull($actual->getState());
    }

    public function testTransformState(): void
    {
        $toggleSwitchForDashboardCommandModel = self::createStub(ToggleSwitchForDashboardCommandInterface::class);
        $toggleSwitchForDashboardCommandTransformer = self::createStub(ToggleSwitchForDashboardCommandTransformerInterface::class);
        $toggleSwitchForDashboardCommandTransformer->method('transform')->willReturn($toggleSwitchForDashboardCommandModel);
        $standbyPowerSwitchForDashboardStateModel = self::createStub(StandbyPowerSwitchForDashboardStateInterface::class);
        $standbyPowerSwitchForDashboardStateTransformer = self::createStub(StandbyPowerSwitchForDashboardStateTransformerInterface::class);
        $standbyPowerSwitchForDashboardStateTransformer->method('transform')->willReturn($standbyPowerSwitchForDashboardStateModel);
        $transformer = new ToggleSwitchTransformer($toggleSwitchForDashboardCommandTransformer, $standbyPowerSwitchForDashboardStateTransformer);
        $base = [ToggleSwitchTransformerInterface::KEY_COMMAND => ['test-nested']];

        self::assertNull($transformer->transform($base)->getState());
        self::assertNull($transformer->transform($base + [ToggleSwitchTransformerInterface::KEY_STATE => 'test-not-array'])->getState());
        self::assertSame($standbyPowerSwitchForDashboardStateModel, $transformer->transform($base + [ToggleSwitchTransformerInterface::KEY_STATE => ['test-nested']])->getState());
    }
}
