<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicList;
use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListValueMapInterface;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListTransformer;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListValueMapTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SupportedValuesForDynamicList::class)]
#[CoversClass(SupportedValuesForDynamicListTransformer::class)]
final class SupportedValuesForDynamicListTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $supportedValuesForDynamicListValueMapModel = self::createStub(SupportedValuesForDynamicListValueMapInterface::class);
        $supportedValuesForDynamicListValueMapTransformer = self::createStub(SupportedValuesForDynamicListValueMapTransformerInterface::class);
        $supportedValuesForDynamicListValueMapTransformer->method('transform')->willReturn($supportedValuesForDynamicListValueMapModel);
        $data = [
            SupportedValuesForDynamicListTransformerInterface::KEY_VALUE => 'test-value',
            SupportedValuesForDynamicListTransformerInterface::KEY_VALUE_MAP => ['test-nested'],
        ];

        $transformer = new SupportedValuesForDynamicListTransformer($supportedValuesForDynamicListValueMapTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
        self::assertSame($supportedValuesForDynamicListValueMapModel, $actual->getValueMap());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new SupportedValuesForDynamicListTransformer(self::createStub(SupportedValuesForDynamicListValueMapTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[SupportedValuesForDynamicListTransformerInterface::KEY_VALUE => 42], 'getValue', null];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $supportedValuesForDynamicListValueMapModel = self::createStub(SupportedValuesForDynamicListValueMapInterface::class);
        $supportedValuesForDynamicListValueMapTransformer = self::createStub(SupportedValuesForDynamicListValueMapTransformerInterface::class);
        $supportedValuesForDynamicListValueMapTransformer->method('transform')->willReturn($supportedValuesForDynamicListValueMapModel);
        $transformer = new SupportedValuesForDynamicListTransformer($supportedValuesForDynamicListValueMapTransformer);

        $actual = $transformer->transform([SupportedValuesForDynamicListTransformerInterface::KEY_VALUE => 'test-value']);

        self::assertNull($actual->getValueMap());
    }

    public function testTransformValueMap(): void
    {
        $supportedValuesForDynamicListValueMapModel = self::createStub(SupportedValuesForDynamicListValueMapInterface::class);
        $supportedValuesForDynamicListValueMapTransformer = self::createStub(SupportedValuesForDynamicListValueMapTransformerInterface::class);
        $supportedValuesForDynamicListValueMapTransformer->method('transform')->willReturn($supportedValuesForDynamicListValueMapModel);
        $transformer = new SupportedValuesForDynamicListTransformer($supportedValuesForDynamicListValueMapTransformer);
        $base = [SupportedValuesForDynamicListTransformerInterface::KEY_VALUE => 'test-value'];

        self::assertNull($transformer->transform($base)->getValueMap());
        self::assertNull($transformer->transform($base + [SupportedValuesForDynamicListTransformerInterface::KEY_VALUE_MAP => 'test-not-array'])->getValueMap());
        self::assertSame($supportedValuesForDynamicListValueMapModel, $transformer->transform($base + [SupportedValuesForDynamicListTransformerInterface::KEY_VALUE_MAP => ['test-nested']])->getValueMap());
    }
}
