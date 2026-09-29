<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ActionItem;
use ChristianBrown\SmartThings\Model\PlayPauseInterface;
use ChristianBrown\SmartThings\Model\PlayStopInterface;
use ChristianBrown\SmartThings\Model\PushButtonInterface;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardInterface;
use ChristianBrown\SmartThings\Model\StatelessPowerToggleForDashboardInterface;
use ChristianBrown\SmartThings\Model\SwitchForDashboardInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardInterface;
use ChristianBrown\SmartThings\Transformer\ActionItemTransformer;
use ChristianBrown\SmartThings\Transformer\ActionItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PlayPauseTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PlayStopTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PushButtonTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StandbyPowerSwitchForDashboardTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StatelessPowerToggleForDashboardTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SwitchForDashboardTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ActionItem::class)]
#[CoversClass(ActionItemTransformer::class)]
final class ActionItemTransformerTest extends TestCase
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
        $data = [
            ActionItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            ActionItemTransformerInterface::KEY_PUSH_BUTTON => ['test-nested'],
            ActionItemTransformerInterface::KEY_TOGGLE_SWITCH => ['test-nested'],
            ActionItemTransformerInterface::KEY_SWITCH => ['test-nested'],
            ActionItemTransformerInterface::KEY_STANDBY_POWER_SWITCH => ['test-nested'],
            ActionItemTransformerInterface::KEY_STATELESS_POWER_TOGGLE => ['test-nested'],
            ActionItemTransformerInterface::KEY_PLAY_PAUSE => ['test-nested'],
            ActionItemTransformerInterface::KEY_PLAY_STOP => ['test-nested'],
            ActionItemTransformerInterface::KEY_GROUP => 'test-group',
        ];

        $transformer = new ActionItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer);

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
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ActionItemTransformer(self::createStub(PushButtonTransformerInterface::class), self::createStub(ToggleSwitchForDashboardTransformerInterface::class), self::createStub(SwitchForDashboardTransformerInterface::class), self::createStub(StandbyPowerSwitchForDashboardTransformerInterface::class), self::createStub(StatelessPowerToggleForDashboardTransformerInterface::class), self::createStub(PlayPauseTransformerInterface::class), self::createStub(PlayStopTransformerInterface::class));

        $actual = $transformer->transform([ActionItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'groupAbsent' => [[], 'getGroup', null];
        yield 'groupWrongType' => [[ActionItemTransformerInterface::KEY_GROUP => 42], 'getGroup', null];
        yield 'groupValid' => [[ActionItemTransformerInterface::KEY_GROUP => 'test-group'], 'getGroup', 'test-group'];
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
        $transformer = new ActionItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer);
        $base = [ActionItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getPlayPause());
        self::assertNull($transformer->transform($base + [ActionItemTransformerInterface::KEY_PLAY_PAUSE => 'test-not-array'])->getPlayPause());
        self::assertSame($playPauseModel, $transformer->transform($base + [ActionItemTransformerInterface::KEY_PLAY_PAUSE => ['test-nested']])->getPlayPause());
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
        $transformer = new ActionItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer);
        $base = [ActionItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getPlayStop());
        self::assertNull($transformer->transform($base + [ActionItemTransformerInterface::KEY_PLAY_STOP => 'test-not-array'])->getPlayStop());
        self::assertSame($playStopModel, $transformer->transform($base + [ActionItemTransformerInterface::KEY_PLAY_STOP => ['test-nested']])->getPlayStop());
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
        $transformer = new ActionItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer);
        $base = [ActionItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getPushButton());
        self::assertNull($transformer->transform($base + [ActionItemTransformerInterface::KEY_PUSH_BUTTON => 'test-not-array'])->getPushButton());
        self::assertSame($pushButtonModel, $transformer->transform($base + [ActionItemTransformerInterface::KEY_PUSH_BUTTON => ['test-nested']])->getPushButton());
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
        $transformer = new ActionItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer);

        $actual = $transformer->transform([ActionItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type']);

        self::assertNull($actual->getPushButton());
        self::assertNull($actual->getToggleSwitch());
        self::assertNull($actual->getSwitch());
        self::assertNull($actual->getStandbyPowerSwitch());
        self::assertNull($actual->getStatelessPowerToggle());
        self::assertNull($actual->getPlayPause());
        self::assertNull($actual->getPlayStop());
        self::assertNull($actual->getGroup());
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
        $transformer = new ActionItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer);
        $base = [ActionItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getStandbyPowerSwitch());
        self::assertNull($transformer->transform($base + [ActionItemTransformerInterface::KEY_STANDBY_POWER_SWITCH => 'test-not-array'])->getStandbyPowerSwitch());
        self::assertSame($standbyPowerSwitchForDashboardModel, $transformer->transform($base + [ActionItemTransformerInterface::KEY_STANDBY_POWER_SWITCH => ['test-nested']])->getStandbyPowerSwitch());
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
        $transformer = new ActionItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer);
        $base = [ActionItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getStatelessPowerToggle());
        self::assertNull($transformer->transform($base + [ActionItemTransformerInterface::KEY_STATELESS_POWER_TOGGLE => 'test-not-array'])->getStatelessPowerToggle());
        self::assertSame($statelessPowerToggleForDashboardModel, $transformer->transform($base + [ActionItemTransformerInterface::KEY_STATELESS_POWER_TOGGLE => ['test-nested']])->getStatelessPowerToggle());
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
        $transformer = new ActionItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer);
        $base = [ActionItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getSwitch());
        self::assertNull($transformer->transform($base + [ActionItemTransformerInterface::KEY_SWITCH => 'test-not-array'])->getSwitch());
        self::assertSame($switchForDashboardModel, $transformer->transform($base + [ActionItemTransformerInterface::KEY_SWITCH => ['test-nested']])->getSwitch());
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
        $transformer = new ActionItemTransformer($pushButtonTransformer, $toggleSwitchForDashboardTransformer, $switchForDashboardTransformer, $standbyPowerSwitchForDashboardTransformer, $statelessPowerToggleForDashboardTransformer, $playPauseTransformer, $playStopTransformer);
        $base = [ActionItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getToggleSwitch());
        self::assertNull($transformer->transform($base + [ActionItemTransformerInterface::KEY_TOGGLE_SWITCH => 'test-not-array'])->getToggleSwitch());
        self::assertSame($toggleSwitchForDashboardModel, $transformer->transform($base + [ActionItemTransformerInterface::KEY_TOGGLE_SWITCH => ['test-nested']])->getToggleSwitch());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ActionItemTransformer(self::createStub(PushButtonTransformerInterface::class), self::createStub(ToggleSwitchForDashboardTransformerInterface::class), self::createStub(SwitchForDashboardTransformerInterface::class), self::createStub(StandbyPowerSwitchForDashboardTransformerInterface::class), self::createStub(StatelessPowerToggleForDashboardTransformerInterface::class), self::createStub(PlayPauseTransformerInterface::class), self::createStub(PlayStopTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'displayTypeAbsent' => [[], sprintf(ActionItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionItemTransformerInterface::KEY_DISPLAY_TYPE)];
        yield 'displayTypeWrongType' => [[ActionItemTransformerInterface::KEY_DISPLAY_TYPE => 42], sprintf(ActionItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, ActionItemTransformerInterface::KEY_DISPLAY_TYPE)];
    }
}
