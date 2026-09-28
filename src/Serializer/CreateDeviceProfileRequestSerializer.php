<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CreateDeviceProfileRequestInterface;

use function array_filter;

final class CreateDeviceProfileRequestSerializer implements CreateDeviceProfileRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(CreateDeviceProfileRequestInterface $request): array
    {
        $serialized = [
            self::KEY_NAME => $request->getName(),
            self::KEY_COMPONENTS => $request->getComponents(),
            self::KEY_PREFERENCES => $request->getPreferences(),
            self::KEY_METADATA => $request->getMetadata(),
            self::KEY_DEVICE_CONFIG => $request->getDeviceConfig(),
            self::KEY_PRESENTATION_ID => $request->getPresentationId(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
