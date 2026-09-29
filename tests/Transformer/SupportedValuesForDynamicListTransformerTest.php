<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicList;
use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListValueMapInterface;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListTransformer;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListValueMapTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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

    public function testTransformRequiredFieldsOnly(): void
    {
        $supportedValuesForDynamicListValueMapModel = self::createStub(SupportedValuesForDynamicListValueMapInterface::class);
        $supportedValuesForDynamicListValueMapTransformer = self::createStub(SupportedValuesForDynamicListValueMapTransformerInterface::class);
        $supportedValuesForDynamicListValueMapTransformer->method('transform')->willReturn($supportedValuesForDynamicListValueMapModel);
        $transformer = new SupportedValuesForDynamicListTransformer($supportedValuesForDynamicListValueMapTransformer);

        $actual = $transformer->transform([SupportedValuesForDynamicListTransformerInterface::KEY_VALUE => 'test-value']);

        self::assertNull($actual->getValueMap());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new SupportedValuesForDynamicListTransformer(self::createStub(SupportedValuesForDynamicListValueMapTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'valueAbsent' => [[], sprintf(SupportedValuesForDynamicListTransformerInterface::UNEXPECTED_STRING_SPRINTF, SupportedValuesForDynamicListTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[SupportedValuesForDynamicListTransformerInterface::KEY_VALUE => 42], sprintf(SupportedValuesForDynamicListTransformerInterface::UNEXPECTED_STRING_SPRINTF, SupportedValuesForDynamicListTransformerInterface::KEY_VALUE)];
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
