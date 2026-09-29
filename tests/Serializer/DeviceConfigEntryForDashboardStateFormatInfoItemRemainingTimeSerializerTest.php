<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTime;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTime::class)]
#[CoversClass(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer::class)]
final class DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTime('test-time-format');

        $serializer = new DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer();

        self::assertSame(
            [
                DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializerInterface::KEY_TIME_FORMAT => 'test-time-format',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTime('test-time-format'))
            ->setFrequency(7);

        $serializer = new DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer();

        self::assertSame(
            [
                DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializerInterface::KEY_TIME_FORMAT => 'test-time-format',
                DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializerInterface::KEY_FREQUENCY => 7,
            ],
            $serializer->serialize($model)
        );
    }
}
