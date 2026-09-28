<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\UpdateDeviceProfileRequest;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceProfileRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceProfileRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UpdateDeviceProfileRequest::class)]
#[CoversClass(UpdateDeviceProfileRequestSerializer::class)]
final class UpdateDeviceProfileRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new UpdateDeviceProfileRequest();

        $serializer = new UpdateDeviceProfileRequestSerializer();

        self::assertSame([], $serializer->serialize($request));
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $components = [['id' => 'main', 'capabilities' => [['id' => 'switch']]]];
        $preferences = [['preferenceId' => 'test-pref']];
        $metadata = ['vid' => 'test-vid'];

        $request = (new UpdateDeviceProfileRequest())
            ->setComponents($components)
            ->setPreferences($preferences)
            ->setMetadata($metadata)
            ->setPresentationId('perfectlife6617.custom-thermostat');

        $serializer = new UpdateDeviceProfileRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                UpdateDeviceProfileRequestSerializerInterface::KEY_COMPONENTS => $components,
                UpdateDeviceProfileRequestSerializerInterface::KEY_PREFERENCES => $preferences,
                UpdateDeviceProfileRequestSerializerInterface::KEY_METADATA => $metadata,
                UpdateDeviceProfileRequestSerializerInterface::KEY_PRESENTATION_ID => 'perfectlife6617.custom-thermostat',
            ],
            $actual
        );
    }
}
