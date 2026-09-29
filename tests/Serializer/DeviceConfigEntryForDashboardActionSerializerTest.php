<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardAction;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardActionInlineInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardActionInlineSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardActionSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardActionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigEntryForDashboardAction::class)]
#[CoversClass(DeviceConfigEntryForDashboardActionSerializer::class)]
final class DeviceConfigEntryForDashboardActionSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $deviceConfigEntryForDashboardActionInlineModel = self::createStub(DeviceConfigEntryForDashboardActionInlineInterface::class);
        $deviceConfigEntryForDashboardActionInlineSerializer = self::createStub(DeviceConfigEntryForDashboardActionInlineSerializerInterface::class);
        $deviceConfigEntryForDashboardActionInlineSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-dashboard-action-inline']);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = new DeviceConfigEntryForDashboardAction('test-component', 'test-capability');

        $serializer = new DeviceConfigEntryForDashboardActionSerializer($deviceConfigEntryForDashboardActionInlineSerializer, $visibleConditionSerializer);

        self::assertSame(
            [
                DeviceConfigEntryForDashboardActionSerializerInterface::KEY_COMPONENT => 'test-component',
                DeviceConfigEntryForDashboardActionSerializerInterface::KEY_CAPABILITY => 'test-capability',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $deviceConfigEntryForDashboardActionInlineModel = self::createStub(DeviceConfigEntryForDashboardActionInlineInterface::class);
        $deviceConfigEntryForDashboardActionInlineSerializer = self::createStub(DeviceConfigEntryForDashboardActionInlineSerializerInterface::class);
        $deviceConfigEntryForDashboardActionInlineSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-dashboard-action-inline']);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = (new DeviceConfigEntryForDashboardAction('test-component', 'test-capability'))
            ->setVersion(7)
            ->setIdx(7)
            ->setGroup('test-group')
            ->setInline($deviceConfigEntryForDashboardActionInlineModel)
            ->setVisibleCondition($visibleConditionModel);

        $serializer = new DeviceConfigEntryForDashboardActionSerializer($deviceConfigEntryForDashboardActionInlineSerializer, $visibleConditionSerializer);

        self::assertSame(
            [
                DeviceConfigEntryForDashboardActionSerializerInterface::KEY_COMPONENT => 'test-component',
                DeviceConfigEntryForDashboardActionSerializerInterface::KEY_CAPABILITY => 'test-capability',
                DeviceConfigEntryForDashboardActionSerializerInterface::KEY_VERSION => 7,
                DeviceConfigEntryForDashboardActionSerializerInterface::KEY_IDX => 7,
                DeviceConfigEntryForDashboardActionSerializerInterface::KEY_GROUP => 'test-group',
                DeviceConfigEntryForDashboardActionSerializerInterface::KEY_INLINE => ['test-serialized-device-config-entry-for-dashboard-action-inline'],
                DeviceConfigEntryForDashboardActionSerializerInterface::KEY_VISIBLE_CONDITION => ['test-serialized-visible-condition'],
            ],
            $serializer->serialize($model)
        );
    }
}
