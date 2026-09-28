<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CapabilitySubscriptionDetailInterface;
use ChristianBrown\SmartThings\Model\DeviceHealthDetailInterface;
use ChristianBrown\SmartThings\Model\DeviceLifecycleDetailInterface;
use ChristianBrown\SmartThings\Model\DeviceSubscriptionDetailInterface;
use ChristianBrown\SmartThings\Model\HubHealthDetailInterface;
use ChristianBrown\SmartThings\Model\ModeSubscriptionDetailInterface;
use ChristianBrown\SmartThings\Model\SceneLifecycleDetailInterface;
use ChristianBrown\SmartThings\Model\SecurityArmStateDetailInterface;
use ChristianBrown\SmartThings\Model\SubscriptionRequestInterface;

use function array_filter;

final class SubscriptionRequestSerializer implements SubscriptionRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(SubscriptionRequestInterface $request): array
    {
        return self::filter([
            self::KEY_SOURCE_TYPE => $request->getSourceType(),
            self::KEY_DEVICE => self::serializeOptionalDeviceSubscriptionDetail($request->getDevice()),
            self::KEY_CAPABILITY => self::serializeOptionalCapabilitySubscriptionDetail($request->getCapability()),
            self::KEY_MODE => self::serializeOptionalModeSubscriptionDetail($request->getMode()),
            self::KEY_DEVICE_LIFECYCLE => self::serializeOptionalDeviceLifecycleDetail($request->getDeviceLifecycle()),
            self::KEY_DEVICE_HEALTH => self::serializeOptionalDeviceHealthDetail($request->getDeviceHealth()),
            self::KEY_SECURITY_ARM_STATE => self::serializeOptionalSecurityArmStateDetail($request->getSecurityArmState()),
            self::KEY_HUB_HEALTH => self::serializeOptionalHubHealthDetail($request->getHubHealth()),
            self::KEY_SCENE_LIFECYCLE => self::serializeOptionalSceneLifecycleDetail($request->getSceneLifecycle()),
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
    private static function serializeCapabilitySubscriptionDetail(CapabilitySubscriptionDetailInterface $value): array
    {
        return self::filter([
            self::KEY_LOCATION_ID => $value->getLocationId(),
            self::KEY_CAPABILITY => $value->getCapability(),
            self::KEY_ATTRIBUTE => $value->getAttribute(),
            self::KEY_VALUE => $value->getValue(),
            self::KEY_STATE_CHANGE_ONLY => $value->getStateChangeOnly(),
            self::KEY_SUBSCRIPTION_NAME => $value->getSubscriptionName(),
            self::KEY_MODES => $value->getModes(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeDeviceHealthDetail(DeviceHealthDetailInterface $value): array
    {
        return self::filter([
            self::KEY_DEVICE_IDS => $value->getDeviceIds(),
            self::KEY_SUBSCRIPTION_NAME => $value->getSubscriptionName(),
            self::KEY_LOCATION_ID => $value->getLocationId(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeDeviceLifecycleDetail(DeviceLifecycleDetailInterface $value): array
    {
        return self::filter([
            self::KEY_DEVICE_IDS => $value->getDeviceIds(),
            self::KEY_SUBSCRIPTION_NAME => $value->getSubscriptionName(),
            self::KEY_LOCATION_ID => $value->getLocationId(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeDeviceSubscriptionDetail(DeviceSubscriptionDetailInterface $value): array
    {
        return self::filter([
            self::KEY_DEVICE_ID => $value->getDeviceId(),
            self::KEY_COMPONENT_ID => $value->getComponentId(),
            self::KEY_CAPABILITY => $value->getCapability(),
            self::KEY_ATTRIBUTE => $value->getAttribute(),
            self::KEY_VALUE => $value->getValue(),
            self::KEY_STATE_CHANGE_ONLY => $value->getStateChangeOnly(),
            self::KEY_SUBSCRIPTION_NAME => $value->getSubscriptionName(),
            self::KEY_MODES => $value->getModes(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeHubHealthDetail(HubHealthDetailInterface $value): array
    {
        return self::filter([
            self::KEY_LOCATION_ID => $value->getLocationId(),
            self::KEY_SUBSCRIPTION_NAME => $value->getSubscriptionName(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeModeSubscriptionDetail(ModeSubscriptionDetailInterface $value): array
    {
        return self::filter([
            self::KEY_LOCATION_ID => $value->getLocationId(),
        ]);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalCapabilitySubscriptionDetail(?CapabilitySubscriptionDetailInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeCapabilitySubscriptionDetail($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalDeviceHealthDetail(?DeviceHealthDetailInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeDeviceHealthDetail($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalDeviceLifecycleDetail(?DeviceLifecycleDetailInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeDeviceLifecycleDetail($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalDeviceSubscriptionDetail(?DeviceSubscriptionDetailInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeDeviceSubscriptionDetail($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalHubHealthDetail(?HubHealthDetailInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeHubHealthDetail($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalModeSubscriptionDetail(?ModeSubscriptionDetailInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeModeSubscriptionDetail($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalSceneLifecycleDetail(?SceneLifecycleDetailInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeSceneLifecycleDetail($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalSecurityArmStateDetail(?SecurityArmStateDetailInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeSecurityArmStateDetail($value);
    }

    /**
     * @return mixed[]
     */
    private static function serializeSceneLifecycleDetail(SceneLifecycleDetailInterface $value): array
    {
        return self::filter([
            self::KEY_LOCATION_ID => $value->getLocationId(),
            self::KEY_SUBSCRIPTION_NAME => $value->getSubscriptionName(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeSecurityArmStateDetail(SecurityArmStateDetailInterface $value): array
    {
        return self::filter([
            self::KEY_LOCATION_ID => $value->getLocationId(),
            self::KEY_SUBSCRIPTION_NAME => $value->getSubscriptionName(),
        ]);
    }
}
