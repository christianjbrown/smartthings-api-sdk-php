<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\BasicPlusProgressBarsBarItem;
use ChristianBrown\SmartThings\Transformer\BasicPlusProgressBarsBarItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusProgressBarsBarItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(BasicPlusProgressBarsBarItem::class)]
#[CoversClass(BasicPlusProgressBarsBarItemTransformer::class)]
final class BasicPlusProgressBarsBarItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            BasicPlusProgressBarsBarItemTransformerInterface::KEY_CAPABILITY => 'test-capability',
            BasicPlusProgressBarsBarItemTransformerInterface::KEY_VERSION => 7,
            BasicPlusProgressBarsBarItemTransformerInterface::KEY_COMPONENT => 'test-component',
            BasicPlusProgressBarsBarItemTransformerInterface::KEY_VALUE => 'test-value',
            BasicPlusProgressBarsBarItemTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            BasicPlusProgressBarsBarItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
        ];

        $transformer = new BasicPlusProgressBarsBarItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusProgressBarsBarItemTransformer();

        $actual = $transformer->transform([BasicPlusProgressBarsBarItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusProgressBarsBarItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusProgressBarsBarItemTransformerInterface::KEY_VALUE => 'test-value'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[BasicPlusProgressBarsBarItemTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[BasicPlusProgressBarsBarItemTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[BasicPlusProgressBarsBarItemTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[BasicPlusProgressBarsBarItemTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
        yield 'rangeAbsent' => [[], 'getRange', null];
        yield 'rangeWrongType' => [[BasicPlusProgressBarsBarItemTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', null];
        yield 'rangeValid' => [[BasicPlusProgressBarsBarItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], 'getRange', ['test-range-key' => 'test-value']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new BasicPlusProgressBarsBarItemTransformer();

        $actual = $transformer->transform([BasicPlusProgressBarsBarItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusProgressBarsBarItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusProgressBarsBarItemTransformerInterface::KEY_VALUE => 'test-value']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getValueType());
        self::assertNull($actual->getRange());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new BasicPlusProgressBarsBarItemTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'capabilityAbsent' => [[BasicPlusProgressBarsBarItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusProgressBarsBarItemTransformerInterface::KEY_VALUE => 'test-value'], sprintf(BasicPlusProgressBarsBarItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusProgressBarsBarItemTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[BasicPlusProgressBarsBarItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusProgressBarsBarItemTransformerInterface::KEY_VALUE => 'test-value', BasicPlusProgressBarsBarItemTransformerInterface::KEY_CAPABILITY => 42], sprintf(BasicPlusProgressBarsBarItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusProgressBarsBarItemTransformerInterface::KEY_CAPABILITY)];
        yield 'componentAbsent' => [[BasicPlusProgressBarsBarItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusProgressBarsBarItemTransformerInterface::KEY_VALUE => 'test-value'], sprintf(BasicPlusProgressBarsBarItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusProgressBarsBarItemTransformerInterface::KEY_COMPONENT)];
        yield 'componentWrongType' => [[BasicPlusProgressBarsBarItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusProgressBarsBarItemTransformerInterface::KEY_VALUE => 'test-value', BasicPlusProgressBarsBarItemTransformerInterface::KEY_COMPONENT => 42], sprintf(BasicPlusProgressBarsBarItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusProgressBarsBarItemTransformerInterface::KEY_COMPONENT)];
        yield 'valueAbsent' => [[BasicPlusProgressBarsBarItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusProgressBarsBarItemTransformerInterface::KEY_COMPONENT => 'test-component'], sprintf(BasicPlusProgressBarsBarItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusProgressBarsBarItemTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[BasicPlusProgressBarsBarItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusProgressBarsBarItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusProgressBarsBarItemTransformerInterface::KEY_VALUE => 42], sprintf(BasicPlusProgressBarsBarItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusProgressBarsBarItemTransformerInterface::KEY_VALUE)];
    }
}
