<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboard;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardStateInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;
use ChristianBrown\SmartThings\Transformer\StandbyPowerSwitchForDashboardStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StandbyPowerSwitchForDashboardTransformer;
use ChristianBrown\SmartThings\Transformer\StandbyPowerSwitchForDashboardTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(StandbyPowerSwitchForDashboard::class)]
#[CoversClass(StandbyPowerSwitchForDashboardTransformer::class)]
final class StandbyPowerSwitchForDashboardTransformerTest extends TestCase
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
            StandbyPowerSwitchForDashboardTransformerInterface::KEY_COMMAND => ['test-nested'],
            StandbyPowerSwitchForDashboardTransformerInterface::KEY_STATE => ['test-nested'],
        ];

        $transformer = new StandbyPowerSwitchForDashboardTransformer($toggleSwitchForDashboardCommandTransformer, $standbyPowerSwitchForDashboardStateTransformer);

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
        $transformer = new StandbyPowerSwitchForDashboardTransformer(self::createStub(ToggleSwitchForDashboardCommandTransformerInterface::class), self::createStub(StandbyPowerSwitchForDashboardStateTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'commandAbsent' => [[], 'getCommand', null];
        yield 'commandWrongType' => [[StandbyPowerSwitchForDashboardTransformerInterface::KEY_COMMAND => 'not-array'], 'getCommand', null];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $toggleSwitchForDashboardCommandModel = self::createStub(ToggleSwitchForDashboardCommandInterface::class);
        $toggleSwitchForDashboardCommandTransformer = self::createStub(ToggleSwitchForDashboardCommandTransformerInterface::class);
        $toggleSwitchForDashboardCommandTransformer->method('transform')->willReturn($toggleSwitchForDashboardCommandModel);
        $standbyPowerSwitchForDashboardStateModel = self::createStub(StandbyPowerSwitchForDashboardStateInterface::class);
        $standbyPowerSwitchForDashboardStateTransformer = self::createStub(StandbyPowerSwitchForDashboardStateTransformerInterface::class);
        $standbyPowerSwitchForDashboardStateTransformer->method('transform')->willReturn($standbyPowerSwitchForDashboardStateModel);
        $transformer = new StandbyPowerSwitchForDashboardTransformer($toggleSwitchForDashboardCommandTransformer, $standbyPowerSwitchForDashboardStateTransformer);

        $actual = $transformer->transform([StandbyPowerSwitchForDashboardTransformerInterface::KEY_COMMAND => ['test-nested']]);

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
        $transformer = new StandbyPowerSwitchForDashboardTransformer($toggleSwitchForDashboardCommandTransformer, $standbyPowerSwitchForDashboardStateTransformer);
        $base = [StandbyPowerSwitchForDashboardTransformerInterface::KEY_COMMAND => ['test-nested']];

        self::assertNull($transformer->transform($base)->getState());
        self::assertNull($transformer->transform($base + [StandbyPowerSwitchForDashboardTransformerInterface::KEY_STATE => 'test-not-array'])->getState());
        self::assertSame($standbyPowerSwitchForDashboardStateModel, $transformer->transform($base + [StandbyPowerSwitchForDashboardTransformerInterface::KEY_STATE => ['test-nested']])->getState());
    }
}
