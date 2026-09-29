<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\ListForPanelItemCommand;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListForPanelItemCommandTransformer;
use ChristianBrown\SmartThings\Transformer\ListForPanelItemCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ListForPanelItemCommand::class)]
#[CoversClass(ListForPanelItemCommandTransformer::class)]
final class ListForPanelItemCommandTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            ListForPanelItemCommandTransformerInterface::KEY_NAME => 'test-name',
            ListForPanelItemCommandTransformerInterface::KEY_DESCRIPTION => 'test-description',
            ListForPanelItemCommandTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            ListForPanelItemCommandTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            ListForPanelItemCommandTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
        ];

        $transformer = new ListForPanelItemCommandTransformer($alternativeItemTransformer);

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
        $transformer = new ListForPanelItemCommandTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([ListForPanelItemCommandTransformerInterface::KEY_ALTERNATIVES => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'nameAbsent' => [[], 'getName', null];
        yield 'nameWrongType' => [[ListForPanelItemCommandTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'nameValid' => [[ListForPanelItemCommandTransformerInterface::KEY_NAME => 'test-name'], 'getName', 'test-name'];
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[ListForPanelItemCommandTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[ListForPanelItemCommandTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[ListForPanelItemCommandTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[ListForPanelItemCommandTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[ListForPanelItemCommandTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[ListForPanelItemCommandTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new ListForPanelItemCommandTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([ListForPanelItemCommandTransformerInterface::KEY_ALTERNATIVES => ['test-nested']]);

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
        $transformer = new ListForPanelItemCommandTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'alternativesAbsent' => [[], sprintf(ListForPanelItemCommandTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListForPanelItemCommandTransformerInterface::KEY_ALTERNATIVES)];
        yield 'alternativesWrongType' => [[ListForPanelItemCommandTransformerInterface::KEY_ALTERNATIVES => 'not-array'], sprintf(ListForPanelItemCommandTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListForPanelItemCommandTransformerInterface::KEY_ALTERNATIVES)];
    }
}
