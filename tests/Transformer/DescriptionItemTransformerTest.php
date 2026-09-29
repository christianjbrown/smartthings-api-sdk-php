<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DescriptionItem;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\DescriptionItemTransformer;
use ChristianBrown\SmartThings\Transformer\DescriptionItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DescriptionItem::class)]
#[CoversClass(DescriptionItemTransformer::class)]
final class DescriptionItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $data = [
            DescriptionItemTransformerInterface::KEY_OPERATOR => 'test-operator',
            DescriptionItemTransformerInterface::KEY_LABEL => 'test-label',
            DescriptionItemTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested']],
        ];

        $transformer = new DescriptionItemTransformer($visibleConditionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-operator', $actual->getOperator());
        self::assertSame('test-label', $actual->getLabel());
        self::assertSame([$visibleConditionModel], $actual->getVisibleConditions());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DescriptionItemTransformer(self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform([DescriptionItemTransformerInterface::KEY_LABEL => 'test-label'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'operatorAbsent' => [[], 'getOperator', null];
        yield 'operatorWrongType' => [[DescriptionItemTransformerInterface::KEY_OPERATOR => 42], 'getOperator', null];
        yield 'operatorValid' => [[DescriptionItemTransformerInterface::KEY_OPERATOR => 'test-operator'], 'getOperator', 'test-operator'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new DescriptionItemTransformer($visibleConditionTransformer);

        $actual = $transformer->transform([DescriptionItemTransformerInterface::KEY_LABEL => 'test-label']);

        self::assertNull($actual->getOperator());
        self::assertNull($actual->getVisibleConditions());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new DescriptionItemTransformer(self::createStub(VisibleConditionTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'labelAbsent' => [[], sprintf(DescriptionItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, DescriptionItemTransformerInterface::KEY_LABEL)];
        yield 'labelWrongType' => [[DescriptionItemTransformerInterface::KEY_LABEL => 42], sprintf(DescriptionItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, DescriptionItemTransformerInterface::KEY_LABEL)];
    }

    public function testTransformVisibleConditions(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new DescriptionItemTransformer($visibleConditionTransformer);
        $base = [DescriptionItemTransformerInterface::KEY_LABEL => 'test-label'];

        self::assertNull($transformer->transform($base)->getVisibleConditions());
        self::assertNull($transformer->transform($base + [DescriptionItemTransformerInterface::KEY_VISIBLE_CONDITIONS => 'test-not-array'])->getVisibleConditions());
        self::assertSame([$visibleConditionModel], $transformer->transform($base + [DescriptionItemTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested'], 'test-skipped']])->getVisibleConditions());
    }
}
