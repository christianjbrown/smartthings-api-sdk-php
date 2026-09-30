<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\SwitchForDashboard;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardStateInterface;
use ChristianBrown\SmartThings\Transformer\SwitchForDashboardTransformer;
use ChristianBrown\SmartThings\Transformer\SwitchForDashboardTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardCommandTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardStateTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SwitchForDashboard::class)]
#[CoversClass(SwitchForDashboardTransformer::class)]
final class SwitchForDashboardTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $toggleSwitchForDashboardCommandModel = self::createStub(ToggleSwitchForDashboardCommandInterface::class);
        $toggleSwitchForDashboardCommandTransformer = self::createStub(ToggleSwitchForDashboardCommandTransformerInterface::class);
        $toggleSwitchForDashboardCommandTransformer->method('transform')->willReturn($toggleSwitchForDashboardCommandModel);
        $toggleSwitchForDashboardStateModel = self::createStub(ToggleSwitchForDashboardStateInterface::class);
        $toggleSwitchForDashboardStateTransformer = self::createStub(ToggleSwitchForDashboardStateTransformerInterface::class);
        $toggleSwitchForDashboardStateTransformer->method('transform')->willReturn($toggleSwitchForDashboardStateModel);
        $data = [
            SwitchForDashboardTransformerInterface::KEY_COMMAND => ['test-nested'],
            SwitchForDashboardTransformerInterface::KEY_STATE => ['test-nested'],
        ];

        $transformer = new SwitchForDashboardTransformer($toggleSwitchForDashboardCommandTransformer, $toggleSwitchForDashboardStateTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($toggleSwitchForDashboardCommandModel, $actual->getCommand());
        self::assertSame($toggleSwitchForDashboardStateModel, $actual->getState());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new SwitchForDashboardTransformer(self::createStub(ToggleSwitchForDashboardCommandTransformerInterface::class), self::createStub(ToggleSwitchForDashboardStateTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'commandAbsent' => [[], 'getCommand', null];
        yield 'commandWrongType' => [[SwitchForDashboardTransformerInterface::KEY_COMMAND => 'not-array'], 'getCommand', null];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $toggleSwitchForDashboardCommandModel = self::createStub(ToggleSwitchForDashboardCommandInterface::class);
        $toggleSwitchForDashboardCommandTransformer = self::createStub(ToggleSwitchForDashboardCommandTransformerInterface::class);
        $toggleSwitchForDashboardCommandTransformer->method('transform')->willReturn($toggleSwitchForDashboardCommandModel);
        $toggleSwitchForDashboardStateModel = self::createStub(ToggleSwitchForDashboardStateInterface::class);
        $toggleSwitchForDashboardStateTransformer = self::createStub(ToggleSwitchForDashboardStateTransformerInterface::class);
        $toggleSwitchForDashboardStateTransformer->method('transform')->willReturn($toggleSwitchForDashboardStateModel);
        $transformer = new SwitchForDashboardTransformer($toggleSwitchForDashboardCommandTransformer, $toggleSwitchForDashboardStateTransformer);

        $actual = $transformer->transform([SwitchForDashboardTransformerInterface::KEY_COMMAND => ['test-nested']]);

        self::assertNull($actual->getState());
    }

    public function testTransformState(): void
    {
        $toggleSwitchForDashboardCommandModel = self::createStub(ToggleSwitchForDashboardCommandInterface::class);
        $toggleSwitchForDashboardCommandTransformer = self::createStub(ToggleSwitchForDashboardCommandTransformerInterface::class);
        $toggleSwitchForDashboardCommandTransformer->method('transform')->willReturn($toggleSwitchForDashboardCommandModel);
        $toggleSwitchForDashboardStateModel = self::createStub(ToggleSwitchForDashboardStateInterface::class);
        $toggleSwitchForDashboardStateTransformer = self::createStub(ToggleSwitchForDashboardStateTransformerInterface::class);
        $toggleSwitchForDashboardStateTransformer->method('transform')->willReturn($toggleSwitchForDashboardStateModel);
        $transformer = new SwitchForDashboardTransformer($toggleSwitchForDashboardCommandTransformer, $toggleSwitchForDashboardStateTransformer);
        $base = [SwitchForDashboardTransformerInterface::KEY_COMMAND => ['test-nested']];

        self::assertNull($transformer->transform($base)->getState());
        self::assertNull($transformer->transform($base + [SwitchForDashboardTransformerInterface::KEY_STATE => 'test-not-array'])->getState());
        self::assertSame($toggleSwitchForDashboardStateModel, $transformer->transform($base + [SwitchForDashboardTransformerInterface::KEY_STATE => ['test-nested']])->getState());
    }
}
