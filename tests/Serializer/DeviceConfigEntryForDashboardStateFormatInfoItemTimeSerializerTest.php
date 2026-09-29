<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemTime;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateFormatInfoItemTimeSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigEntryForDashboardStateFormatInfoItemTime::class)]
#[CoversClass(DeviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer::class)]
final class DeviceConfigEntryForDashboardStateFormatInfoItemTimeSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new DeviceConfigEntryForDashboardStateFormatInfoItemTime('test-time-format');

        $serializer = new DeviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer();

        self::assertSame(
            [
                DeviceConfigEntryForDashboardStateFormatInfoItemTimeSerializerInterface::KEY_TIME_FORMAT => 'test-time-format',
            ],
            $serializer->serialize($model)
        );
    }
}
