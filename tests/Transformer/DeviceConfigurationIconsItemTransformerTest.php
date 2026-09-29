<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItem;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemBadgeItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemProductKeysItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemBadgeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemProductKeysItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigurationIconsItem::class)]
#[CoversClass(DeviceConfigurationIconsItemTransformer::class)]
final class DeviceConfigurationIconsItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $deviceConfigurationIconsItemBadgeItemModel = self::createStub(DeviceConfigurationIconsItemBadgeItemInterface::class);
        $deviceConfigurationIconsItemBadgeItemTransformer = self::createStub(DeviceConfigurationIconsItemBadgeItemTransformerInterface::class);
        $deviceConfigurationIconsItemBadgeItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemBadgeItemModel);
        $deviceConfigurationIconsItemProductKeysItemModel = self::createStub(DeviceConfigurationIconsItemProductKeysItemInterface::class);
        $deviceConfigurationIconsItemProductKeysItemTransformer = self::createStub(DeviceConfigurationIconsItemProductKeysItemTransformerInterface::class);
        $deviceConfigurationIconsItemProductKeysItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemProductKeysItemModel);
        $data = [
            DeviceConfigurationIconsItemTransformerInterface::KEY_GROUP => 'test-group',
            DeviceConfigurationIconsItemTransformerInterface::KEY_ICON_URL => 'test-icon-url',
            DeviceConfigurationIconsItemTransformerInterface::KEY_RUNNING_CONDITIONS => [['test-nested']],
            DeviceConfigurationIconsItemTransformerInterface::KEY_BADGE => [['test-nested']],
            DeviceConfigurationIconsItemTransformerInterface::KEY_PRODUCT_KEYS => [['test-nested']],
        ];

        $transformer = new DeviceConfigurationIconsItemTransformer($visibleConditionTransformer, $deviceConfigurationIconsItemBadgeItemTransformer, $deviceConfigurationIconsItemProductKeysItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-group', $actual->getGroup());
        self::assertSame('test-icon-url', $actual->getIconUrl());
        self::assertSame([$visibleConditionModel], $actual->getRunningConditions());
        self::assertSame([$deviceConfigurationIconsItemBadgeItemModel], $actual->getBadge());
        self::assertSame([$deviceConfigurationIconsItemProductKeysItemModel], $actual->getProductKeys());
    }

    public function testTransformBadge(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $deviceConfigurationIconsItemBadgeItemModel = self::createStub(DeviceConfigurationIconsItemBadgeItemInterface::class);
        $deviceConfigurationIconsItemBadgeItemTransformer = self::createStub(DeviceConfigurationIconsItemBadgeItemTransformerInterface::class);
        $deviceConfigurationIconsItemBadgeItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemBadgeItemModel);
        $deviceConfigurationIconsItemProductKeysItemModel = self::createStub(DeviceConfigurationIconsItemProductKeysItemInterface::class);
        $deviceConfigurationIconsItemProductKeysItemTransformer = self::createStub(DeviceConfigurationIconsItemProductKeysItemTransformerInterface::class);
        $deviceConfigurationIconsItemProductKeysItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemProductKeysItemModel);
        $transformer = new DeviceConfigurationIconsItemTransformer($visibleConditionTransformer, $deviceConfigurationIconsItemBadgeItemTransformer, $deviceConfigurationIconsItemProductKeysItemTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getBadge());
        self::assertNull($transformer->transform($base + [DeviceConfigurationIconsItemTransformerInterface::KEY_BADGE => 'test-not-array'])->getBadge());
        self::assertSame([$deviceConfigurationIconsItemBadgeItemModel], $transformer->transform($base + [DeviceConfigurationIconsItemTransformerInterface::KEY_BADGE => [['test-nested'], 'test-skipped']])->getBadge());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigurationIconsItemTransformer(self::createStub(VisibleConditionTransformerInterface::class), self::createStub(DeviceConfigurationIconsItemBadgeItemTransformerInterface::class), self::createStub(DeviceConfigurationIconsItemProductKeysItemTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'groupAbsent' => [[], 'getGroup', null];
        yield 'groupWrongType' => [[DeviceConfigurationIconsItemTransformerInterface::KEY_GROUP => 42], 'getGroup', null];
        yield 'groupValid' => [[DeviceConfigurationIconsItemTransformerInterface::KEY_GROUP => 'test-group'], 'getGroup', 'test-group'];
        yield 'iconUrlAbsent' => [[], 'getIconUrl', null];
        yield 'iconUrlWrongType' => [[DeviceConfigurationIconsItemTransformerInterface::KEY_ICON_URL => 42], 'getIconUrl', null];
        yield 'iconUrlValid' => [[DeviceConfigurationIconsItemTransformerInterface::KEY_ICON_URL => 'test-icon-url'], 'getIconUrl', 'test-icon-url'];
    }

    public function testTransformProductKeys(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $deviceConfigurationIconsItemBadgeItemModel = self::createStub(DeviceConfigurationIconsItemBadgeItemInterface::class);
        $deviceConfigurationIconsItemBadgeItemTransformer = self::createStub(DeviceConfigurationIconsItemBadgeItemTransformerInterface::class);
        $deviceConfigurationIconsItemBadgeItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemBadgeItemModel);
        $deviceConfigurationIconsItemProductKeysItemModel = self::createStub(DeviceConfigurationIconsItemProductKeysItemInterface::class);
        $deviceConfigurationIconsItemProductKeysItemTransformer = self::createStub(DeviceConfigurationIconsItemProductKeysItemTransformerInterface::class);
        $deviceConfigurationIconsItemProductKeysItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemProductKeysItemModel);
        $transformer = new DeviceConfigurationIconsItemTransformer($visibleConditionTransformer, $deviceConfigurationIconsItemBadgeItemTransformer, $deviceConfigurationIconsItemProductKeysItemTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getProductKeys());
        self::assertNull($transformer->transform($base + [DeviceConfigurationIconsItemTransformerInterface::KEY_PRODUCT_KEYS => 'test-not-array'])->getProductKeys());
        self::assertSame([$deviceConfigurationIconsItemProductKeysItemModel], $transformer->transform($base + [DeviceConfigurationIconsItemTransformerInterface::KEY_PRODUCT_KEYS => [['test-nested'], 'test-skipped']])->getProductKeys());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $deviceConfigurationIconsItemBadgeItemModel = self::createStub(DeviceConfigurationIconsItemBadgeItemInterface::class);
        $deviceConfigurationIconsItemBadgeItemTransformer = self::createStub(DeviceConfigurationIconsItemBadgeItemTransformerInterface::class);
        $deviceConfigurationIconsItemBadgeItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemBadgeItemModel);
        $deviceConfigurationIconsItemProductKeysItemModel = self::createStub(DeviceConfigurationIconsItemProductKeysItemInterface::class);
        $deviceConfigurationIconsItemProductKeysItemTransformer = self::createStub(DeviceConfigurationIconsItemProductKeysItemTransformerInterface::class);
        $deviceConfigurationIconsItemProductKeysItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemProductKeysItemModel);
        $transformer = new DeviceConfigurationIconsItemTransformer($visibleConditionTransformer, $deviceConfigurationIconsItemBadgeItemTransformer, $deviceConfigurationIconsItemProductKeysItemTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getGroup());
        self::assertNull($actual->getIconUrl());
        self::assertNull($actual->getRunningConditions());
        self::assertNull($actual->getBadge());
        self::assertNull($actual->getProductKeys());
    }

    public function testTransformRunningConditions(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $deviceConfigurationIconsItemBadgeItemModel = self::createStub(DeviceConfigurationIconsItemBadgeItemInterface::class);
        $deviceConfigurationIconsItemBadgeItemTransformer = self::createStub(DeviceConfigurationIconsItemBadgeItemTransformerInterface::class);
        $deviceConfigurationIconsItemBadgeItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemBadgeItemModel);
        $deviceConfigurationIconsItemProductKeysItemModel = self::createStub(DeviceConfigurationIconsItemProductKeysItemInterface::class);
        $deviceConfigurationIconsItemProductKeysItemTransformer = self::createStub(DeviceConfigurationIconsItemProductKeysItemTransformerInterface::class);
        $deviceConfigurationIconsItemProductKeysItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemProductKeysItemModel);
        $transformer = new DeviceConfigurationIconsItemTransformer($visibleConditionTransformer, $deviceConfigurationIconsItemBadgeItemTransformer, $deviceConfigurationIconsItemProductKeysItemTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getRunningConditions());
        self::assertNull($transformer->transform($base + [DeviceConfigurationIconsItemTransformerInterface::KEY_RUNNING_CONDITIONS => 'test-not-array'])->getRunningConditions());
        self::assertSame([$visibleConditionModel], $transformer->transform($base + [DeviceConfigurationIconsItemTransformerInterface::KEY_RUNNING_CONDITIONS => [['test-nested'], 'test-skipped']])->getRunningConditions());
    }
}
