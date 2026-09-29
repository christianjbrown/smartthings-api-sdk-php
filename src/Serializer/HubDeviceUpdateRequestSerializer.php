<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceIntegrationProfileKeyInterface;
use ChristianBrown\SmartThings\Model\HubDeviceUpdateRequestInterface;

use function array_filter;

final class HubDeviceUpdateRequestSerializer implements HubDeviceUpdateRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(HubDeviceUpdateRequestInterface $request): array
    {
        return self::filter([
            self::KEY_DRIVER_ID => $request->getDriverId(),
            self::KEY_DEVICE_INTEGRATION_PROFILE_KEY => self::serializeOptionalDeviceIntegrationProfileKey($request->getDeviceIntegrationProfileKey()),
            self::KEY_PROVISIONING_STATE => $request->getProvisioningState(),
        ]);
    }

    /**
     * Omits null optionals rather than sending them as explicit nulls.
     *
     * @param mixed[] $serialized
     *
     * @return mixed[]
     */
    private static function filter(array $serialized): array
    {
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return mixed[]
     */
    private static function serializeDeviceIntegrationProfileKey(DeviceIntegrationProfileKeyInterface $value): array
    {
        return self::filter([
            self::KEY_ID => $value->getId(),
            self::KEY_MAJOR_VERSION => $value->getMajorVersion(),
        ]);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalDeviceIntegrationProfileKey(?DeviceIntegrationProfileKeyInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeDeviceIntegrationProfileKey($value);
    }
}
