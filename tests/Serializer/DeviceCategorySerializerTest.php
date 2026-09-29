<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceCategory;
use ChristianBrown\SmartThings\Serializer\DeviceCategorySerializer;
use ChristianBrown\SmartThings\Serializer\DeviceCategorySerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceCategory::class)]
#[CoversClass(DeviceCategorySerializer::class)]
final class DeviceCategorySerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new DeviceCategory('test-name', 'test-category-type');

        $serializer = new DeviceCategorySerializer();

        self::assertSame(
            [
                DeviceCategorySerializerInterface::KEY_NAME => 'test-name',
                DeviceCategorySerializerInterface::KEY_CATEGORY_TYPE => 'test-category-type',
            ],
            $serializer->serialize($model)
        );
    }
}
