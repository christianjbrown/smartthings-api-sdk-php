<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\PresentationSettingsTemperatureConversionsItem;
use ChristianBrown\SmartThings\Transformer\PresentationSettingsTemperatureConversionsItemTransformer;
use ChristianBrown\SmartThings\Transformer\PresentationSettingsTemperatureConversionsItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PresentationSettingsTemperatureConversionsItem::class)]
#[CoversClass(PresentationSettingsTemperatureConversionsItemTransformer::class)]
final class PresentationSettingsTemperatureConversionsItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PresentationSettingsTemperatureConversionsItemTransformerInterface::KEY_VALUE => 'test-value',
            PresentationSettingsTemperatureConversionsItemTransformerInterface::KEY_UNIT => 'test-unit',
        ];

        $transformer = new PresentationSettingsTemperatureConversionsItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-unit', $actual->getUnit());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new PresentationSettingsTemperatureConversionsItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[PresentationSettingsTemperatureConversionsItemTransformerInterface::KEY_VALUE => 42], 'getValue', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new PresentationSettingsTemperatureConversionsItemTransformer();

        $actual = $transformer->transform([PresentationSettingsTemperatureConversionsItemTransformerInterface::KEY_VALUE => 'test-value'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[PresentationSettingsTemperatureConversionsItemTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[PresentationSettingsTemperatureConversionsItemTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new PresentationSettingsTemperatureConversionsItemTransformer();

        $actual = $transformer->transform([PresentationSettingsTemperatureConversionsItemTransformerInterface::KEY_VALUE => 'test-value']);

        self::assertNull($actual->getUnit());
    }
}
