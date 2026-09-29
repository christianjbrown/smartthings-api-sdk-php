<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityConfiguration;
use ChristianBrown\SmartThings\Model\CapabilityConfigurationValueInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityConfigurationSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityConfigurationSerializerInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityConfigurationValueSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityConfiguration::class)]
#[CoversClass(CapabilityConfigurationSerializer::class)]
final class CapabilityConfigurationSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $capabilityConfigurationValueModel = self::createStub(CapabilityConfigurationValueInterface::class);
        $capabilityConfigurationValueSerializer = self::createStub(CapabilityConfigurationValueSerializerInterface::class);
        $capabilityConfigurationValueSerializer->method('serialize')->willReturn(['test-serialized-capability-configuration-value']);
        $model = new CapabilityConfiguration([$capabilityConfigurationValueModel]);

        $serializer = new CapabilityConfigurationSerializer($capabilityConfigurationValueSerializer);

        self::assertSame(
            [
                CapabilityConfigurationSerializerInterface::KEY_VALUES => [['test-serialized-capability-configuration-value']],
            ],
            $serializer->serialize($model)
        );
    }
}
