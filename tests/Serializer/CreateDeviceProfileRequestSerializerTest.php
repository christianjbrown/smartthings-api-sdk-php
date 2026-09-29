<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CreateDeviceProfileRequest;
use ChristianBrown\SmartThings\Model\DeviceProfileComponentRequestInterface;
use ChristianBrown\SmartThings\Model\PreferenceRequestInterface;
use ChristianBrown\SmartThings\Serializer\CreateDeviceProfileRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CreateDeviceProfileRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceProfileComponentRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PreferenceRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreateDeviceProfileRequest::class)]
#[CoversClass(CreateDeviceProfileRequestSerializer::class)]
final class CreateDeviceProfileRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $components = [['id' => 'main', 'capabilities' => [['id' => 'switch']], 'categories' => [['name' => 'Switch']]]];
        $request = new CreateDeviceProfileRequest('thermostat1.model1', $components);

        $serializer = new CreateDeviceProfileRequestSerializer(self::createStub(DeviceProfileComponentRequestSerializerInterface::class), self::createStub(PreferenceRequestSerializerInterface::class));

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateDeviceProfileRequestSerializerInterface::KEY_NAME => 'thermostat1.model1',
                CreateDeviceProfileRequestSerializerInterface::KEY_COMPONENTS => $components,
            ],
            $actual
        );
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
        $request = (new CreateDeviceProfileRequest('thermostat1.model1', [$component, $rawComponent]))
            ->setPreferences([$preference, $rawPreference]);

        $serializer = new CreateDeviceProfileRequestSerializer($componentSerializer, $preferenceSerializer);

        $actual = $serializer->serialize($request);

        self::assertSame([['test-serialized-component'], $rawComponent], $actual[CreateDeviceProfileRequestSerializerInterface::KEY_COMPONENTS]);
        self::assertSame([['test-serialized-preference'], $rawPreference], $actual[CreateDeviceProfileRequestSerializerInterface::KEY_PREFERENCES]);
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $components = [['id' => 'main', 'capabilities' => [['id' => 'switch']], 'categories' => [['name' => 'Switch']]]];
        $preferences = [['preferenceId' => 'test-pref']];
        $metadata = ['vid' => 'test-vid'];
        $deviceConfig = ['dashboard' => []];

        $request = (new CreateDeviceProfileRequest('thermostat1.model1', $components))
            ->setPreferences($preferences)
            ->setMetadata($metadata)
            ->setDeviceConfig($deviceConfig)
            ->setPresentationId('perfectlife6617.custom-thermostat');

        $serializer = new CreateDeviceProfileRequestSerializer(self::createStub(DeviceProfileComponentRequestSerializerInterface::class), self::createStub(PreferenceRequestSerializerInterface::class));

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateDeviceProfileRequestSerializerInterface::KEY_NAME => 'thermostat1.model1',
                CreateDeviceProfileRequestSerializerInterface::KEY_COMPONENTS => $components,
                CreateDeviceProfileRequestSerializerInterface::KEY_PREFERENCES => $preferences,
                CreateDeviceProfileRequestSerializerInterface::KEY_METADATA => $metadata,
                CreateDeviceProfileRequestSerializerInterface::KEY_DEVICE_CONFIG => $deviceConfig,
                CreateDeviceProfileRequestSerializerInterface::KEY_PRESENTATION_ID => 'perfectlife6617.custom-thermostat',
            ],
            $actual
        );
    }
}
