<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\StateItem;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StateItemTransformer;
use ChristianBrown\SmartThings\Transformer\StateItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(StateItem::class)]
#[CoversClass(StateItemTransformer::class)]
final class StateItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            StateItemTransformerInterface::KEY_LABEL => 'test-label',
            StateItemTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
        ];

        $transformer = new StateItemTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-label', $actual->getLabel());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new StateItemTransformer($alternativeItemTransformer);
        $base = [StateItemTransformerInterface::KEY_LABEL => 'test-label'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [StateItemTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [StateItemTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new StateItemTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([StateItemTransformerInterface::KEY_LABEL => 'test-label']);

        self::assertNull($actual->getAlternatives());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new StateItemTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'labelAbsent' => [[], sprintf(StateItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, StateItemTransformerInterface::KEY_LABEL)];
        yield 'labelWrongType' => [[StateItemTransformerInterface::KEY_LABEL => 42], sprintf(StateItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, StateItemTransformerInterface::KEY_LABEL)];
    }
}
