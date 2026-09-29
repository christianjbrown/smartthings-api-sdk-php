<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityConfigurationInterface;
use ChristianBrown\SmartThings\Model\CapabilityReferenceRequest;
use ChristianBrown\SmartThings\Model\RestrictionInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityConfigurationSerializerInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityReferenceRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityReferenceRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\RestrictionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityReferenceRequest::class)]
#[CoversClass(CapabilityReferenceRequestSerializer::class)]
final class CapabilityReferenceRequestSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $capabilityConfigurationModel = self::createStub(CapabilityConfigurationInterface::class);
        $capabilityConfigurationSerializer = self::createStub(CapabilityConfigurationSerializerInterface::class);
        $capabilityConfigurationSerializer->method('serialize')->willReturn(['test-serialized-capability-configuration']);
        $restrictionModel = self::createStub(RestrictionInterface::class);
        $restrictionSerializer = self::createStub(RestrictionSerializerInterface::class);
        $restrictionSerializer->method('serialize')->willReturn(['test-serialized-restriction']);
        $model = new CapabilityReferenceRequest('test-id');

        $serializer = new CapabilityReferenceRequestSerializer($capabilityConfigurationSerializer, $restrictionSerializer);

        self::assertSame(
            [
                CapabilityReferenceRequestSerializerInterface::KEY_ID => 'test-id',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $capabilityConfigurationModel = self::createStub(CapabilityConfigurationInterface::class);
        $capabilityConfigurationSerializer = self::createStub(CapabilityConfigurationSerializerInterface::class);
        $capabilityConfigurationSerializer->method('serialize')->willReturn(['test-serialized-capability-configuration']);
        $restrictionModel = self::createStub(RestrictionInterface::class);
        $restrictionSerializer = self::createStub(RestrictionSerializerInterface::class);
        $restrictionSerializer->method('serialize')->willReturn(['test-serialized-restriction']);
        $model = (new CapabilityReferenceRequest('test-id'))
            ->setVersion(7)
            ->setOptional(true)
            ->setConfig($capabilityConfigurationModel)
            ->setRestrictions($restrictionModel);

        $serializer = new CapabilityReferenceRequestSerializer($capabilityConfigurationSerializer, $restrictionSerializer);

        self::assertSame(
            [
                CapabilityReferenceRequestSerializerInterface::KEY_ID => 'test-id',
                CapabilityReferenceRequestSerializerInterface::KEY_VERSION => 7,
                CapabilityReferenceRequestSerializerInterface::KEY_OPTIONAL => true,
                CapabilityReferenceRequestSerializerInterface::KEY_CONFIG => ['test-serialized-capability-configuration'],
                CapabilityReferenceRequestSerializerInterface::KEY_RESTRICTIONS => ['test-serialized-restriction'],
            ],
            $serializer->serialize($model)
        );
    }
}
