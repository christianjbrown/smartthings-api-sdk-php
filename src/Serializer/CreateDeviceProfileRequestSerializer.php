<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CreateDeviceProfileRequestInterface;
use ChristianBrown\SmartThings\Model\DeviceProfileComponentRequestInterface;
use ChristianBrown\SmartThings\Model\PreferenceRequestInterface;

use function array_filter;
use function array_map;

final class CreateDeviceProfileRequestSerializer implements CreateDeviceProfileRequestSerializerInterface
{
    private DeviceProfileComponentRequestSerializerInterface $componentSerializer;
    private PreferenceRequestSerializerInterface $preferenceSerializer;

    public function __construct(DeviceProfileComponentRequestSerializerInterface $componentSerializer, PreferenceRequestSerializerInterface $preferenceSerializer)
    {
        $this->componentSerializer = $componentSerializer;
        $this->preferenceSerializer = $preferenceSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(CreateDeviceProfileRequestInterface $request): array
    {
        $serialized = [
            self::KEY_NAME => $request->getName(),
            self::KEY_COMPONENTS => $this->serializeComponents($request->getComponents()),
            self::KEY_PREFERENCES => $this->serializePreferences($request->getPreferences()),
            self::KEY_METADATA => $request->getMetadata(),
            self::KEY_DEVICE_CONFIG => $request->getDeviceConfig(),
            self::KEY_PRESENTATION_ID => $request->getPresentationId(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * Typed components are serialized; raw arrays pass through unmodified.
     *
     * @param array<int, DeviceProfileComponentRequestInterface|mixed[]> $components
     *
     * @return array<int, mixed>
     */
    private function serializeComponents(array $components): array
    {
        $serializer = $this->componentSerializer;

        return array_map(static fn (mixed $component): mixed => $component instanceof DeviceProfileComponentRequestInterface ? $serializer->serialize($component) : $component, $components);
    }

    /**
     * @param null|array<int, mixed[]|PreferenceRequestInterface> $preferences
     *
     * @return null|array<int, mixed>
     */
    private function serializePreferences(?array $preferences): ?array
    {
        if (null === $preferences) {
            return null;
        }
        $serializer = $this->preferenceSerializer;

        return array_map(static fn (mixed $preference): mixed => $preference instanceof PreferenceRequestInterface ? $serializer->serialize($preference) : $preference, $preferences);
    }
}
