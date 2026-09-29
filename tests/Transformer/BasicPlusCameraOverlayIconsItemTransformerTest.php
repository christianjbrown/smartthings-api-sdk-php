<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\BasicPlusCameraOverlayIconsItem;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraOverlayIconsItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraOverlayIconsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(BasicPlusCameraOverlayIconsItem::class)]
#[CoversClass(BasicPlusCameraOverlayIconsItemTransformer::class)]
final class BasicPlusCameraOverlayIconsItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $data = [
            BasicPlusCameraOverlayIconsItemTransformerInterface::KEY_ICON_URL => 'test-icon-url',
            BasicPlusCameraOverlayIconsItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested'],
        ];

        $transformer = new BasicPlusCameraOverlayIconsItemTransformer($visibleConditionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-icon-url', $actual->getIconUrl());
        self::assertSame($visibleConditionModel, $actual->getVisibleCondition());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusCameraOverlayIconsItemTransformer($visibleConditionTransformer);

        $actual = $transformer->transform([BasicPlusCameraOverlayIconsItemTransformerInterface::KEY_ICON_URL => 'test-icon-url']);

        self::assertNull($actual->getVisibleCondition());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new BasicPlusCameraOverlayIconsItemTransformer(self::createStub(VisibleConditionTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'iconUrlAbsent' => [[], sprintf(BasicPlusCameraOverlayIconsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusCameraOverlayIconsItemTransformerInterface::KEY_ICON_URL)];
        yield 'iconUrlWrongType' => [[BasicPlusCameraOverlayIconsItemTransformerInterface::KEY_ICON_URL => 42], sprintf(BasicPlusCameraOverlayIconsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusCameraOverlayIconsItemTransformerInterface::KEY_ICON_URL)];
    }

    public function testTransformVisibleCondition(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusCameraOverlayIconsItemTransformer($visibleConditionTransformer);
        $base = [BasicPlusCameraOverlayIconsItemTransformerInterface::KEY_ICON_URL => 'test-icon-url'];

        self::assertNull($transformer->transform($base)->getVisibleCondition());
        self::assertNull($transformer->transform($base + [BasicPlusCameraOverlayIconsItemTransformerInterface::KEY_VISIBLE_CONDITION => 'test-not-array'])->getVisibleCondition());
        self::assertSame($visibleConditionModel, $transformer->transform($base + [BasicPlusCameraOverlayIconsItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested']])->getVisibleCondition());
    }
}
