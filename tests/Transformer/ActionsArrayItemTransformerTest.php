<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ActionsArrayItem;
use ChristianBrown\SmartThings\Model\PlayPauseInterface;
use ChristianBrown\SmartThings\Model\PlayStopInterface;
use ChristianBrown\SmartThings\Model\PushButtonInterface;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardInterface;
use ChristianBrown\SmartThings\Model\StatelessPowerToggleForDashboardInterface;
use ChristianBrown\SmartThings\Model\SwitchForDashboardInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\ActionsArrayItemTransformer;
use ChristianBrown\SmartThings\Transformer\ActionsArrayItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PlayPauseTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PlayStopTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PushButtonTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StandbyPowerSwitchForDashboardTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StatelessPowerToggleForDashboardTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SwitchForDashboardTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ActionsArrayItem::class)]
#[CoversClass(ActionsArrayItemTransformer::class)]
final class ActionsArrayItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $toggleSwitchForDashboardModel = self::createStub(ToggleSwitchForDashboardInterface::class);
        $toggleSwitchForDashboardTransformer = self::createStub(ToggleSwitchForDashboardTransformerInterface::class);
        $toggleSwitchForDashboardTransformer->method('transform')->willReturn($toggleSwitchForDashboardModel);
        $switchForDashboardModel = self::createStub(SwitchForDashboardInterface::class);
        $switchForDashboardTransformer = self::createStub(SwitchForDashboardTransformerInterface::class);
        $switchForDashboardTransformer->method('transform')->willReturn($switchForDashboardModel);
        $standbyPowerSwitchForDashboardModel = self::createStub(StandbyPowerSwitchForDashboardInterface::class);
        $standbyPowerSwitchForDashboardTransformer = self::createStub(StandbyPowerSwitchForDashboardTransformerInterface::class);
        $standbyPowerSwitchForDashboardTransformer->method('transform')->willReturn($standbyPowerSwitchForDashboardModel);
        $statelessPowerToggleForDashboardModel = self::createStub(StatelessPowerToggleForDashboardInterface::class);
        $statelessPowerToggleForDashboardTransformer = self::createStub(StatelessPowerToggleForDashboardTransformerInterface::class);
        $statelessPowerToggleForDashboardTransformer->method('transform')->willReturn($statelessPowerToggleForDashboardModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $data = [
            ActionsArrayItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            ActionsArrayItemTransformerInterface::KEY_PUSH_BUTTON => ['test-nested'],
            ActionsArrayItemTransformerInterface::KEY_TOGGLE_SWITCH => ['test-nested'],
            ActionsArrayItemTransformerInterface::KEY_SWITCH => ['test-nested'],
            ActionsArrayItemTransformerInterface::KEY_STANDBY_POWER_SWITCH => ['test-nested'],
            ActionsArrayItemTransformerInterface::KEY_STATELESS_POWER_TOGGLE => ['test-nested'],
            ActionsArrayItemTransformerInterface::KEY_PLAY_PAUSE => ['test-nested'],
            ActionsArrayItemTransformerInterface::KEY_PLAY_STOP => ['test-nested'],
            ActionsArrayItemTransformerInterface::KEY_GROUP => 'test-group',
            ActionsArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability',
            ActionsArrayItemTransformerInterface::KEY_VERSION => 7,
            ActionsArrayItemTransformerInterface::KEY_COMPONENT => 'test-component',
            ActionsArrayItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested'],
        ];

        $transformer = new ActionsArrayItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-display-type', $actual->getDisplayType());
        self::assertSame($pushButtonModel, $actual->getPushButton());
        self::assertSame($toggleSwitchForDashboardModel, $actual->getToggleSwitch());
        self::assertSame($switchForDashboardModel, $actual->getSwitch());
        self::assertSame($standbyPowerSwitchForDashboardModel, $actual->getStandbyPowerSwitch());
        self::assertSame($statelessPowerToggleForDashboardModel, $actual->getStatelessPowerToggle());
        self::assertSame($playPauseModel, $actual->getPlayPause());
        self::assertSame($playStopModel, $actual->getPlayStop());
        self::assertSame('test-group', $actual->getGroup());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame($visibleConditionModel, $actual->getVisibleCondition());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new ActionsArrayItemTransformer(self::createStub(PushButtonTransformerInterface::class), self::createStub(ToggleSwitchForDashboardTransformerInterface::class), self::createStub(SwitchForDashboardTransformerInterface::class), self::createStub(StandbyPowerSwitchForDashboardTransformerInterface::class), self::createStub(StatelessPowerToggleForDashboardTransformerInterface::class), self::createStub(PlayPauseTransformerInterface::class), self::createStub(PlayStopTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'displayTypeAbsent' => [[ActionsArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getDisplayType', null];
        yield 'displayTypeWrongType' => [[ActionsArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability', ActionsArrayItemTransformerInterface::KEY_DISPLAY_TYPE => 42], 'getDisplayType', null];
        yield 'capabilityAbsent' => [[ActionsArrayItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'], 'getCapability', null];
        yield 'capabilityWrongType' => [[ActionsArrayItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', ActionsArrayItemTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ActionsArrayItemTransformer(self::createStub(PushButtonTransformerInterface::class), self::createStub(ToggleSwitchForDashboardTransformerInterface::class), self::createStub(SwitchForDashboardTransformerInterface::class), self::createStub(StandbyPowerSwitchForDashboardTransformerInterface::class), self::createStub(StatelessPowerToggleForDashboardTransformerInterface::class), self::createStub(PlayPauseTransformerInterface::class), self::createStub(PlayStopTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform([ActionsArrayItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', ActionsArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'groupAbsent' => [[], 'getGroup', null];
        yield 'groupWrongType' => [[ActionsArrayItemTransformerInterface::KEY_GROUP => 42], 'getGroup', null];
        yield 'groupValid' => [[ActionsArrayItemTransformerInterface::KEY_GROUP => 'test-group'], 'getGroup', 'test-group'];
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[ActionsArrayItemTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[ActionsArrayItemTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'componentAbsent' => [[], 'getComponent', null];
        yield 'componentWrongType' => [[ActionsArrayItemTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'componentValid' => [[ActionsArrayItemTransformerInterface::KEY_COMPONENT => 'test-component'], 'getComponent', 'test-component'];
    }

    public function testTransformPlayPause(): void
    {
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $toggleSwitchForDashboardModel = self::createStub(ToggleSwitchForDashboardInterface::class);
        $toggleSwitchForDashboardTransformer = self::createStub(ToggleSwitchForDashboardTransformerInterface::class);
        $toggleSwitchForDashboardTransformer->method('transform')->willReturn($toggleSwitchForDashboardModel);
        $switchForDashboardModel = self::createStub(SwitchForDashboardInterface::class);
        $switchForDashboardTransformer = self::createStub(SwitchForDashboardTransformerInterface::class);
        $switchForDashboardTransformer->method('transform')->willReturn($switchForDashboardModel);
        $standbyPowerSwitchForDashboardModel = self::createStub(StandbyPowerSwitchForDashboardInterface::class);
        $standbyPowerSwitchForDashboardTransformer = self::createStub(StandbyPowerSwitchForDashboardTransformerInterface::class);
        $standbyPowerSwitchForDashboardTransformer->method('transform')->willReturn($standbyPowerSwitchForDashboardModel);
        $statelessPowerToggleForDashboardModel = self::createStub(StatelessPowerToggleForDashboardInterface::class);
        $statelessPowerToggleForDashboardTransformer = self::createStub(StatelessPowerToggleForDashboardTransformerInterface::class);
        $statelessPowerToggleForDashboardTransformer->method('transform')->willReturn($statelessPowerToggleForDashboardModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new ActionsArrayItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer, $visibleConditionTransformer);
        $base = [ActionsArrayItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', ActionsArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getPlayPause());
        self::assertNull($transformer->transform($base + [ActionsArrayItemTransformerInterface::KEY_PLAY_PAUSE => 'test-not-array'])->getPlayPause());
        self::assertSame($playPauseModel, $transformer->transform($base + [ActionsArrayItemTransformerInterface::KEY_PLAY_PAUSE => ['test-nested']])->getPlayPause());
    }

    public function testTransformPlayStop(): void
    {
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $toggleSwitchForDashboardModel = self::createStub(ToggleSwitchForDashboardInterface::class);
        $toggleSwitchForDashboardTransformer = self::createStub(ToggleSwitchForDashboardTransformerInterface::class);
        $toggleSwitchForDashboardTransformer->method('transform')->willReturn($toggleSwitchForDashboardModel);
        $switchForDashboardModel = self::createStub(SwitchForDashboardInterface::class);
        $switchForDashboardTransformer = self::createStub(SwitchForDashboardTransformerInterface::class);
        $switchForDashboardTransformer->method('transform')->willReturn($switchForDashboardModel);
        $standbyPowerSwitchForDashboardModel = self::createStub(StandbyPowerSwitchForDashboardInterface::class);
        $standbyPowerSwitchForDashboardTransformer = self::createStub(StandbyPowerSwitchForDashboardTransformerInterface::class);
        $standbyPowerSwitchForDashboardTransformer->method('transform')->willReturn($standbyPowerSwitchForDashboardModel);
        $statelessPowerToggleForDashboardModel = self::createStub(StatelessPowerToggleForDashboardInterface::class);
        $statelessPowerToggleForDashboardTransformer = self::createStub(StatelessPowerToggleForDashboardTransformerInterface::class);
        $statelessPowerToggleForDashboardTransformer->method('transform')->willReturn($statelessPowerToggleForDashboardModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new ActionsArrayItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer, $visibleConditionTransformer);
        $base = [ActionsArrayItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', ActionsArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getPlayStop());
        self::assertNull($transformer->transform($base + [ActionsArrayItemTransformerInterface::KEY_PLAY_STOP => 'test-not-array'])->getPlayStop());
        self::assertSame($playStopModel, $transformer->transform($base + [ActionsArrayItemTransformerInterface::KEY_PLAY_STOP => ['test-nested']])->getPlayStop());
    }

    public function testTransformPushButton(): void
    {
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $toggleSwitchForDashboardModel = self::createStub(ToggleSwitchForDashboardInterface::class);
        $toggleSwitchForDashboardTransformer = self::createStub(ToggleSwitchForDashboardTransformerInterface::class);
        $toggleSwitchForDashboardTransformer->method('transform')->willReturn($toggleSwitchForDashboardModel);
        $switchForDashboardModel = self::createStub(SwitchForDashboardInterface::class);
        $switchForDashboardTransformer = self::createStub(SwitchForDashboardTransformerInterface::class);
        $switchForDashboardTransformer->method('transform')->willReturn($switchForDashboardModel);
        $standbyPowerSwitchForDashboardModel = self::createStub(StandbyPowerSwitchForDashboardInterface::class);
        $standbyPowerSwitchForDashboardTransformer = self::createStub(StandbyPowerSwitchForDashboardTransformerInterface::class);
        $standbyPowerSwitchForDashboardTransformer->method('transform')->willReturn($standbyPowerSwitchForDashboardModel);
        $statelessPowerToggleForDashboardModel = self::createStub(StatelessPowerToggleForDashboardInterface::class);
        $statelessPowerToggleForDashboardTransformer = self::createStub(StatelessPowerToggleForDashboardTransformerInterface::class);
        $statelessPowerToggleForDashboardTransformer->method('transform')->willReturn($statelessPowerToggleForDashboardModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new ActionsArrayItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer, $visibleConditionTransformer);
        $base = [ActionsArrayItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', ActionsArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getPushButton());
        self::assertNull($transformer->transform($base + [ActionsArrayItemTransformerInterface::KEY_PUSH_BUTTON => 'test-not-array'])->getPushButton());
        self::assertSame($pushButtonModel, $transformer->transform($base + [ActionsArrayItemTransformerInterface::KEY_PUSH_BUTTON => ['test-nested']])->getPushButton());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $toggleSwitchForDashboardModel = self::createStub(ToggleSwitchForDashboardInterface::class);
        $toggleSwitchForDashboardTransformer = self::createStub(ToggleSwitchForDashboardTransformerInterface::class);
        $toggleSwitchForDashboardTransformer->method('transform')->willReturn($toggleSwitchForDashboardModel);
        $switchForDashboardModel = self::createStub(SwitchForDashboardInterface::class);
        $switchForDashboardTransformer = self::createStub(SwitchForDashboardTransformerInterface::class);
        $switchForDashboardTransformer->method('transform')->willReturn($switchForDashboardModel);
        $standbyPowerSwitchForDashboardModel = self::createStub(StandbyPowerSwitchForDashboardInterface::class);
        $standbyPowerSwitchForDashboardTransformer = self::createStub(StandbyPowerSwitchForDashboardTransformerInterface::class);
        $standbyPowerSwitchForDashboardTransformer->method('transform')->willReturn($standbyPowerSwitchForDashboardModel);
        $statelessPowerToggleForDashboardModel = self::createStub(StatelessPowerToggleForDashboardInterface::class);
        $statelessPowerToggleForDashboardTransformer = self::createStub(StatelessPowerToggleForDashboardTransformerInterface::class);
        $statelessPowerToggleForDashboardTransformer->method('transform')->willReturn($statelessPowerToggleForDashboardModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new ActionsArrayItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform([ActionsArrayItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', ActionsArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability']);

        self::assertNull($actual->getPushButton());
        self::assertNull($actual->getToggleSwitch());
        self::assertNull($actual->getSwitch());
        self::assertNull($actual->getStandbyPowerSwitch());
        self::assertNull($actual->getStatelessPowerToggle());
        self::assertNull($actual->getPlayPause());
        self::assertNull($actual->getPlayStop());
        self::assertNull($actual->getGroup());
        self::assertNull($actual->getVersion());
        self::assertNull($actual->getComponent());
        self::assertNull($actual->getVisibleCondition());
    }

    public function testTransformStandbyPowerSwitch(): void
    {
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $toggleSwitchForDashboardModel = self::createStub(ToggleSwitchForDashboardInterface::class);
        $toggleSwitchForDashboardTransformer = self::createStub(ToggleSwitchForDashboardTransformerInterface::class);
        $toggleSwitchForDashboardTransformer->method('transform')->willReturn($toggleSwitchForDashboardModel);
        $switchForDashboardModel = self::createStub(SwitchForDashboardInterface::class);
        $switchForDashboardTransformer = self::createStub(SwitchForDashboardTransformerInterface::class);
        $switchForDashboardTransformer->method('transform')->willReturn($switchForDashboardModel);
        $standbyPowerSwitchForDashboardModel = self::createStub(StandbyPowerSwitchForDashboardInterface::class);
        $standbyPowerSwitchForDashboardTransformer = self::createStub(StandbyPowerSwitchForDashboardTransformerInterface::class);
        $standbyPowerSwitchForDashboardTransformer->method('transform')->willReturn($standbyPowerSwitchForDashboardModel);
        $statelessPowerToggleForDashboardModel = self::createStub(StatelessPowerToggleForDashboardInterface::class);
        $statelessPowerToggleForDashboardTransformer = self::createStub(StatelessPowerToggleForDashboardTransformerInterface::class);
        $statelessPowerToggleForDashboardTransformer->method('transform')->willReturn($statelessPowerToggleForDashboardModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new ActionsArrayItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer, $visibleConditionTransformer);
        $base = [ActionsArrayItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', ActionsArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getStandbyPowerSwitch());
        self::assertNull($transformer->transform($base + [ActionsArrayItemTransformerInterface::KEY_STANDBY_POWER_SWITCH => 'test-not-array'])->getStandbyPowerSwitch());
        self::assertSame($standbyPowerSwitchForDashboardModel, $transformer->transform($base + [ActionsArrayItemTransformerInterface::KEY_STANDBY_POWER_SWITCH => ['test-nested']])->getStandbyPowerSwitch());
    }

    public function testTransformStatelessPowerToggle(): void
    {
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $toggleSwitchForDashboardModel = self::createStub(ToggleSwitchForDashboardInterface::class);
        $toggleSwitchForDashboardTransformer = self::createStub(ToggleSwitchForDashboardTransformerInterface::class);
        $toggleSwitchForDashboardTransformer->method('transform')->willReturn($toggleSwitchForDashboardModel);
        $switchForDashboardModel = self::createStub(SwitchForDashboardInterface::class);
        $switchForDashboardTransformer = self::createStub(SwitchForDashboardTransformerInterface::class);
        $switchForDashboardTransformer->method('transform')->willReturn($switchForDashboardModel);
        $standbyPowerSwitchForDashboardModel = self::createStub(StandbyPowerSwitchForDashboardInterface::class);
        $standbyPowerSwitchForDashboardTransformer = self::createStub(StandbyPowerSwitchForDashboardTransformerInterface::class);
        $standbyPowerSwitchForDashboardTransformer->method('transform')->willReturn($standbyPowerSwitchForDashboardModel);
        $statelessPowerToggleForDashboardModel = self::createStub(StatelessPowerToggleForDashboardInterface::class);
        $statelessPowerToggleForDashboardTransformer = self::createStub(StatelessPowerToggleForDashboardTransformerInterface::class);
        $statelessPowerToggleForDashboardTransformer->method('transform')->willReturn($statelessPowerToggleForDashboardModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new ActionsArrayItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer, $visibleConditionTransformer);
        $base = [ActionsArrayItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', ActionsArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getStatelessPowerToggle());
        self::assertNull($transformer->transform($base + [ActionsArrayItemTransformerInterface::KEY_STATELESS_POWER_TOGGLE => 'test-not-array'])->getStatelessPowerToggle());
        self::assertSame($statelessPowerToggleForDashboardModel, $transformer->transform($base + [ActionsArrayItemTransformerInterface::KEY_STATELESS_POWER_TOGGLE => ['test-nested']])->getStatelessPowerToggle());
    }

    public function testTransformSwitch(): void
    {
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $toggleSwitchForDashboardModel = self::createStub(ToggleSwitchForDashboardInterface::class);
        $toggleSwitchForDashboardTransformer = self::createStub(ToggleSwitchForDashboardTransformerInterface::class);
        $toggleSwitchForDashboardTransformer->method('transform')->willReturn($toggleSwitchForDashboardModel);
        $switchForDashboardModel = self::createStub(SwitchForDashboardInterface::class);
        $switchForDashboardTransformer = self::createStub(SwitchForDashboardTransformerInterface::class);
        $switchForDashboardTransformer->method('transform')->willReturn($switchForDashboardModel);
        $standbyPowerSwitchForDashboardModel = self::createStub(StandbyPowerSwitchForDashboardInterface::class);
        $standbyPowerSwitchForDashboardTransformer = self::createStub(StandbyPowerSwitchForDashboardTransformerInterface::class);
        $standbyPowerSwitchForDashboardTransformer->method('transform')->willReturn($standbyPowerSwitchForDashboardModel);
        $statelessPowerToggleForDashboardModel = self::createStub(StatelessPowerToggleForDashboardInterface::class);
        $statelessPowerToggleForDashboardTransformer = self::createStub(StatelessPowerToggleForDashboardTransformerInterface::class);
        $statelessPowerToggleForDashboardTransformer->method('transform')->willReturn($statelessPowerToggleForDashboardModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new ActionsArrayItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer, $visibleConditionTransformer);
        $base = [ActionsArrayItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', ActionsArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getSwitch());
        self::assertNull($transformer->transform($base + [ActionsArrayItemTransformerInterface::KEY_SWITCH => 'test-not-array'])->getSwitch());
        self::assertSame($switchForDashboardModel, $transformer->transform($base + [ActionsArrayItemTransformerInterface::KEY_SWITCH => ['test-nested']])->getSwitch());
    }

    public function testTransformToggleSwitch(): void
    {
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $toggleSwitchForDashboardModel = self::createStub(ToggleSwitchForDashboardInterface::class);
        $toggleSwitchForDashboardTransformer = self::createStub(ToggleSwitchForDashboardTransformerInterface::class);
        $toggleSwitchForDashboardTransformer->method('transform')->willReturn($toggleSwitchForDashboardModel);
        $switchForDashboardModel = self::createStub(SwitchForDashboardInterface::class);
        $switchForDashboardTransformer = self::createStub(SwitchForDashboardTransformerInterface::class);
        $switchForDashboardTransformer->method('transform')->willReturn($switchForDashboardModel);
        $standbyPowerSwitchForDashboardModel = self::createStub(StandbyPowerSwitchForDashboardInterface::class);
        $standbyPowerSwitchForDashboardTransformer = self::createStub(StandbyPowerSwitchForDashboardTransformerInterface::class);
        $standbyPowerSwitchForDashboardTransformer->method('transform')->willReturn($standbyPowerSwitchForDashboardModel);
        $statelessPowerToggleForDashboardModel = self::createStub(StatelessPowerToggleForDashboardInterface::class);
        $statelessPowerToggleForDashboardTransformer = self::createStub(StatelessPowerToggleForDashboardTransformerInterface::class);
        $statelessPowerToggleForDashboardTransformer->method('transform')->willReturn($statelessPowerToggleForDashboardModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new ActionsArrayItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer, $visibleConditionTransformer);
        $base = [ActionsArrayItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', ActionsArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getToggleSwitch());
        self::assertNull($transformer->transform($base + [ActionsArrayItemTransformerInterface::KEY_TOGGLE_SWITCH => 'test-not-array'])->getToggleSwitch());
        self::assertSame($toggleSwitchForDashboardModel, $transformer->transform($base + [ActionsArrayItemTransformerInterface::KEY_TOGGLE_SWITCH => ['test-nested']])->getToggleSwitch());
    }

    public function testTransformVisibleCondition(): void
    {
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $toggleSwitchForDashboardModel = self::createStub(ToggleSwitchForDashboardInterface::class);
        $toggleSwitchForDashboardTransformer = self::createStub(ToggleSwitchForDashboardTransformerInterface::class);
        $toggleSwitchForDashboardTransformer->method('transform')->willReturn($toggleSwitchForDashboardModel);
        $switchForDashboardModel = self::createStub(SwitchForDashboardInterface::class);
        $switchForDashboardTransformer = self::createStub(SwitchForDashboardTransformerInterface::class);
        $switchForDashboardTransformer->method('transform')->willReturn($switchForDashboardModel);
        $standbyPowerSwitchForDashboardModel = self::createStub(StandbyPowerSwitchForDashboardInterface::class);
        $standbyPowerSwitchForDashboardTransformer = self::createStub(StandbyPowerSwitchForDashboardTransformerInterface::class);
        $standbyPowerSwitchForDashboardTransformer->method('transform')->willReturn($standbyPowerSwitchForDashboardModel);
        $statelessPowerToggleForDashboardModel = self::createStub(StatelessPowerToggleForDashboardInterface::class);
        $statelessPowerToggleForDashboardTransformer = self::createStub(StatelessPowerToggleForDashboardTransformerInterface::class);
        $statelessPowerToggleForDashboardTransformer->method('transform')->willReturn($statelessPowerToggleForDashboardModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new ActionsArrayItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer, $visibleConditionTransformer);
        $base = [ActionsArrayItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', ActionsArrayItemTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getVisibleCondition());
        self::assertNull($transformer->transform($base + [ActionsArrayItemTransformerInterface::KEY_VISIBLE_CONDITION => 'test-not-array'])->getVisibleCondition());
        self::assertSame($visibleConditionModel, $transformer->transform($base + [ActionsArrayItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested']])->getVisibleCondition());
    }
}
