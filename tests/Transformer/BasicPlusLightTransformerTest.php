<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusLight;
use ChristianBrown\SmartThings\Model\BasicPlusLightColorControlInterface;
use ChristianBrown\SmartThings\Model\SliderForLightInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusLightColorControlTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusLightTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusLightTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SliderForLightTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusLight::class)]
#[CoversClass(BasicPlusLightTransformer::class)]
final class BasicPlusLightTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $sliderForLightModel = self::createStub(SliderForLightInterface::class);
        $sliderForLightTransformer = self::createStub(SliderForLightTransformerInterface::class);
        $sliderForLightTransformer->method('transform')->willReturn($sliderForLightModel);
        $basicPlusLightColorControlModel = self::createStub(BasicPlusLightColorControlInterface::class);
        $basicPlusLightColorControlTransformer = self::createStub(BasicPlusLightColorControlTransformerInterface::class);
        $basicPlusLightColorControlTransformer->method('transform')->willReturn($basicPlusLightColorControlModel);
        $data = [
            BasicPlusLightTransformerInterface::KEY_DIMMER => ['test-nested'],
            BasicPlusLightTransformerInterface::KEY_COLOR_TEMPERATURE => ['test-nested'],
            BasicPlusLightTransformerInterface::KEY_COLOR_CONTROL => ['test-nested'],
            BasicPlusLightTransformerInterface::KEY_HIDE_DASHBOARD_ACTIONS => true,
        ];

        $transformer = new BasicPlusLightTransformer($sliderForLightTransformer, $basicPlusLightColorControlTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($sliderForLightModel, $actual->getDimmer());
        self::assertSame($sliderForLightModel, $actual->getColorTemperature());
        self::assertSame($basicPlusLightColorControlModel, $actual->getColorControl());
        self::assertTrue($actual->getHideDashboardActions());
    }

    public function testTransformColorControl(): void
    {
        $sliderForLightModel = self::createStub(SliderForLightInterface::class);
        $sliderForLightTransformer = self::createStub(SliderForLightTransformerInterface::class);
        $sliderForLightTransformer->method('transform')->willReturn($sliderForLightModel);
        $basicPlusLightColorControlModel = self::createStub(BasicPlusLightColorControlInterface::class);
        $basicPlusLightColorControlTransformer = self::createStub(BasicPlusLightColorControlTransformerInterface::class);
        $basicPlusLightColorControlTransformer->method('transform')->willReturn($basicPlusLightColorControlModel);
        $transformer = new BasicPlusLightTransformer($sliderForLightTransformer, $basicPlusLightColorControlTransformer);
        $base = [BasicPlusLightTransformerInterface::KEY_DIMMER => ['test-nested']];

        self::assertNull($transformer->transform($base)->getColorControl());
        self::assertNull($transformer->transform($base + [BasicPlusLightTransformerInterface::KEY_COLOR_CONTROL => 'test-not-array'])->getColorControl());
        self::assertSame($basicPlusLightColorControlModel, $transformer->transform($base + [BasicPlusLightTransformerInterface::KEY_COLOR_CONTROL => ['test-nested']])->getColorControl());
    }

    public function testTransformColorTemperature(): void
    {
        $sliderForLightModel = self::createStub(SliderForLightInterface::class);
        $sliderForLightTransformer = self::createStub(SliderForLightTransformerInterface::class);
        $sliderForLightTransformer->method('transform')->willReturn($sliderForLightModel);
        $basicPlusLightColorControlModel = self::createStub(BasicPlusLightColorControlInterface::class);
        $basicPlusLightColorControlTransformer = self::createStub(BasicPlusLightColorControlTransformerInterface::class);
        $basicPlusLightColorControlTransformer->method('transform')->willReturn($basicPlusLightColorControlModel);
        $transformer = new BasicPlusLightTransformer($sliderForLightTransformer, $basicPlusLightColorControlTransformer);
        $base = [BasicPlusLightTransformerInterface::KEY_DIMMER => ['test-nested']];

        self::assertNull($transformer->transform($base)->getColorTemperature());
        self::assertNull($transformer->transform($base + [BasicPlusLightTransformerInterface::KEY_COLOR_TEMPERATURE => 'test-not-array'])->getColorTemperature());
        self::assertSame($sliderForLightModel, $transformer->transform($base + [BasicPlusLightTransformerInterface::KEY_COLOR_TEMPERATURE => ['test-nested']])->getColorTemperature());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusLightTransformer(self::createStub(SliderForLightTransformerInterface::class), self::createStub(BasicPlusLightColorControlTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'dimmerAbsent' => [[], 'getDimmer', null];
        yield 'dimmerWrongType' => [[BasicPlusLightTransformerInterface::KEY_DIMMER => 'not-array'], 'getDimmer', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusLightTransformer(self::createStub(SliderForLightTransformerInterface::class), self::createStub(BasicPlusLightColorControlTransformerInterface::class));

        $actual = $transformer->transform([BasicPlusLightTransformerInterface::KEY_DIMMER => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'hideDashboardActionsAbsent' => [[], 'getHideDashboardActions', null];
        yield 'hideDashboardActionsWrongType' => [[BasicPlusLightTransformerInterface::KEY_HIDE_DASHBOARD_ACTIONS => 'not-bool'], 'getHideDashboardActions', null];
        yield 'hideDashboardActionsValid' => [[BasicPlusLightTransformerInterface::KEY_HIDE_DASHBOARD_ACTIONS => true], 'getHideDashboardActions', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $sliderForLightModel = self::createStub(SliderForLightInterface::class);
        $sliderForLightTransformer = self::createStub(SliderForLightTransformerInterface::class);
        $sliderForLightTransformer->method('transform')->willReturn($sliderForLightModel);
        $basicPlusLightColorControlModel = self::createStub(BasicPlusLightColorControlInterface::class);
        $basicPlusLightColorControlTransformer = self::createStub(BasicPlusLightColorControlTransformerInterface::class);
        $basicPlusLightColorControlTransformer->method('transform')->willReturn($basicPlusLightColorControlModel);
        $transformer = new BasicPlusLightTransformer($sliderForLightTransformer, $basicPlusLightColorControlTransformer);

        $actual = $transformer->transform([BasicPlusLightTransformerInterface::KEY_DIMMER => ['test-nested']]);

        self::assertNull($actual->getColorTemperature());
        self::assertNull($actual->getColorControl());
        self::assertNull($actual->getHideDashboardActions());
    }
}
