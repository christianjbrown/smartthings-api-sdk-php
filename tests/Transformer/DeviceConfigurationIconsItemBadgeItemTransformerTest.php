<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemBadgeItem;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemBadgeItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemBadgeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

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

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigurationIconsItemBadgeItemTransformer(self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'iconUrlAbsent' => [[], 'getIconUrl', null];
        yield 'iconUrlWrongType' => [[DeviceConfigurationIconsItemBadgeItemTransformerInterface::KEY_ICON_URL => 42], 'getIconUrl', null];
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
