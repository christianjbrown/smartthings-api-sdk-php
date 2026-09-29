<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CapabilitySubscriptionDetailInterface;
use ChristianBrown\SmartThings\Model\DeviceHealthDetailInterface;
use ChristianBrown\SmartThings\Model\DeviceLifecycleDetailInterface;
use ChristianBrown\SmartThings\Model\DeviceSubscriptionDetailInterface;
use ChristianBrown\SmartThings\Model\HubHealthDetailInterface;
use ChristianBrown\SmartThings\Model\ModeSubscriptionDetailInterface;
use ChristianBrown\SmartThings\Model\SceneLifecycleDetailInterface;
use ChristianBrown\SmartThings\Model\SecurityArmStateDetailInterface;
use ChristianBrown\SmartThings\Model\SubscriptionDetails;
use ChristianBrown\SmartThings\Transformer\CapabilitySubscriptionDetailTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceHealthDetailTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceLifecycleDetailTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceSubscriptionDetailTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubHealthDetailTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ModeSubscriptionDetailTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SceneLifecycleDetailTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SecurityArmStateDetailTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SubscriptionDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\SubscriptionDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SubscriptionDetails::class)]
#[CoversClass(SubscriptionDetailsTransformer::class)]
final class SubscriptionDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $deviceSubscriptionDetailModel = self::createStub(DeviceSubscriptionDetailInterface::class);
        $deviceSubscriptionDetailTransformer = self::createStub(DeviceSubscriptionDetailTransformerInterface::class);
        $deviceSubscriptionDetailTransformer->method('transform')->willReturn($deviceSubscriptionDetailModel);
        $capabilitySubscriptionDetailModel = self::createStub(CapabilitySubscriptionDetailInterface::class);
        $capabilitySubscriptionDetailTransformer = self::createStub(CapabilitySubscriptionDetailTransformerInterface::class);
        $capabilitySubscriptionDetailTransformer->method('transform')->willReturn($capabilitySubscriptionDetailModel);
        $modeSubscriptionDetailModel = self::createStub(ModeSubscriptionDetailInterface::class);
        $modeSubscriptionDetailTransformer = self::createStub(ModeSubscriptionDetailTransformerInterface::class);
        $modeSubscriptionDetailTransformer->method('transform')->willReturn($modeSubscriptionDetailModel);
        $deviceLifecycleDetailModel = self::createStub(DeviceLifecycleDetailInterface::class);
        $deviceLifecycleDetailTransformer = self::createStub(DeviceLifecycleDetailTransformerInterface::class);
        $deviceLifecycleDetailTransformer->method('transform')->willReturn($deviceLifecycleDetailModel);
        $deviceHealthDetailModel = self::createStub(DeviceHealthDetailInterface::class);
        $deviceHealthDetailTransformer = self::createStub(DeviceHealthDetailTransformerInterface::class);
        $deviceHealthDetailTransformer->method('transform')->willReturn($deviceHealthDetailModel);
        $securityArmStateDetailModel = self::createStub(SecurityArmStateDetailInterface::class);
        $securityArmStateDetailTransformer = self::createStub(SecurityArmStateDetailTransformerInterface::class);
        $securityArmStateDetailTransformer->method('transform')->willReturn($securityArmStateDetailModel);
        $hubHealthDetailModel = self::createStub(HubHealthDetailInterface::class);
        $hubHealthDetailTransformer = self::createStub(HubHealthDetailTransformerInterface::class);
        $hubHealthDetailTransformer->method('transform')->willReturn($hubHealthDetailModel);
        $sceneLifecycleDetailModel = self::createStub(SceneLifecycleDetailInterface::class);
        $sceneLifecycleDetailTransformer = self::createStub(SceneLifecycleDetailTransformerInterface::class);
        $sceneLifecycleDetailTransformer->method('transform')->willReturn($sceneLifecycleDetailModel);
        $data = [
            SubscriptionDetailsTransformerInterface::KEY_DEVICE => ['test-nested'],
            SubscriptionDetailsTransformerInterface::KEY_CAPABILITY => ['test-nested'],
            SubscriptionDetailsTransformerInterface::KEY_MODE => ['test-nested'],
            SubscriptionDetailsTransformerInterface::KEY_DEVICE_LIFECYCLE => ['test-nested'],
            SubscriptionDetailsTransformerInterface::KEY_DEVICE_HEALTH => ['test-nested'],
            SubscriptionDetailsTransformerInterface::KEY_SECURITY_ARM_STATE => ['test-nested'],
            SubscriptionDetailsTransformerInterface::KEY_HUB_HEALTH => ['test-nested'],
            SubscriptionDetailsTransformerInterface::KEY_SCENE_LIFECYCLE => ['test-nested'],
        ];

        $transformer = new SubscriptionDetailsTransformer($deviceSubscriptionDetailTransformer, $capabilitySubscriptionDetailTransformer, $modeSubscriptionDetailTransformer, $deviceLifecycleDetailTransformer, $deviceHealthDetailTransformer, $securityArmStateDetailTransformer, $hubHealthDetailTransformer, $sceneLifecycleDetailTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($deviceSubscriptionDetailModel, $actual->getDevice());
        self::assertSame($capabilitySubscriptionDetailModel, $actual->getCapability());
        self::assertSame($modeSubscriptionDetailModel, $actual->getMode());
        self::assertSame($deviceLifecycleDetailModel, $actual->getDeviceLifecycle());
        self::assertSame($deviceHealthDetailModel, $actual->getDeviceHealth());
        self::assertSame($securityArmStateDetailModel, $actual->getSecurityArmState());
        self::assertSame($hubHealthDetailModel, $actual->getHubHealth());
        self::assertSame($sceneLifecycleDetailModel, $actual->getSceneLifecycle());
    }

    public function testTransformCapability(): void
    {
        $deviceSubscriptionDetailModel = self::createStub(DeviceSubscriptionDetailInterface::class);
        $deviceSubscriptionDetailTransformer = self::createStub(DeviceSubscriptionDetailTransformerInterface::class);
        $deviceSubscriptionDetailTransformer->method('transform')->willReturn($deviceSubscriptionDetailModel);
        $capabilitySubscriptionDetailModel = self::createStub(CapabilitySubscriptionDetailInterface::class);
        $capabilitySubscriptionDetailTransformer = self::createStub(CapabilitySubscriptionDetailTransformerInterface::class);
        $capabilitySubscriptionDetailTransformer->method('transform')->willReturn($capabilitySubscriptionDetailModel);
        $modeSubscriptionDetailModel = self::createStub(ModeSubscriptionDetailInterface::class);
        $modeSubscriptionDetailTransformer = self::createStub(ModeSubscriptionDetailTransformerInterface::class);
        $modeSubscriptionDetailTransformer->method('transform')->willReturn($modeSubscriptionDetailModel);
        $deviceLifecycleDetailModel = self::createStub(DeviceLifecycleDetailInterface::class);
        $deviceLifecycleDetailTransformer = self::createStub(DeviceLifecycleDetailTransformerInterface::class);
        $deviceLifecycleDetailTransformer->method('transform')->willReturn($deviceLifecycleDetailModel);
        $deviceHealthDetailModel = self::createStub(DeviceHealthDetailInterface::class);
        $deviceHealthDetailTransformer = self::createStub(DeviceHealthDetailTransformerInterface::class);
        $deviceHealthDetailTransformer->method('transform')->willReturn($deviceHealthDetailModel);
        $securityArmStateDetailModel = self::createStub(SecurityArmStateDetailInterface::class);
        $securityArmStateDetailTransformer = self::createStub(SecurityArmStateDetailTransformerInterface::class);
        $securityArmStateDetailTransformer->method('transform')->willReturn($securityArmStateDetailModel);
        $hubHealthDetailModel = self::createStub(HubHealthDetailInterface::class);
        $hubHealthDetailTransformer = self::createStub(HubHealthDetailTransformerInterface::class);
        $hubHealthDetailTransformer->method('transform')->willReturn($hubHealthDetailModel);
        $sceneLifecycleDetailModel = self::createStub(SceneLifecycleDetailInterface::class);
        $sceneLifecycleDetailTransformer = self::createStub(SceneLifecycleDetailTransformerInterface::class);
        $sceneLifecycleDetailTransformer->method('transform')->willReturn($sceneLifecycleDetailModel);
        $transformer = new SubscriptionDetailsTransformer($deviceSubscriptionDetailTransformer, $capabilitySubscriptionDetailTransformer, $modeSubscriptionDetailTransformer, $deviceLifecycleDetailTransformer, $deviceHealthDetailTransformer, $securityArmStateDetailTransformer, $hubHealthDetailTransformer, $sceneLifecycleDetailTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getCapability());
        self::assertNull($transformer->transform($base + [SubscriptionDetailsTransformerInterface::KEY_CAPABILITY => 'test-not-array'])->getCapability());
        self::assertSame($capabilitySubscriptionDetailModel, $transformer->transform($base + [SubscriptionDetailsTransformerInterface::KEY_CAPABILITY => ['test-nested']])->getCapability());
    }

    public function testTransformDevice(): void
    {
        $deviceSubscriptionDetailModel = self::createStub(DeviceSubscriptionDetailInterface::class);
        $deviceSubscriptionDetailTransformer = self::createStub(DeviceSubscriptionDetailTransformerInterface::class);
        $deviceSubscriptionDetailTransformer->method('transform')->willReturn($deviceSubscriptionDetailModel);
        $capabilitySubscriptionDetailModel = self::createStub(CapabilitySubscriptionDetailInterface::class);
        $capabilitySubscriptionDetailTransformer = self::createStub(CapabilitySubscriptionDetailTransformerInterface::class);
        $capabilitySubscriptionDetailTransformer->method('transform')->willReturn($capabilitySubscriptionDetailModel);
        $modeSubscriptionDetailModel = self::createStub(ModeSubscriptionDetailInterface::class);
        $modeSubscriptionDetailTransformer = self::createStub(ModeSubscriptionDetailTransformerInterface::class);
        $modeSubscriptionDetailTransformer->method('transform')->willReturn($modeSubscriptionDetailModel);
        $deviceLifecycleDetailModel = self::createStub(DeviceLifecycleDetailInterface::class);
        $deviceLifecycleDetailTransformer = self::createStub(DeviceLifecycleDetailTransformerInterface::class);
        $deviceLifecycleDetailTransformer->method('transform')->willReturn($deviceLifecycleDetailModel);
        $deviceHealthDetailModel = self::createStub(DeviceHealthDetailInterface::class);
        $deviceHealthDetailTransformer = self::createStub(DeviceHealthDetailTransformerInterface::class);
        $deviceHealthDetailTransformer->method('transform')->willReturn($deviceHealthDetailModel);
        $securityArmStateDetailModel = self::createStub(SecurityArmStateDetailInterface::class);
        $securityArmStateDetailTransformer = self::createStub(SecurityArmStateDetailTransformerInterface::class);
        $securityArmStateDetailTransformer->method('transform')->willReturn($securityArmStateDetailModel);
        $hubHealthDetailModel = self::createStub(HubHealthDetailInterface::class);
        $hubHealthDetailTransformer = self::createStub(HubHealthDetailTransformerInterface::class);
        $hubHealthDetailTransformer->method('transform')->willReturn($hubHealthDetailModel);
        $sceneLifecycleDetailModel = self::createStub(SceneLifecycleDetailInterface::class);
        $sceneLifecycleDetailTransformer = self::createStub(SceneLifecycleDetailTransformerInterface::class);
        $sceneLifecycleDetailTransformer->method('transform')->willReturn($sceneLifecycleDetailModel);
        $transformer = new SubscriptionDetailsTransformer($deviceSubscriptionDetailTransformer, $capabilitySubscriptionDetailTransformer, $modeSubscriptionDetailTransformer, $deviceLifecycleDetailTransformer, $deviceHealthDetailTransformer, $securityArmStateDetailTransformer, $hubHealthDetailTransformer, $sceneLifecycleDetailTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getDevice());
        self::assertNull($transformer->transform($base + [SubscriptionDetailsTransformerInterface::KEY_DEVICE => 'test-not-array'])->getDevice());
        self::assertSame($deviceSubscriptionDetailModel, $transformer->transform($base + [SubscriptionDetailsTransformerInterface::KEY_DEVICE => ['test-nested']])->getDevice());
    }

    public function testTransformDeviceHealth(): void
    {
        $deviceSubscriptionDetailModel = self::createStub(DeviceSubscriptionDetailInterface::class);
        $deviceSubscriptionDetailTransformer = self::createStub(DeviceSubscriptionDetailTransformerInterface::class);
        $deviceSubscriptionDetailTransformer->method('transform')->willReturn($deviceSubscriptionDetailModel);
        $capabilitySubscriptionDetailModel = self::createStub(CapabilitySubscriptionDetailInterface::class);
        $capabilitySubscriptionDetailTransformer = self::createStub(CapabilitySubscriptionDetailTransformerInterface::class);
        $capabilitySubscriptionDetailTransformer->method('transform')->willReturn($capabilitySubscriptionDetailModel);
        $modeSubscriptionDetailModel = self::createStub(ModeSubscriptionDetailInterface::class);
        $modeSubscriptionDetailTransformer = self::createStub(ModeSubscriptionDetailTransformerInterface::class);
        $modeSubscriptionDetailTransformer->method('transform')->willReturn($modeSubscriptionDetailModel);
        $deviceLifecycleDetailModel = self::createStub(DeviceLifecycleDetailInterface::class);
        $deviceLifecycleDetailTransformer = self::createStub(DeviceLifecycleDetailTransformerInterface::class);
        $deviceLifecycleDetailTransformer->method('transform')->willReturn($deviceLifecycleDetailModel);
        $deviceHealthDetailModel = self::createStub(DeviceHealthDetailInterface::class);
        $deviceHealthDetailTransformer = self::createStub(DeviceHealthDetailTransformerInterface::class);
        $deviceHealthDetailTransformer->method('transform')->willReturn($deviceHealthDetailModel);
        $securityArmStateDetailModel = self::createStub(SecurityArmStateDetailInterface::class);
        $securityArmStateDetailTransformer = self::createStub(SecurityArmStateDetailTransformerInterface::class);
        $securityArmStateDetailTransformer->method('transform')->willReturn($securityArmStateDetailModel);
        $hubHealthDetailModel = self::createStub(HubHealthDetailInterface::class);
        $hubHealthDetailTransformer = self::createStub(HubHealthDetailTransformerInterface::class);
        $hubHealthDetailTransformer->method('transform')->willReturn($hubHealthDetailModel);
        $sceneLifecycleDetailModel = self::createStub(SceneLifecycleDetailInterface::class);
        $sceneLifecycleDetailTransformer = self::createStub(SceneLifecycleDetailTransformerInterface::class);
        $sceneLifecycleDetailTransformer->method('transform')->willReturn($sceneLifecycleDetailModel);
        $transformer = new SubscriptionDetailsTransformer($deviceSubscriptionDetailTransformer, $capabilitySubscriptionDetailTransformer, $modeSubscriptionDetailTransformer, $deviceLifecycleDetailTransformer, $deviceHealthDetailTransformer, $securityArmStateDetailTransformer, $hubHealthDetailTransformer, $sceneLifecycleDetailTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getDeviceHealth());
        self::assertNull($transformer->transform($base + [SubscriptionDetailsTransformerInterface::KEY_DEVICE_HEALTH => 'test-not-array'])->getDeviceHealth());
        self::assertSame($deviceHealthDetailModel, $transformer->transform($base + [SubscriptionDetailsTransformerInterface::KEY_DEVICE_HEALTH => ['test-nested']])->getDeviceHealth());
    }

    public function testTransformDeviceLifecycle(): void
    {
        $deviceSubscriptionDetailModel = self::createStub(DeviceSubscriptionDetailInterface::class);
        $deviceSubscriptionDetailTransformer = self::createStub(DeviceSubscriptionDetailTransformerInterface::class);
        $deviceSubscriptionDetailTransformer->method('transform')->willReturn($deviceSubscriptionDetailModel);
        $capabilitySubscriptionDetailModel = self::createStub(CapabilitySubscriptionDetailInterface::class);
        $capabilitySubscriptionDetailTransformer = self::createStub(CapabilitySubscriptionDetailTransformerInterface::class);
        $capabilitySubscriptionDetailTransformer->method('transform')->willReturn($capabilitySubscriptionDetailModel);
        $modeSubscriptionDetailModel = self::createStub(ModeSubscriptionDetailInterface::class);
        $modeSubscriptionDetailTransformer = self::createStub(ModeSubscriptionDetailTransformerInterface::class);
        $modeSubscriptionDetailTransformer->method('transform')->willReturn($modeSubscriptionDetailModel);
        $deviceLifecycleDetailModel = self::createStub(DeviceLifecycleDetailInterface::class);
        $deviceLifecycleDetailTransformer = self::createStub(DeviceLifecycleDetailTransformerInterface::class);
        $deviceLifecycleDetailTransformer->method('transform')->willReturn($deviceLifecycleDetailModel);
        $deviceHealthDetailModel = self::createStub(DeviceHealthDetailInterface::class);
        $deviceHealthDetailTransformer = self::createStub(DeviceHealthDetailTransformerInterface::class);
        $deviceHealthDetailTransformer->method('transform')->willReturn($deviceHealthDetailModel);
        $securityArmStateDetailModel = self::createStub(SecurityArmStateDetailInterface::class);
        $securityArmStateDetailTransformer = self::createStub(SecurityArmStateDetailTransformerInterface::class);
        $securityArmStateDetailTransformer->method('transform')->willReturn($securityArmStateDetailModel);
        $hubHealthDetailModel = self::createStub(HubHealthDetailInterface::class);
        $hubHealthDetailTransformer = self::createStub(HubHealthDetailTransformerInterface::class);
        $hubHealthDetailTransformer->method('transform')->willReturn($hubHealthDetailModel);
        $sceneLifecycleDetailModel = self::createStub(SceneLifecycleDetailInterface::class);
        $sceneLifecycleDetailTransformer = self::createStub(SceneLifecycleDetailTransformerInterface::class);
        $sceneLifecycleDetailTransformer->method('transform')->willReturn($sceneLifecycleDetailModel);
        $transformer = new SubscriptionDetailsTransformer($deviceSubscriptionDetailTransformer, $capabilitySubscriptionDetailTransformer, $modeSubscriptionDetailTransformer, $deviceLifecycleDetailTransformer, $deviceHealthDetailTransformer, $securityArmStateDetailTransformer, $hubHealthDetailTransformer, $sceneLifecycleDetailTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getDeviceLifecycle());
        self::assertNull($transformer->transform($base + [SubscriptionDetailsTransformerInterface::KEY_DEVICE_LIFECYCLE => 'test-not-array'])->getDeviceLifecycle());
        self::assertSame($deviceLifecycleDetailModel, $transformer->transform($base + [SubscriptionDetailsTransformerInterface::KEY_DEVICE_LIFECYCLE => ['test-nested']])->getDeviceLifecycle());
    }

    public function testTransformHubHealth(): void
    {
        $deviceSubscriptionDetailModel = self::createStub(DeviceSubscriptionDetailInterface::class);
        $deviceSubscriptionDetailTransformer = self::createStub(DeviceSubscriptionDetailTransformerInterface::class);
        $deviceSubscriptionDetailTransformer->method('transform')->willReturn($deviceSubscriptionDetailModel);
        $capabilitySubscriptionDetailModel = self::createStub(CapabilitySubscriptionDetailInterface::class);
        $capabilitySubscriptionDetailTransformer = self::createStub(CapabilitySubscriptionDetailTransformerInterface::class);
        $capabilitySubscriptionDetailTransformer->method('transform')->willReturn($capabilitySubscriptionDetailModel);
        $modeSubscriptionDetailModel = self::createStub(ModeSubscriptionDetailInterface::class);
        $modeSubscriptionDetailTransformer = self::createStub(ModeSubscriptionDetailTransformerInterface::class);
        $modeSubscriptionDetailTransformer->method('transform')->willReturn($modeSubscriptionDetailModel);
        $deviceLifecycleDetailModel = self::createStub(DeviceLifecycleDetailInterface::class);
        $deviceLifecycleDetailTransformer = self::createStub(DeviceLifecycleDetailTransformerInterface::class);
        $deviceLifecycleDetailTransformer->method('transform')->willReturn($deviceLifecycleDetailModel);
        $deviceHealthDetailModel = self::createStub(DeviceHealthDetailInterface::class);
        $deviceHealthDetailTransformer = self::createStub(DeviceHealthDetailTransformerInterface::class);
        $deviceHealthDetailTransformer->method('transform')->willReturn($deviceHealthDetailModel);
        $securityArmStateDetailModel = self::createStub(SecurityArmStateDetailInterface::class);
        $securityArmStateDetailTransformer = self::createStub(SecurityArmStateDetailTransformerInterface::class);
        $securityArmStateDetailTransformer->method('transform')->willReturn($securityArmStateDetailModel);
        $hubHealthDetailModel = self::createStub(HubHealthDetailInterface::class);
        $hubHealthDetailTransformer = self::createStub(HubHealthDetailTransformerInterface::class);
        $hubHealthDetailTransformer->method('transform')->willReturn($hubHealthDetailModel);
        $sceneLifecycleDetailModel = self::createStub(SceneLifecycleDetailInterface::class);
        $sceneLifecycleDetailTransformer = self::createStub(SceneLifecycleDetailTransformerInterface::class);
        $sceneLifecycleDetailTransformer->method('transform')->willReturn($sceneLifecycleDetailModel);
        $transformer = new SubscriptionDetailsTransformer($deviceSubscriptionDetailTransformer, $capabilitySubscriptionDetailTransformer, $modeSubscriptionDetailTransformer, $deviceLifecycleDetailTransformer, $deviceHealthDetailTransformer, $securityArmStateDetailTransformer, $hubHealthDetailTransformer, $sceneLifecycleDetailTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getHubHealth());
        self::assertNull($transformer->transform($base + [SubscriptionDetailsTransformerInterface::KEY_HUB_HEALTH => 'test-not-array'])->getHubHealth());
        self::assertSame($hubHealthDetailModel, $transformer->transform($base + [SubscriptionDetailsTransformerInterface::KEY_HUB_HEALTH => ['test-nested']])->getHubHealth());
    }

    public function testTransformMode(): void
    {
        $deviceSubscriptionDetailModel = self::createStub(DeviceSubscriptionDetailInterface::class);
        $deviceSubscriptionDetailTransformer = self::createStub(DeviceSubscriptionDetailTransformerInterface::class);
        $deviceSubscriptionDetailTransformer->method('transform')->willReturn($deviceSubscriptionDetailModel);
        $capabilitySubscriptionDetailModel = self::createStub(CapabilitySubscriptionDetailInterface::class);
        $capabilitySubscriptionDetailTransformer = self::createStub(CapabilitySubscriptionDetailTransformerInterface::class);
        $capabilitySubscriptionDetailTransformer->method('transform')->willReturn($capabilitySubscriptionDetailModel);
        $modeSubscriptionDetailModel = self::createStub(ModeSubscriptionDetailInterface::class);
        $modeSubscriptionDetailTransformer = self::createStub(ModeSubscriptionDetailTransformerInterface::class);
        $modeSubscriptionDetailTransformer->method('transform')->willReturn($modeSubscriptionDetailModel);
        $deviceLifecycleDetailModel = self::createStub(DeviceLifecycleDetailInterface::class);
        $deviceLifecycleDetailTransformer = self::createStub(DeviceLifecycleDetailTransformerInterface::class);
        $deviceLifecycleDetailTransformer->method('transform')->willReturn($deviceLifecycleDetailModel);
        $deviceHealthDetailModel = self::createStub(DeviceHealthDetailInterface::class);
        $deviceHealthDetailTransformer = self::createStub(DeviceHealthDetailTransformerInterface::class);
        $deviceHealthDetailTransformer->method('transform')->willReturn($deviceHealthDetailModel);
        $securityArmStateDetailModel = self::createStub(SecurityArmStateDetailInterface::class);
        $securityArmStateDetailTransformer = self::createStub(SecurityArmStateDetailTransformerInterface::class);
        $securityArmStateDetailTransformer->method('transform')->willReturn($securityArmStateDetailModel);
        $hubHealthDetailModel = self::createStub(HubHealthDetailInterface::class);
        $hubHealthDetailTransformer = self::createStub(HubHealthDetailTransformerInterface::class);
        $hubHealthDetailTransformer->method('transform')->willReturn($hubHealthDetailModel);
        $sceneLifecycleDetailModel = self::createStub(SceneLifecycleDetailInterface::class);
        $sceneLifecycleDetailTransformer = self::createStub(SceneLifecycleDetailTransformerInterface::class);
        $sceneLifecycleDetailTransformer->method('transform')->willReturn($sceneLifecycleDetailModel);
        $transformer = new SubscriptionDetailsTransformer($deviceSubscriptionDetailTransformer, $capabilitySubscriptionDetailTransformer, $modeSubscriptionDetailTransformer, $deviceLifecycleDetailTransformer, $deviceHealthDetailTransformer, $securityArmStateDetailTransformer, $hubHealthDetailTransformer, $sceneLifecycleDetailTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getMode());
        self::assertNull($transformer->transform($base + [SubscriptionDetailsTransformerInterface::KEY_MODE => 'test-not-array'])->getMode());
        self::assertSame($modeSubscriptionDetailModel, $transformer->transform($base + [SubscriptionDetailsTransformerInterface::KEY_MODE => ['test-nested']])->getMode());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $deviceSubscriptionDetailModel = self::createStub(DeviceSubscriptionDetailInterface::class);
        $deviceSubscriptionDetailTransformer = self::createStub(DeviceSubscriptionDetailTransformerInterface::class);
        $deviceSubscriptionDetailTransformer->method('transform')->willReturn($deviceSubscriptionDetailModel);
        $capabilitySubscriptionDetailModel = self::createStub(CapabilitySubscriptionDetailInterface::class);
        $capabilitySubscriptionDetailTransformer = self::createStub(CapabilitySubscriptionDetailTransformerInterface::class);
        $capabilitySubscriptionDetailTransformer->method('transform')->willReturn($capabilitySubscriptionDetailModel);
        $modeSubscriptionDetailModel = self::createStub(ModeSubscriptionDetailInterface::class);
        $modeSubscriptionDetailTransformer = self::createStub(ModeSubscriptionDetailTransformerInterface::class);
        $modeSubscriptionDetailTransformer->method('transform')->willReturn($modeSubscriptionDetailModel);
        $deviceLifecycleDetailModel = self::createStub(DeviceLifecycleDetailInterface::class);
        $deviceLifecycleDetailTransformer = self::createStub(DeviceLifecycleDetailTransformerInterface::class);
        $deviceLifecycleDetailTransformer->method('transform')->willReturn($deviceLifecycleDetailModel);
        $deviceHealthDetailModel = self::createStub(DeviceHealthDetailInterface::class);
        $deviceHealthDetailTransformer = self::createStub(DeviceHealthDetailTransformerInterface::class);
        $deviceHealthDetailTransformer->method('transform')->willReturn($deviceHealthDetailModel);
        $securityArmStateDetailModel = self::createStub(SecurityArmStateDetailInterface::class);
        $securityArmStateDetailTransformer = self::createStub(SecurityArmStateDetailTransformerInterface::class);
        $securityArmStateDetailTransformer->method('transform')->willReturn($securityArmStateDetailModel);
        $hubHealthDetailModel = self::createStub(HubHealthDetailInterface::class);
        $hubHealthDetailTransformer = self::createStub(HubHealthDetailTransformerInterface::class);
        $hubHealthDetailTransformer->method('transform')->willReturn($hubHealthDetailModel);
        $sceneLifecycleDetailModel = self::createStub(SceneLifecycleDetailInterface::class);
        $sceneLifecycleDetailTransformer = self::createStub(SceneLifecycleDetailTransformerInterface::class);
        $sceneLifecycleDetailTransformer->method('transform')->willReturn($sceneLifecycleDetailModel);
        $transformer = new SubscriptionDetailsTransformer($deviceSubscriptionDetailTransformer, $capabilitySubscriptionDetailTransformer, $modeSubscriptionDetailTransformer, $deviceLifecycleDetailTransformer, $deviceHealthDetailTransformer, $securityArmStateDetailTransformer, $hubHealthDetailTransformer, $sceneLifecycleDetailTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getDevice());
        self::assertNull($actual->getCapability());
        self::assertNull($actual->getMode());
        self::assertNull($actual->getDeviceLifecycle());
        self::assertNull($actual->getDeviceHealth());
        self::assertNull($actual->getSecurityArmState());
        self::assertNull($actual->getHubHealth());
        self::assertNull($actual->getSceneLifecycle());
    }

    public function testTransformSceneLifecycle(): void
    {
        $deviceSubscriptionDetailModel = self::createStub(DeviceSubscriptionDetailInterface::class);
        $deviceSubscriptionDetailTransformer = self::createStub(DeviceSubscriptionDetailTransformerInterface::class);
        $deviceSubscriptionDetailTransformer->method('transform')->willReturn($deviceSubscriptionDetailModel);
        $capabilitySubscriptionDetailModel = self::createStub(CapabilitySubscriptionDetailInterface::class);
        $capabilitySubscriptionDetailTransformer = self::createStub(CapabilitySubscriptionDetailTransformerInterface::class);
        $capabilitySubscriptionDetailTransformer->method('transform')->willReturn($capabilitySubscriptionDetailModel);
        $modeSubscriptionDetailModel = self::createStub(ModeSubscriptionDetailInterface::class);
        $modeSubscriptionDetailTransformer = self::createStub(ModeSubscriptionDetailTransformerInterface::class);
        $modeSubscriptionDetailTransformer->method('transform')->willReturn($modeSubscriptionDetailModel);
        $deviceLifecycleDetailModel = self::createStub(DeviceLifecycleDetailInterface::class);
        $deviceLifecycleDetailTransformer = self::createStub(DeviceLifecycleDetailTransformerInterface::class);
        $deviceLifecycleDetailTransformer->method('transform')->willReturn($deviceLifecycleDetailModel);
        $deviceHealthDetailModel = self::createStub(DeviceHealthDetailInterface::class);
        $deviceHealthDetailTransformer = self::createStub(DeviceHealthDetailTransformerInterface::class);
        $deviceHealthDetailTransformer->method('transform')->willReturn($deviceHealthDetailModel);
        $securityArmStateDetailModel = self::createStub(SecurityArmStateDetailInterface::class);
        $securityArmStateDetailTransformer = self::createStub(SecurityArmStateDetailTransformerInterface::class);
        $securityArmStateDetailTransformer->method('transform')->willReturn($securityArmStateDetailModel);
        $hubHealthDetailModel = self::createStub(HubHealthDetailInterface::class);
        $hubHealthDetailTransformer = self::createStub(HubHealthDetailTransformerInterface::class);
        $hubHealthDetailTransformer->method('transform')->willReturn($hubHealthDetailModel);
        $sceneLifecycleDetailModel = self::createStub(SceneLifecycleDetailInterface::class);
        $sceneLifecycleDetailTransformer = self::createStub(SceneLifecycleDetailTransformerInterface::class);
        $sceneLifecycleDetailTransformer->method('transform')->willReturn($sceneLifecycleDetailModel);
        $transformer = new SubscriptionDetailsTransformer($deviceSubscriptionDetailTransformer, $capabilitySubscriptionDetailTransformer, $modeSubscriptionDetailTransformer, $deviceLifecycleDetailTransformer, $deviceHealthDetailTransformer, $securityArmStateDetailTransformer, $hubHealthDetailTransformer, $sceneLifecycleDetailTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getSceneLifecycle());
        self::assertNull($transformer->transform($base + [SubscriptionDetailsTransformerInterface::KEY_SCENE_LIFECYCLE => 'test-not-array'])->getSceneLifecycle());
        self::assertSame($sceneLifecycleDetailModel, $transformer->transform($base + [SubscriptionDetailsTransformerInterface::KEY_SCENE_LIFECYCLE => ['test-nested']])->getSceneLifecycle());
    }

    public function testTransformSecurityArmState(): void
    {
        $deviceSubscriptionDetailModel = self::createStub(DeviceSubscriptionDetailInterface::class);
        $deviceSubscriptionDetailTransformer = self::createStub(DeviceSubscriptionDetailTransformerInterface::class);
        $deviceSubscriptionDetailTransformer->method('transform')->willReturn($deviceSubscriptionDetailModel);
        $capabilitySubscriptionDetailModel = self::createStub(CapabilitySubscriptionDetailInterface::class);
        $capabilitySubscriptionDetailTransformer = self::createStub(CapabilitySubscriptionDetailTransformerInterface::class);
        $capabilitySubscriptionDetailTransformer->method('transform')->willReturn($capabilitySubscriptionDetailModel);
        $modeSubscriptionDetailModel = self::createStub(ModeSubscriptionDetailInterface::class);
        $modeSubscriptionDetailTransformer = self::createStub(ModeSubscriptionDetailTransformerInterface::class);
        $modeSubscriptionDetailTransformer->method('transform')->willReturn($modeSubscriptionDetailModel);
        $deviceLifecycleDetailModel = self::createStub(DeviceLifecycleDetailInterface::class);
        $deviceLifecycleDetailTransformer = self::createStub(DeviceLifecycleDetailTransformerInterface::class);
        $deviceLifecycleDetailTransformer->method('transform')->willReturn($deviceLifecycleDetailModel);
        $deviceHealthDetailModel = self::createStub(DeviceHealthDetailInterface::class);
        $deviceHealthDetailTransformer = self::createStub(DeviceHealthDetailTransformerInterface::class);
        $deviceHealthDetailTransformer->method('transform')->willReturn($deviceHealthDetailModel);
        $securityArmStateDetailModel = self::createStub(SecurityArmStateDetailInterface::class);
        $securityArmStateDetailTransformer = self::createStub(SecurityArmStateDetailTransformerInterface::class);
        $securityArmStateDetailTransformer->method('transform')->willReturn($securityArmStateDetailModel);
        $hubHealthDetailModel = self::createStub(HubHealthDetailInterface::class);
        $hubHealthDetailTransformer = self::createStub(HubHealthDetailTransformerInterface::class);
        $hubHealthDetailTransformer->method('transform')->willReturn($hubHealthDetailModel);
        $sceneLifecycleDetailModel = self::createStub(SceneLifecycleDetailInterface::class);
        $sceneLifecycleDetailTransformer = self::createStub(SceneLifecycleDetailTransformerInterface::class);
        $sceneLifecycleDetailTransformer->method('transform')->willReturn($sceneLifecycleDetailModel);
        $transformer = new SubscriptionDetailsTransformer($deviceSubscriptionDetailTransformer, $capabilitySubscriptionDetailTransformer, $modeSubscriptionDetailTransformer, $deviceLifecycleDetailTransformer, $deviceHealthDetailTransformer, $securityArmStateDetailTransformer, $hubHealthDetailTransformer, $sceneLifecycleDetailTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getSecurityArmState());
        self::assertNull($transformer->transform($base + [SubscriptionDetailsTransformerInterface::KEY_SECURITY_ARM_STATE => 'test-not-array'])->getSecurityArmState());
        self::assertSame($securityArmStateDetailModel, $transformer->transform($base + [SubscriptionDetailsTransformerInterface::KEY_SECURITY_ARM_STATE => ['test-nested']])->getSecurityArmState());
    }
}
