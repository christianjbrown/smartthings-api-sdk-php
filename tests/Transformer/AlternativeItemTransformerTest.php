<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItem;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformer;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AlternativeItem::class)]
#[CoversClass(AlternativeItemTransformer::class)]
final class AlternativeItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AlternativeItemTransformerInterface::KEY_KEY => 'test-key',
            AlternativeItemTransformerInterface::KEY_VALUE => 'test-value',
            AlternativeItemTransformerInterface::KEY_TYPE => 'test-type',
            AlternativeItemTransformerInterface::KEY_ICON_URL => 'test-icon-url',
            AlternativeItemTransformerInterface::KEY_DESCRIPTION => 'test-description',
        ];

        $transformer = new AlternativeItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-key', $actual->getKey());
        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-type', $actual->getType());
        self::assertSame('test-icon-url', $actual->getIconUrl());
        self::assertSame('test-description', $actual->getDescription());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new AlternativeItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'keyAbsent' => [[AlternativeItemTransformerInterface::KEY_VALUE => 'test-value'], 'getKey', null];
        yield 'keyWrongType' => [[AlternativeItemTransformerInterface::KEY_VALUE => 'test-value', AlternativeItemTransformerInterface::KEY_KEY => 42], 'getKey', null];
        yield 'valueAbsent' => [[AlternativeItemTransformerInterface::KEY_KEY => 'test-key'], 'getValue', null];
        yield 'valueWrongType' => [[AlternativeItemTransformerInterface::KEY_KEY => 'test-key', AlternativeItemTransformerInterface::KEY_VALUE => 42], 'getValue', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new AlternativeItemTransformer();

        $actual = $transformer->transform([AlternativeItemTransformerInterface::KEY_KEY => 'test-key', AlternativeItemTransformerInterface::KEY_VALUE => 'test-value'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'typeAbsent' => [[], 'getType', null];
        yield 'typeWrongType' => [[AlternativeItemTransformerInterface::KEY_TYPE => 42], 'getType', null];
        yield 'typeValid' => [[AlternativeItemTransformerInterface::KEY_TYPE => 'test-type'], 'getType', 'test-type'];
        yield 'iconUrlAbsent' => [[], 'getIconUrl', null];
        yield 'iconUrlWrongType' => [[AlternativeItemTransformerInterface::KEY_ICON_URL => 42], 'getIconUrl', null];
        yield 'iconUrlValid' => [[AlternativeItemTransformerInterface::KEY_ICON_URL => 'test-icon-url'], 'getIconUrl', 'test-icon-url'];
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[AlternativeItemTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[AlternativeItemTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new AlternativeItemTransformer();

        $actual = $transformer->transform([AlternativeItemTransformerInterface::KEY_KEY => 'test-key', AlternativeItemTransformerInterface::KEY_VALUE => 'test-value']);

        self::assertNull($actual->getType());
        self::assertNull($actual->getIconUrl());
        self::assertNull($actual->getDescription());
    }
}
