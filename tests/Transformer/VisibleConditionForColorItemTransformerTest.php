<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\VisibleConditionForColorItem;
use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemReferToInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForColorItemReferToTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForColorItemTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForColorItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(VisibleConditionForColorItem::class)]
#[CoversClass(VisibleConditionForColorItemTransformer::class)]
final class VisibleConditionForColorItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $visibleConditionForColorItemReferToModel = self::createStub(VisibleConditionForColorItemReferToInterface::class);
        $visibleConditionForColorItemReferToTransformer = self::createStub(VisibleConditionForColorItemReferToTransformerInterface::class);
        $visibleConditionForColorItemReferToTransformer->method('transform')->willReturn($visibleConditionForColorItemReferToModel);
        $data = [
            VisibleConditionForColorItemTransformerInterface::KEY_REFER_TO => ['test-nested'],
            VisibleConditionForColorItemTransformerInterface::KEY_OPERATOR => 'test-operator',
            VisibleConditionForColorItemTransformerInterface::KEY_OPERAND => 'test-operand',
        ];

        $transformer = new VisibleConditionForColorItemTransformer($visibleConditionForColorItemReferToTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($visibleConditionForColorItemReferToModel, $actual->getReferTo());
        self::assertSame('test-operator', $actual->getOperator());
        self::assertSame('test-operand', $actual->getOperand());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new VisibleConditionForColorItemTransformer(self::createStub(VisibleConditionForColorItemReferToTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'operatorAbsent' => [[VisibleConditionForColorItemTransformerInterface::KEY_OPERAND => 'test-operand'], 'getOperator', null];
        yield 'operatorWrongType' => [[VisibleConditionForColorItemTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForColorItemTransformerInterface::KEY_OPERATOR => 42], 'getOperator', null];
        yield 'operandAbsent' => [[VisibleConditionForColorItemTransformerInterface::KEY_OPERATOR => 'test-operator'], 'getOperand', null];
        yield 'operandWrongType' => [[VisibleConditionForColorItemTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForColorItemTransformerInterface::KEY_OPERAND => 42], 'getOperand', null];
    }

    public function testTransformReferTo(): void
    {
        $visibleConditionForColorItemReferToModel = self::createStub(VisibleConditionForColorItemReferToInterface::class);
        $visibleConditionForColorItemReferToTransformer = self::createStub(VisibleConditionForColorItemReferToTransformerInterface::class);
        $visibleConditionForColorItemReferToTransformer->method('transform')->willReturn($visibleConditionForColorItemReferToModel);
        $transformer = new VisibleConditionForColorItemTransformer($visibleConditionForColorItemReferToTransformer);
        $base = [VisibleConditionForColorItemTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForColorItemTransformerInterface::KEY_OPERAND => 'test-operand'];

        self::assertNull($transformer->transform($base)->getReferTo());
        self::assertNull($transformer->transform($base + [VisibleConditionForColorItemTransformerInterface::KEY_REFER_TO => 'test-not-array'])->getReferTo());
        self::assertSame($visibleConditionForColorItemReferToModel, $transformer->transform($base + [VisibleConditionForColorItemTransformerInterface::KEY_REFER_TO => ['test-nested']])->getReferTo());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $visibleConditionForColorItemReferToModel = self::createStub(VisibleConditionForColorItemReferToInterface::class);
        $visibleConditionForColorItemReferToTransformer = self::createStub(VisibleConditionForColorItemReferToTransformerInterface::class);
        $visibleConditionForColorItemReferToTransformer->method('transform')->willReturn($visibleConditionForColorItemReferToModel);
        $transformer = new VisibleConditionForColorItemTransformer($visibleConditionForColorItemReferToTransformer);

        $actual = $transformer->transform([VisibleConditionForColorItemTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForColorItemTransformerInterface::KEY_OPERAND => 'test-operand']);

        self::assertNull($actual->getReferTo());
    }
}
