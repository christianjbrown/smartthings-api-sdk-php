<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusLightColorControlColor;
use ChristianBrown\SmartThings\Transformer\BasicPlusLightColorControlColorTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusLightColorControlColorTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusLightColorControlColor::class)]
#[CoversClass(BasicPlusLightColorControlColorTransformer::class)]
final class BasicPlusLightColorControlColorTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            BasicPlusLightColorControlColorTransformerInterface::KEY_HUE => 'test-hue',
            BasicPlusLightColorControlColorTransformerInterface::KEY_SATURATION => 'test-saturation',
        ];

        $transformer = new BasicPlusLightColorControlColorTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-hue', $actual->getHue());
        self::assertSame('test-saturation', $actual->getSaturation());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusLightColorControlColorTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'hueAbsent' => [[], 'getHue', null];
        yield 'hueWrongType' => [[BasicPlusLightColorControlColorTransformerInterface::KEY_HUE => 42], 'getHue', null];
        yield 'hueValid' => [[BasicPlusLightColorControlColorTransformerInterface::KEY_HUE => 'test-hue'], 'getHue', 'test-hue'];
        yield 'saturationAbsent' => [[], 'getSaturation', null];
        yield 'saturationWrongType' => [[BasicPlusLightColorControlColorTransformerInterface::KEY_SATURATION => 42], 'getSaturation', null];
        yield 'saturationValid' => [[BasicPlusLightColorControlColorTransformerInterface::KEY_SATURATION => 'test-saturation'], 'getSaturation', 'test-saturation'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new BasicPlusLightColorControlColorTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getHue());
        self::assertNull($actual->getSaturation());
    }
}
