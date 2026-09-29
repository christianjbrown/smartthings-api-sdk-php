<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityReferenceRequestInterface;
use ChristianBrown\SmartThings\Model\DeviceCategoryInterface;
use ChristianBrown\SmartThings\Model\DeviceProfileComponentRequest;
use ChristianBrown\SmartThings\Model\RestrictionInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityReferenceRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceCategorySerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceProfileComponentRequestSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceProfileComponentRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\RestrictionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceProfileComponentRequest::class)]
#[CoversClass(DeviceProfileComponentRequestSerializer::class)]
final class DeviceProfileComponentRequestSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $capabilityReferenceRequestModel = self::createStub(CapabilityReferenceRequestInterface::class);
        $capabilityReferenceRequestSerializer = self::createStub(CapabilityReferenceRequestSerializerInterface::class);
        $capabilityReferenceRequestSerializer->method('serialize')->willReturn(['test-serialized-capability-reference-request']);
        $deviceCategoryModel = self::createStub(DeviceCategoryInterface::class);
        $deviceCategorySerializer = self::createStub(DeviceCategorySerializerInterface::class);
        $deviceCategorySerializer->method('serialize')->willReturn(['test-serialized-device-category']);
        $restrictionModel = self::createStub(RestrictionInterface::class);
        $restrictionSerializer = self::createStub(RestrictionSerializerInterface::class);
        $restrictionSerializer->method('serialize')->willReturn(['test-serialized-restriction']);
        $model = new DeviceProfileComponentRequest('test-id', [$capabilityReferenceRequestModel], [$deviceCategoryModel]);

        $serializer = new DeviceProfileComponentRequestSerializer($capabilityReferenceRequestSerializer, $deviceCategorySerializer, $restrictionSerializer);

        self::assertSame(
            [
                DeviceProfileComponentRequestSerializerInterface::KEY_ID => 'test-id',
                DeviceProfileComponentRequestSerializerInterface::KEY_CAPABILITIES => [['test-serialized-capability-reference-request']],
                DeviceProfileComponentRequestSerializerInterface::KEY_CATEGORIES => [['test-serialized-device-category']],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $capabilityReferenceRequestModel = self::createStub(CapabilityReferenceRequestInterface::class);
        $capabilityReferenceRequestSerializer = self::createStub(CapabilityReferenceRequestSerializerInterface::class);
        $capabilityReferenceRequestSerializer->method('serialize')->willReturn(['test-serialized-capability-reference-request']);
        $deviceCategoryModel = self::createStub(DeviceCategoryInterface::class);
        $deviceCategorySerializer = self::createStub(DeviceCategorySerializerInterface::class);
        $deviceCategorySerializer->method('serialize')->willReturn(['test-serialized-device-category']);
        $restrictionModel = self::createStub(RestrictionInterface::class);
        $restrictionSerializer = self::createStub(RestrictionSerializerInterface::class);
        $restrictionSerializer->method('serialize')->willReturn(['test-serialized-restriction']);
        $model = (new DeviceProfileComponentRequest('test-id', [$capabilityReferenceRequestModel], [$deviceCategoryModel]))
            ->setLabel('test-label')
            ->setRestrictions($restrictionModel)
            ->setOptional(true);

        $serializer = new DeviceProfileComponentRequestSerializer($capabilityReferenceRequestSerializer, $deviceCategorySerializer, $restrictionSerializer);

        self::assertSame(
            [
                DeviceProfileComponentRequestSerializerInterface::KEY_LABEL => 'test-label',
                DeviceProfileComponentRequestSerializerInterface::KEY_ID => 'test-id',
                DeviceProfileComponentRequestSerializerInterface::KEY_CAPABILITIES => [['test-serialized-capability-reference-request']],
                DeviceProfileComponentRequestSerializerInterface::KEY_CATEGORIES => [['test-serialized-device-category']],
                DeviceProfileComponentRequestSerializerInterface::KEY_RESTRICTIONS => ['test-serialized-restriction'],
                DeviceProfileComponentRequestSerializerInterface::KEY_OPTIONAL => true,
            ],
            $serializer->serialize($model)
        );
    }
}
