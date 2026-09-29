<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemBadgeItem;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemBadgeItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemBadgeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DeviceConfigurationIconsItemBadgeItem::class)]
#[CoversClass(DeviceConfigurationIconsItemBadgeItemTransformer::class)]
final class DeviceConfigurationIconsItemBadgeItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $data = [
            DeviceConfigurationIconsItemBadgeItemTransformerInterface::KEY_ICON_URL => 'test-icon-url',
            DeviceConfigurationIconsItemBadgeItemTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested']],
        ];

        $transformer = new DeviceConfigurationIconsItemBadgeItemTransformer($visibleConditionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-icon-url', $actual->getIconUrl());
        self::assertSame([$visibleConditionModel], $actual->getVisibleConditions());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new DeviceConfigurationIconsItemBadgeItemTransformer($visibleConditionTransformer);

        $actual = $transformer->transform([DeviceConfigurationIconsItemBadgeItemTransformerInterface::KEY_ICON_URL => 'test-icon-url']);

        self::assertNull($actual->getVisibleConditions());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new DeviceConfigurationIconsItemBadgeItemTransformer(self::createStub(VisibleConditionTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'iconUrlAbsent' => [[], sprintf(DeviceConfigurationIconsItemBadgeItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationIconsItemBadgeItemTransformerInterface::KEY_ICON_URL)];
        yield 'iconUrlWrongType' => [[DeviceConfigurationIconsItemBadgeItemTransformerInterface::KEY_ICON_URL => 42], sprintf(DeviceConfigurationIconsItemBadgeItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationIconsItemBadgeItemTransformerInterface::KEY_ICON_URL)];
    }

    public function testTransformVisibleConditions(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new DeviceConfigurationIconsItemBadgeItemTransformer($visibleConditionTransformer);
        $base = [DeviceConfigurationIconsItemBadgeItemTransformerInterface::KEY_ICON_URL => 'test-icon-url'];

        self::assertNull($transformer->transform($base)->getVisibleConditions());
        self::assertNull($transformer->transform($base + [DeviceConfigurationIconsItemBadgeItemTransformerInterface::KEY_VISIBLE_CONDITIONS => 'test-not-array'])->getVisibleConditions());
        self::assertSame([$visibleConditionModel], $transformer->transform($base + [DeviceConfigurationIconsItemBadgeItemTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested'], 'test-skipped']])->getVisibleConditions());
    }
}
