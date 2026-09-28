<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\UpdateAppSettingsRequest;
use ChristianBrown\SmartThings\Serializer\UpdateAppSettingsRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateAppSettingsRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UpdateAppSettingsRequest::class)]
#[CoversClass(UpdateAppSettingsRequestSerializer::class)]
final class UpdateAppSettingsRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new UpdateAppSettingsRequest();

        $serializer = new UpdateAppSettingsRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new UpdateAppSettingsRequest())
            ->setSettings(['test-settings-key' => 'test-value']);

        $serializer = new UpdateAppSettingsRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                UpdateAppSettingsRequestSerializerInterface::KEY_SETTINGS => ['test-settings-key' => 'test-value'],
            ],
            $actual
        );
    }
}
