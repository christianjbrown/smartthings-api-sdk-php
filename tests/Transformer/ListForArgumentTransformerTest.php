<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\ListForArgument;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListForArgumentTransformer;
use ChristianBrown\SmartThings\Transformer\ListForArgumentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ListForArgument::class)]
#[CoversClass(ListForArgumentTransformer::class)]
final class ListForArgumentTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            ListForArgumentTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            ListForArgumentTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            ListForArgumentTransformerInterface::KEY_NAME => 'test-name',
            ListForArgumentTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
        ];

        $transformer = new ListForArgumentTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
        self::assertSame('test-name', $actual->getName());
        self::assertSame('test-argument-type', $actual->getArgumentType());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ListForArgumentTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([ListForArgumentTransformerInterface::KEY_ALTERNATIVES => ['test-nested'], ListForArgumentTransformerInterface::KEY_NAME => 'test-name'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[ListForArgumentTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[ListForArgumentTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[ListForArgumentTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[ListForArgumentTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new ListForArgumentTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([ListForArgumentTransformerInterface::KEY_ALTERNATIVES => ['test-nested'], ListForArgumentTransformerInterface::KEY_NAME => 'test-name']);

        self::assertNull($actual->getSupportedValues());
        self::assertNull($actual->getArgumentType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ListForArgumentTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'alternativesAbsent' => [[ListForArgumentTransformerInterface::KEY_NAME => 'test-name'], sprintf(ListForArgumentTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListForArgumentTransformerInterface::KEY_ALTERNATIVES)];
        yield 'alternativesWrongType' => [[ListForArgumentTransformerInterface::KEY_NAME => 'test-name', ListForArgumentTransformerInterface::KEY_ALTERNATIVES => 'not-array'], sprintf(ListForArgumentTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListForArgumentTransformerInterface::KEY_ALTERNATIVES)];
        yield 'nameAbsent' => [[ListForArgumentTransformerInterface::KEY_ALTERNATIVES => ['test-nested']], sprintf(ListForArgumentTransformerInterface::UNEXPECTED_STRING_SPRINTF, ListForArgumentTransformerInterface::KEY_NAME)];
        yield 'nameWrongType' => [[ListForArgumentTransformerInterface::KEY_ALTERNATIVES => ['test-nested'], ListForArgumentTransformerInterface::KEY_NAME => 42], sprintf(ListForArgumentTransformerInterface::UNEXPECTED_STRING_SPRINTF, ListForArgumentTransformerInterface::KEY_NAME)];
    }
}
