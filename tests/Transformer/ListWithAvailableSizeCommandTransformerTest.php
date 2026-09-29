<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeCommand;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeCommandTransformer;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ListWithAvailableSizeCommand::class)]
#[CoversClass(ListWithAvailableSizeCommandTransformer::class)]
final class ListWithAvailableSizeCommandTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            ListWithAvailableSizeCommandTransformerInterface::KEY_NAME => 'test-name',
            ListWithAvailableSizeCommandTransformerInterface::KEY_DESCRIPTION => 'test-description',
            ListWithAvailableSizeCommandTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            ListWithAvailableSizeCommandTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            ListWithAvailableSizeCommandTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
        ];

        $transformer = new ListWithAvailableSizeCommandTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertSame('test-description', $actual->getDescription());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame('test-argument-type', $actual->getArgumentType());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ListWithAvailableSizeCommandTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([ListWithAvailableSizeCommandTransformerInterface::KEY_ALTERNATIVES => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'nameAbsent' => [[], 'getName', null];
        yield 'nameWrongType' => [[ListWithAvailableSizeCommandTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'nameValid' => [[ListWithAvailableSizeCommandTransformerInterface::KEY_NAME => 'test-name'], 'getName', 'test-name'];
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[ListWithAvailableSizeCommandTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[ListWithAvailableSizeCommandTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[ListWithAvailableSizeCommandTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[ListWithAvailableSizeCommandTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[ListWithAvailableSizeCommandTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[ListWithAvailableSizeCommandTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new ListWithAvailableSizeCommandTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([ListWithAvailableSizeCommandTransformerInterface::KEY_ALTERNATIVES => ['test-nested']]);

        self::assertNull($actual->getName());
        self::assertNull($actual->getDescription());
        self::assertNull($actual->getArgumentType());
        self::assertNull($actual->getSupportedValues());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ListWithAvailableSizeCommandTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'alternativesAbsent' => [[], sprintf(ListWithAvailableSizeCommandTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListWithAvailableSizeCommandTransformerInterface::KEY_ALTERNATIVES)];
        yield 'alternativesWrongType' => [[ListWithAvailableSizeCommandTransformerInterface::KEY_ALTERNATIVES => 'not-array'], sprintf(ListWithAvailableSizeCommandTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListWithAvailableSizeCommandTransformerInterface::KEY_ALTERNATIVES)];
    }
}
