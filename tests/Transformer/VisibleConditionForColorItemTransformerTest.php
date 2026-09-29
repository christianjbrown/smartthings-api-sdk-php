<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\VisibleConditionForColorItem;
use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemReferToInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForColorItemReferToTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForColorItemTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForColorItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new VisibleConditionForColorItemTransformer(self::createStub(VisibleConditionForColorItemReferToTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'operatorAbsent' => [[VisibleConditionForColorItemTransformerInterface::KEY_OPERAND => 'test-operand'], sprintf(VisibleConditionForColorItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionForColorItemTransformerInterface::KEY_OPERATOR)];
        yield 'operatorWrongType' => [[VisibleConditionForColorItemTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForColorItemTransformerInterface::KEY_OPERATOR => 42], sprintf(VisibleConditionForColorItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionForColorItemTransformerInterface::KEY_OPERATOR)];
        yield 'operandAbsent' => [[VisibleConditionForColorItemTransformerInterface::KEY_OPERATOR => 'test-operator'], sprintf(VisibleConditionForColorItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionForColorItemTransformerInterface::KEY_OPERAND)];
        yield 'operandWrongType' => [[VisibleConditionForColorItemTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForColorItemTransformerInterface::KEY_OPERAND => 42], sprintf(VisibleConditionForColorItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionForColorItemTransformerInterface::KEY_OPERAND)];
    }
}
