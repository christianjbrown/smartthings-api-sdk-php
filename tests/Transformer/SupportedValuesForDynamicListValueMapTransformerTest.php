<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListValueMap;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListValueMapTransformer;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListValueMapTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SupportedValuesForDynamicListValueMap::class)]
#[CoversClass(SupportedValuesForDynamicListValueMapTransformer::class)]
final class SupportedValuesForDynamicListValueMapTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SupportedValuesForDynamicListValueMapTransformerInterface::KEY_KEY => 'test-key',
            SupportedValuesForDynamicListValueMapTransformerInterface::KEY_VALUE => 'test-value',
        ];

        $transformer = new SupportedValuesForDynamicListValueMapTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-key', $actual->getKey());
        self::assertSame('test-value', $actual->getValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new SupportedValuesForDynamicListValueMapTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'keyAbsent' => [[SupportedValuesForDynamicListValueMapTransformerInterface::KEY_VALUE => 'test-value'], 'getKey', null];
        yield 'keyWrongType' => [[SupportedValuesForDynamicListValueMapTransformerInterface::KEY_VALUE => 'test-value', SupportedValuesForDynamicListValueMapTransformerInterface::KEY_KEY => 42], 'getKey', null];
        yield 'valueAbsent' => [[SupportedValuesForDynamicListValueMapTransformerInterface::KEY_KEY => 'test-key'], 'getValue', null];
        yield 'valueWrongType' => [[SupportedValuesForDynamicListValueMapTransformerInterface::KEY_KEY => 'test-key', SupportedValuesForDynamicListValueMapTransformerInterface::KEY_VALUE => 42], 'getValue', null];
    }
}
