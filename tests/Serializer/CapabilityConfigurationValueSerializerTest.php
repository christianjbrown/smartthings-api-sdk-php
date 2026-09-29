<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityConfigurationValue;
use ChristianBrown\SmartThings\Serializer\CapabilityConfigurationValueSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityConfigurationValueSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityConfigurationValue::class)]
#[CoversClass(CapabilityConfigurationValueSerializer::class)]
final class CapabilityConfigurationValueSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new CapabilityConfigurationValue('test-key');

        $serializer = new CapabilityConfigurationValueSerializer();

        self::assertSame(
            [
                CapabilityConfigurationValueSerializerInterface::KEY_KEY => 'test-key',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new CapabilityConfigurationValue('test-key'))
            ->setRange(['test-range-key' => 'test-value'])
            ->setEnabledValues(['test-enabled-values-1', 'test-enabled-values-2'])
            ->setStep(1.5);

        $serializer = new CapabilityConfigurationValueSerializer();

        self::assertSame(
            [
                CapabilityConfigurationValueSerializerInterface::KEY_KEY => 'test-key',
                CapabilityConfigurationValueSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                CapabilityConfigurationValueSerializerInterface::KEY_ENABLED_VALUES => ['test-enabled-values-1', 'test-enabled-values-2'],
                CapabilityConfigurationValueSerializerInterface::KEY_STEP => 1.5,
            ],
            $serializer->serialize($model)
        );
    }
}
