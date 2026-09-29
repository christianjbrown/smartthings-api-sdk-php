<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceProfileComponentRequestInterface;
use ChristianBrown\SmartThings\Model\PreferenceRequestInterface;
use ChristianBrown\SmartThings\Model\UpdateDeviceProfileRequest;
use ChristianBrown\SmartThings\Serializer\DeviceProfileComponentRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PreferenceRequestSerializerInterface;
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

        $serializer = new UpdateDeviceProfileRequestSerializer(self::createStub(DeviceProfileComponentRequestSerializerInterface::class), self::createStub(PreferenceRequestSerializerInterface::class));

        self::assertSame([], $serializer->serialize($request));
    }

    public function testSerializeTypedComponentsAndPreferences(): void
    {
        $component = self::createStub(DeviceProfileComponentRequestInterface::class);
        $preference = self::createStub(PreferenceRequestInterface::class);

        $componentSerializer = self::createMock(DeviceProfileComponentRequestSerializerInterface::class);
        $componentSerializer->expects(self::once())->method('serialize')
            ->with($component)
            ->willReturn(['test-serialized-component']);
        $preferenceSerializer = self::createMock(PreferenceRequestSerializerInterface::class);
        $preferenceSerializer->expects(self::once())->method('serialize')
            ->with($preference)
            ->willReturn(['test-serialized-preference']);

        $rawComponent = ['id' => 'raw'];
        $rawPreference = ['preferenceId' => 'raw'];
        $request = (new UpdateDeviceProfileRequest())
            ->setComponents([$component, $rawComponent])
            ->setPreferences([$preference, $rawPreference]);

        $serializer = new UpdateDeviceProfileRequestSerializer($componentSerializer, $preferenceSerializer);

        $actual = $serializer->serialize($request);

        self::assertSame([['test-serialized-component'], $rawComponent], $actual[UpdateDeviceProfileRequestSerializerInterface::KEY_COMPONENTS]);
        self::assertSame([['test-serialized-preference'], $rawPreference], $actual[UpdateDeviceProfileRequestSerializerInterface::KEY_PREFERENCES]);
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

        $serializer = new UpdateDeviceProfileRequestSerializer(self::createStub(DeviceProfileComponentRequestSerializerInterface::class), self::createStub(PreferenceRequestSerializerInterface::class));

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
