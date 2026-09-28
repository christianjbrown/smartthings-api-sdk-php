<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CapabilitySubscriptionDetail;
use ChristianBrown\SmartThings\Model\DeviceHealthDetail;
use ChristianBrown\SmartThings\Model\DeviceLifecycleDetail;
use ChristianBrown\SmartThings\Model\DeviceSubscriptionDetail;
use ChristianBrown\SmartThings\Model\HubHealthDetail;
use ChristianBrown\SmartThings\Model\ModeSubscriptionDetail;
use ChristianBrown\SmartThings\Model\SceneLifecycleDetail;
use ChristianBrown\SmartThings\Model\SecurityArmStateDetail;
use ChristianBrown\SmartThings\Model\SubscriptionRequest;
use ChristianBrown\SmartThings\Serializer\SubscriptionRequestSerializer;
use ChristianBrown\SmartThings\Serializer\SubscriptionRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilitySubscriptionDetail::class)]
#[CoversClass(DeviceHealthDetail::class)]
#[CoversClass(DeviceLifecycleDetail::class)]
#[CoversClass(DeviceSubscriptionDetail::class)]
#[CoversClass(HubHealthDetail::class)]
#[CoversClass(ModeSubscriptionDetail::class)]
#[CoversClass(SceneLifecycleDetail::class)]
#[CoversClass(SecurityArmStateDetail::class)]
#[CoversClass(SubscriptionRequest::class)]
#[CoversClass(SubscriptionRequestSerializer::class)]
final class SubscriptionRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new SubscriptionRequest('test-source-type');

        $serializer = new SubscriptionRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                SubscriptionRequestSerializerInterface::KEY_SOURCE_TYPE => 'test-source-type',
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new SubscriptionRequest('test-source-type'))
            ->setDevice((new DeviceSubscriptionDetail('test-device-id'))
                ->setComponentId('test-component-id')
                ->setCapability('test-capability')
                ->setAttribute('test-attribute')
                ->setValue('test-value')
                ->setStateChangeOnly(true)
                ->setSubscriptionName('test-subscription-name')
                ->setModes(['test-modes-1', 'test-modes-2']))
            ->setCapability((new CapabilitySubscriptionDetail('test-location-id', 'test-capability'))
                ->setAttribute('test-attribute')
                ->setValue('test-value')
                ->setStateChangeOnly(true)
                ->setSubscriptionName('test-subscription-name')
                ->setModes(['test-modes-1', 'test-modes-2']))
            ->setMode(new ModeSubscriptionDetail('test-location-id'))
            ->setDeviceLifecycle((new DeviceLifecycleDetail())
                ->setDeviceIds(['test-device-ids-1', 'test-device-ids-2'])
                ->setSubscriptionName('test-subscription-name')
                ->setLocationId('test-location-id'))
            ->setDeviceHealth((new DeviceHealthDetail())
                ->setDeviceIds(['test-device-ids-1', 'test-device-ids-2'])
                ->setSubscriptionName('test-subscription-name')
                ->setLocationId('test-location-id'))
            ->setSecurityArmState((new SecurityArmStateDetail('test-location-id'))
                ->setSubscriptionName('test-subscription-name'))
            ->setHubHealth((new HubHealthDetail('test-location-id'))
                ->setSubscriptionName('test-subscription-name'))
            ->setSceneLifecycle((new SceneLifecycleDetail('test-location-id'))
                ->setSubscriptionName('test-subscription-name'));

        $serializer = new SubscriptionRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                SubscriptionRequestSerializerInterface::KEY_SOURCE_TYPE => 'test-source-type',
                SubscriptionRequestSerializerInterface::KEY_DEVICE => [
                    SubscriptionRequestSerializerInterface::KEY_DEVICE_ID => 'test-device-id',
                    SubscriptionRequestSerializerInterface::KEY_COMPONENT_ID => 'test-component-id',
                    SubscriptionRequestSerializerInterface::KEY_CAPABILITY => 'test-capability',
                    SubscriptionRequestSerializerInterface::KEY_ATTRIBUTE => 'test-attribute',
                    SubscriptionRequestSerializerInterface::KEY_VALUE => 'test-value',
                    SubscriptionRequestSerializerInterface::KEY_STATE_CHANGE_ONLY => true,
                    SubscriptionRequestSerializerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name',
                    SubscriptionRequestSerializerInterface::KEY_MODES => ['test-modes-1', 'test-modes-2'],
                ],
                SubscriptionRequestSerializerInterface::KEY_CAPABILITY => [
                    SubscriptionRequestSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                    SubscriptionRequestSerializerInterface::KEY_CAPABILITY => 'test-capability',
                    SubscriptionRequestSerializerInterface::KEY_ATTRIBUTE => 'test-attribute',
                    SubscriptionRequestSerializerInterface::KEY_VALUE => 'test-value',
                    SubscriptionRequestSerializerInterface::KEY_STATE_CHANGE_ONLY => true,
                    SubscriptionRequestSerializerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name',
                    SubscriptionRequestSerializerInterface::KEY_MODES => ['test-modes-1', 'test-modes-2'],
                ],
                SubscriptionRequestSerializerInterface::KEY_MODE => [
                    SubscriptionRequestSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                ],
                SubscriptionRequestSerializerInterface::KEY_DEVICE_LIFECYCLE => [
                    SubscriptionRequestSerializerInterface::KEY_DEVICE_IDS => ['test-device-ids-1', 'test-device-ids-2'],
                    SubscriptionRequestSerializerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name',
                    SubscriptionRequestSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                ],
                SubscriptionRequestSerializerInterface::KEY_DEVICE_HEALTH => [
                    SubscriptionRequestSerializerInterface::KEY_DEVICE_IDS => ['test-device-ids-1', 'test-device-ids-2'],
                    SubscriptionRequestSerializerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name',
                    SubscriptionRequestSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                ],
                SubscriptionRequestSerializerInterface::KEY_SECURITY_ARM_STATE => [
                    SubscriptionRequestSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                    SubscriptionRequestSerializerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name',
                ],
                SubscriptionRequestSerializerInterface::KEY_HUB_HEALTH => [
                    SubscriptionRequestSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                    SubscriptionRequestSerializerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name',
                ],
                SubscriptionRequestSerializerInterface::KEY_SCENE_LIFECYCLE => [
                    SubscriptionRequestSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                    SubscriptionRequestSerializerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name',
                ],
            ],
            $actual
        );
    }

    public function testSerializeWithNestedOptionalsUnset(): void
    {
        $request = (new SubscriptionRequest('test-source-type'))
            ->setDevice(new DeviceSubscriptionDetail('test-device-id'))
            ->setCapability(new CapabilitySubscriptionDetail('test-location-id', 'test-capability'))
            ->setMode(new ModeSubscriptionDetail('test-location-id'))
            ->setDeviceLifecycle(new DeviceLifecycleDetail())
            ->setDeviceHealth(new DeviceHealthDetail())
            ->setSecurityArmState(new SecurityArmStateDetail('test-location-id'))
            ->setHubHealth(new HubHealthDetail('test-location-id'))
            ->setSceneLifecycle(new SceneLifecycleDetail('test-location-id'));

        $serializer = new SubscriptionRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                SubscriptionRequestSerializerInterface::KEY_SOURCE_TYPE => 'test-source-type',
                SubscriptionRequestSerializerInterface::KEY_DEVICE => [
                    SubscriptionRequestSerializerInterface::KEY_DEVICE_ID => 'test-device-id',
                ],
                SubscriptionRequestSerializerInterface::KEY_CAPABILITY => [
                    SubscriptionRequestSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                    SubscriptionRequestSerializerInterface::KEY_CAPABILITY => 'test-capability',
                ],
                SubscriptionRequestSerializerInterface::KEY_MODE => [
                    SubscriptionRequestSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                ],
                SubscriptionRequestSerializerInterface::KEY_DEVICE_LIFECYCLE => [],
                SubscriptionRequestSerializerInterface::KEY_DEVICE_HEALTH => [],
                SubscriptionRequestSerializerInterface::KEY_SECURITY_ARM_STATE => [
                    SubscriptionRequestSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                ],
                SubscriptionRequestSerializerInterface::KEY_HUB_HEALTH => [
                    SubscriptionRequestSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                ],
                SubscriptionRequestSerializerInterface::KEY_SCENE_LIFECYCLE => [
                    SubscriptionRequestSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                ],
            ],
            $actual
        );
    }
}
