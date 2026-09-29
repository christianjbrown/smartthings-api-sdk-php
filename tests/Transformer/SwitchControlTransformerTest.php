<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardStateInterface;
use ChristianBrown\SmartThings\Model\SwitchControl;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;
use ChristianBrown\SmartThings\Transformer\StandbyPowerSwitchForDashboardStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SwitchControlTransformer;
use ChristianBrown\SmartThings\Transformer\SwitchControlTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(SwitchControl::class)]
#[CoversClass(SwitchControlTransformer::class)]
final class SwitchControlTransformerTest extends TestCase
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
            SwitchControlTransformerInterface::KEY_COMMAND => ['test-nested'],
            SwitchControlTransformerInterface::KEY_STATE => ['test-nested'],
        ];

        $transformer = new SwitchControlTransformer($toggleSwitchForDashboardCommandTransformer, $standbyPowerSwitchForDashboardStateTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($toggleSwitchForDashboardCommandModel, $actual->getCommand());
        self::assertSame($standbyPowerSwitchForDashboardStateModel, $actual->getState());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $toggleSwitchForDashboardCommandModel = self::createStub(ToggleSwitchForDashboardCommandInterface::class);
        $toggleSwitchForDashboardCommandTransformer = self::createStub(ToggleSwitchForDashboardCommandTransformerInterface::class);
        $toggleSwitchForDashboardCommandTransformer->method('transform')->willReturn($toggleSwitchForDashboardCommandModel);
        $standbyPowerSwitchForDashboardStateModel = self::createStub(StandbyPowerSwitchForDashboardStateInterface::class);
        $standbyPowerSwitchForDashboardStateTransformer = self::createStub(StandbyPowerSwitchForDashboardStateTransformerInterface::class);
        $standbyPowerSwitchForDashboardStateTransformer->method('transform')->willReturn($standbyPowerSwitchForDashboardStateModel);
        $transformer = new SwitchControlTransformer($toggleSwitchForDashboardCommandTransformer, $standbyPowerSwitchForDashboardStateTransformer);

        $actual = $transformer->transform([SwitchControlTransformerInterface::KEY_COMMAND => ['test-nested']]);

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
        $transformer = new SwitchControlTransformer($toggleSwitchForDashboardCommandTransformer, $standbyPowerSwitchForDashboardStateTransformer);
        $base = [SwitchControlTransformerInterface::KEY_COMMAND => ['test-nested']];

        self::assertNull($transformer->transform($base)->getState());
        self::assertNull($transformer->transform($base + [SwitchControlTransformerInterface::KEY_STATE => 'test-not-array'])->getState());
        self::assertSame($standbyPowerSwitchForDashboardStateModel, $transformer->transform($base + [SwitchControlTransformerInterface::KEY_STATE => ['test-nested']])->getState());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new SwitchControlTransformer(self::createStub(ToggleSwitchForDashboardCommandTransformerInterface::class), self::createStub(StandbyPowerSwitchForDashboardStateTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'commandAbsent' => [[], sprintf(SwitchControlTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, SwitchControlTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[SwitchControlTransformerInterface::KEY_COMMAND => 'not-array'], sprintf(SwitchControlTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, SwitchControlTransformerInterface::KEY_COMMAND)];
    }
}
