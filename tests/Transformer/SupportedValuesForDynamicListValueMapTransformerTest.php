<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListValueMap;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListValueMapTransformer;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListValueMapTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new SupportedValuesForDynamicListValueMapTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'keyAbsent' => [[SupportedValuesForDynamicListValueMapTransformerInterface::KEY_VALUE => 'test-value'], sprintf(SupportedValuesForDynamicListValueMapTransformerInterface::UNEXPECTED_STRING_SPRINTF, SupportedValuesForDynamicListValueMapTransformerInterface::KEY_KEY)];
        yield 'keyWrongType' => [[SupportedValuesForDynamicListValueMapTransformerInterface::KEY_VALUE => 'test-value', SupportedValuesForDynamicListValueMapTransformerInterface::KEY_KEY => 42], sprintf(SupportedValuesForDynamicListValueMapTransformerInterface::UNEXPECTED_STRING_SPRINTF, SupportedValuesForDynamicListValueMapTransformerInterface::KEY_KEY)];
        yield 'valueAbsent' => [[SupportedValuesForDynamicListValueMapTransformerInterface::KEY_KEY => 'test-key'], sprintf(SupportedValuesForDynamicListValueMapTransformerInterface::UNEXPECTED_STRING_SPRINTF, SupportedValuesForDynamicListValueMapTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[SupportedValuesForDynamicListValueMapTransformerInterface::KEY_KEY => 'test-key', SupportedValuesForDynamicListValueMapTransformerInterface::KEY_VALUE => 42], sprintf(SupportedValuesForDynamicListValueMapTransformerInterface::UNEXPECTED_STRING_SPRINTF, SupportedValuesForDynamicListValueMapTransformerInterface::KEY_VALUE)];
    }
}
