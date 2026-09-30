<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusTv;
use ChristianBrown\SmartThings\Model\BasicPlusTvChannelInterface;
use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadInterface;
use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeInterface;
use ChristianBrown\SmartThings\Model\ButtonForTvInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvChannelTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvDirectionalPadTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvVolumeTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ButtonForTvTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusTv::class)]
#[CoversClass(BasicPlusTvTransformer::class)]
final class BasicPlusTvTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $basicPlusTvVolumeModel = self::createStub(BasicPlusTvVolumeInterface::class);
        $basicPlusTvVolumeTransformer = self::createStub(BasicPlusTvVolumeTransformerInterface::class);
        $basicPlusTvVolumeTransformer->method('transform')->willReturn($basicPlusTvVolumeModel);
        $buttonForTvModel = self::createStub(ButtonForTvInterface::class);
        $buttonForTvTransformer = self::createStub(ButtonForTvTransformerInterface::class);
        $buttonForTvTransformer->method('transform')->willReturn($buttonForTvModel);
        $basicPlusTvChannelModel = self::createStub(BasicPlusTvChannelInterface::class);
        $basicPlusTvChannelTransformer = self::createStub(BasicPlusTvChannelTransformerInterface::class);
        $basicPlusTvChannelTransformer->method('transform')->willReturn($basicPlusTvChannelModel);
        $basicPlusTvDirectionalPadModel = self::createStub(BasicPlusTvDirectionalPadInterface::class);
        $basicPlusTvDirectionalPadTransformer = self::createStub(BasicPlusTvDirectionalPadTransformerInterface::class);
        $basicPlusTvDirectionalPadTransformer->method('transform')->willReturn($basicPlusTvDirectionalPadModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $data = [
            BasicPlusTvTransformerInterface::KEY_VOLUME => ['test-nested'],
            BasicPlusTvTransformerInterface::KEY_BUTTONS => [['test-nested']],
            BasicPlusTvTransformerInterface::KEY_CHANNEL => ['test-nested'],
            BasicPlusTvTransformerInterface::KEY_DIRECTIONAL_PAD => ['test-nested'],
            BasicPlusTvTransformerInterface::KEY_OPERATOR => 'test-operator',
            BasicPlusTvTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested']],
            BasicPlusTvTransformerInterface::KEY_HIDE_DASHBOARD_ACTIONS => true,
        ];

        $transformer = new BasicPlusTvTransformer($basicPlusTvVolumeTransformer, $buttonForTvTransformer, $basicPlusTvChannelTransformer, $basicPlusTvDirectionalPadTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($basicPlusTvVolumeModel, $actual->getVolume());
        self::assertSame([$buttonForTvModel], $actual->getButtons());
        self::assertSame($basicPlusTvChannelModel, $actual->getChannel());
        self::assertSame($basicPlusTvDirectionalPadModel, $actual->getDirectionalPad());
        self::assertSame('test-operator', $actual->getOperator());
        self::assertSame([$visibleConditionModel], $actual->getVisibleConditions());
        self::assertTrue($actual->getHideDashboardActions());
    }

    public function testTransformChannel(): void
    {
        $basicPlusTvVolumeModel = self::createStub(BasicPlusTvVolumeInterface::class);
        $basicPlusTvVolumeTransformer = self::createStub(BasicPlusTvVolumeTransformerInterface::class);
        $basicPlusTvVolumeTransformer->method('transform')->willReturn($basicPlusTvVolumeModel);
        $buttonForTvModel = self::createStub(ButtonForTvInterface::class);
        $buttonForTvTransformer = self::createStub(ButtonForTvTransformerInterface::class);
        $buttonForTvTransformer->method('transform')->willReturn($buttonForTvModel);
        $basicPlusTvChannelModel = self::createStub(BasicPlusTvChannelInterface::class);
        $basicPlusTvChannelTransformer = self::createStub(BasicPlusTvChannelTransformerInterface::class);
        $basicPlusTvChannelTransformer->method('transform')->willReturn($basicPlusTvChannelModel);
        $basicPlusTvDirectionalPadModel = self::createStub(BasicPlusTvDirectionalPadInterface::class);
        $basicPlusTvDirectionalPadTransformer = self::createStub(BasicPlusTvDirectionalPadTransformerInterface::class);
        $basicPlusTvDirectionalPadTransformer->method('transform')->willReturn($basicPlusTvDirectionalPadModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusTvTransformer($basicPlusTvVolumeTransformer, $buttonForTvTransformer, $basicPlusTvChannelTransformer, $basicPlusTvDirectionalPadTransformer, $visibleConditionTransformer);
        $base = [BasicPlusTvTransformerInterface::KEY_BUTTONS => ['test-nested']];

        self::assertNull($transformer->transform($base)->getChannel());
        self::assertNull($transformer->transform($base + [BasicPlusTvTransformerInterface::KEY_CHANNEL => 'test-not-array'])->getChannel());
        self::assertSame($basicPlusTvChannelModel, $transformer->transform($base + [BasicPlusTvTransformerInterface::KEY_CHANNEL => ['test-nested']])->getChannel());
    }

    public function testTransformDirectionalPad(): void
    {
        $basicPlusTvVolumeModel = self::createStub(BasicPlusTvVolumeInterface::class);
        $basicPlusTvVolumeTransformer = self::createStub(BasicPlusTvVolumeTransformerInterface::class);
        $basicPlusTvVolumeTransformer->method('transform')->willReturn($basicPlusTvVolumeModel);
        $buttonForTvModel = self::createStub(ButtonForTvInterface::class);
        $buttonForTvTransformer = self::createStub(ButtonForTvTransformerInterface::class);
        $buttonForTvTransformer->method('transform')->willReturn($buttonForTvModel);
        $basicPlusTvChannelModel = self::createStub(BasicPlusTvChannelInterface::class);
        $basicPlusTvChannelTransformer = self::createStub(BasicPlusTvChannelTransformerInterface::class);
        $basicPlusTvChannelTransformer->method('transform')->willReturn($basicPlusTvChannelModel);
        $basicPlusTvDirectionalPadModel = self::createStub(BasicPlusTvDirectionalPadInterface::class);
        $basicPlusTvDirectionalPadTransformer = self::createStub(BasicPlusTvDirectionalPadTransformerInterface::class);
        $basicPlusTvDirectionalPadTransformer->method('transform')->willReturn($basicPlusTvDirectionalPadModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusTvTransformer($basicPlusTvVolumeTransformer, $buttonForTvTransformer, $basicPlusTvChannelTransformer, $basicPlusTvDirectionalPadTransformer, $visibleConditionTransformer);
        $base = [BasicPlusTvTransformerInterface::KEY_BUTTONS => ['test-nested']];

        self::assertNull($transformer->transform($base)->getDirectionalPad());
        self::assertNull($transformer->transform($base + [BasicPlusTvTransformerInterface::KEY_DIRECTIONAL_PAD => 'test-not-array'])->getDirectionalPad());
        self::assertSame($basicPlusTvDirectionalPadModel, $transformer->transform($base + [BasicPlusTvTransformerInterface::KEY_DIRECTIONAL_PAD => ['test-nested']])->getDirectionalPad());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusTvTransformer(self::createStub(BasicPlusTvVolumeTransformerInterface::class), self::createStub(ButtonForTvTransformerInterface::class), self::createStub(BasicPlusTvChannelTransformerInterface::class), self::createStub(BasicPlusTvDirectionalPadTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'buttonsAbsent' => [[], 'getButtons', []];
        yield 'buttonsWrongType' => [[BasicPlusTvTransformerInterface::KEY_BUTTONS => 'not-array'], 'getButtons', []];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusTvTransformer(self::createStub(BasicPlusTvVolumeTransformerInterface::class), self::createStub(ButtonForTvTransformerInterface::class), self::createStub(BasicPlusTvChannelTransformerInterface::class), self::createStub(BasicPlusTvDirectionalPadTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform([BasicPlusTvTransformerInterface::KEY_BUTTONS => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'operatorAbsent' => [[], 'getOperator', null];
        yield 'operatorWrongType' => [[BasicPlusTvTransformerInterface::KEY_OPERATOR => 42], 'getOperator', null];
        yield 'operatorValid' => [[BasicPlusTvTransformerInterface::KEY_OPERATOR => 'test-operator'], 'getOperator', 'test-operator'];
        yield 'hideDashboardActionsAbsent' => [[], 'getHideDashboardActions', null];
        yield 'hideDashboardActionsWrongType' => [[BasicPlusTvTransformerInterface::KEY_HIDE_DASHBOARD_ACTIONS => 'not-bool'], 'getHideDashboardActions', null];
        yield 'hideDashboardActionsValid' => [[BasicPlusTvTransformerInterface::KEY_HIDE_DASHBOARD_ACTIONS => true], 'getHideDashboardActions', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $basicPlusTvVolumeModel = self::createStub(BasicPlusTvVolumeInterface::class);
        $basicPlusTvVolumeTransformer = self::createStub(BasicPlusTvVolumeTransformerInterface::class);
        $basicPlusTvVolumeTransformer->method('transform')->willReturn($basicPlusTvVolumeModel);
        $buttonForTvModel = self::createStub(ButtonForTvInterface::class);
        $buttonForTvTransformer = self::createStub(ButtonForTvTransformerInterface::class);
        $buttonForTvTransformer->method('transform')->willReturn($buttonForTvModel);
        $basicPlusTvChannelModel = self::createStub(BasicPlusTvChannelInterface::class);
        $basicPlusTvChannelTransformer = self::createStub(BasicPlusTvChannelTransformerInterface::class);
        $basicPlusTvChannelTransformer->method('transform')->willReturn($basicPlusTvChannelModel);
        $basicPlusTvDirectionalPadModel = self::createStub(BasicPlusTvDirectionalPadInterface::class);
        $basicPlusTvDirectionalPadTransformer = self::createStub(BasicPlusTvDirectionalPadTransformerInterface::class);
        $basicPlusTvDirectionalPadTransformer->method('transform')->willReturn($basicPlusTvDirectionalPadModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusTvTransformer($basicPlusTvVolumeTransformer, $buttonForTvTransformer, $basicPlusTvChannelTransformer, $basicPlusTvDirectionalPadTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform([BasicPlusTvTransformerInterface::KEY_BUTTONS => ['test-nested']]);

        self::assertNull($actual->getVolume());
        self::assertNull($actual->getChannel());
        self::assertNull($actual->getDirectionalPad());
        self::assertNull($actual->getOperator());
        self::assertNull($actual->getVisibleConditions());
        self::assertNull($actual->getHideDashboardActions());
    }

    public function testTransformVisibleConditions(): void
    {
        $basicPlusTvVolumeModel = self::createStub(BasicPlusTvVolumeInterface::class);
        $basicPlusTvVolumeTransformer = self::createStub(BasicPlusTvVolumeTransformerInterface::class);
        $basicPlusTvVolumeTransformer->method('transform')->willReturn($basicPlusTvVolumeModel);
        $buttonForTvModel = self::createStub(ButtonForTvInterface::class);
        $buttonForTvTransformer = self::createStub(ButtonForTvTransformerInterface::class);
        $buttonForTvTransformer->method('transform')->willReturn($buttonForTvModel);
        $basicPlusTvChannelModel = self::createStub(BasicPlusTvChannelInterface::class);
        $basicPlusTvChannelTransformer = self::createStub(BasicPlusTvChannelTransformerInterface::class);
        $basicPlusTvChannelTransformer->method('transform')->willReturn($basicPlusTvChannelModel);
        $basicPlusTvDirectionalPadModel = self::createStub(BasicPlusTvDirectionalPadInterface::class);
        $basicPlusTvDirectionalPadTransformer = self::createStub(BasicPlusTvDirectionalPadTransformerInterface::class);
        $basicPlusTvDirectionalPadTransformer->method('transform')->willReturn($basicPlusTvDirectionalPadModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusTvTransformer($basicPlusTvVolumeTransformer, $buttonForTvTransformer, $basicPlusTvChannelTransformer, $basicPlusTvDirectionalPadTransformer, $visibleConditionTransformer);
        $base = [BasicPlusTvTransformerInterface::KEY_BUTTONS => ['test-nested']];

        self::assertNull($transformer->transform($base)->getVisibleConditions());
        self::assertNull($transformer->transform($base + [BasicPlusTvTransformerInterface::KEY_VISIBLE_CONDITIONS => 'test-not-array'])->getVisibleConditions());
        self::assertSame([$visibleConditionModel], $transformer->transform($base + [BasicPlusTvTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested'], 'test-skipped']])->getVisibleConditions());
    }

    public function testTransformVolume(): void
    {
        $basicPlusTvVolumeModel = self::createStub(BasicPlusTvVolumeInterface::class);
        $basicPlusTvVolumeTransformer = self::createStub(BasicPlusTvVolumeTransformerInterface::class);
        $basicPlusTvVolumeTransformer->method('transform')->willReturn($basicPlusTvVolumeModel);
        $buttonForTvModel = self::createStub(ButtonForTvInterface::class);
        $buttonForTvTransformer = self::createStub(ButtonForTvTransformerInterface::class);
        $buttonForTvTransformer->method('transform')->willReturn($buttonForTvModel);
        $basicPlusTvChannelModel = self::createStub(BasicPlusTvChannelInterface::class);
        $basicPlusTvChannelTransformer = self::createStub(BasicPlusTvChannelTransformerInterface::class);
        $basicPlusTvChannelTransformer->method('transform')->willReturn($basicPlusTvChannelModel);
        $basicPlusTvDirectionalPadModel = self::createStub(BasicPlusTvDirectionalPadInterface::class);
        $basicPlusTvDirectionalPadTransformer = self::createStub(BasicPlusTvDirectionalPadTransformerInterface::class);
        $basicPlusTvDirectionalPadTransformer->method('transform')->willReturn($basicPlusTvDirectionalPadModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusTvTransformer($basicPlusTvVolumeTransformer, $buttonForTvTransformer, $basicPlusTvChannelTransformer, $basicPlusTvDirectionalPadTransformer, $visibleConditionTransformer);
        $base = [BasicPlusTvTransformerInterface::KEY_BUTTONS => ['test-nested']];

        self::assertNull($transformer->transform($base)->getVolume());
        self::assertNull($transformer->transform($base + [BasicPlusTvTransformerInterface::KEY_VOLUME => 'test-not-array'])->getVolume());
        self::assertSame($basicPlusTvVolumeModel, $transformer->transform($base + [BasicPlusTvTransformerInterface::KEY_VOLUME => ['test-nested']])->getVolume());
    }
}
