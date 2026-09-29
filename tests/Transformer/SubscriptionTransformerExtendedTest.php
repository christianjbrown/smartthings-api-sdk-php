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
use ChristianBrown\SmartThings\Model\Subscription;
use ChristianBrown\SmartThings\Model\SubscriptionDetailsInterface;
use ChristianBrown\SmartThings\Transformer\SubscriptionDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SubscriptionTransformer;
use ChristianBrown\SmartThings\Transformer\SubscriptionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Subscription::class)]
#[CoversClass(SubscriptionTransformer::class)]
final class SubscriptionTransformerExtendedTest extends TestCase
{
    public function testTransformExtendedNestedFields(): void
    {
        $device = self::createStub(DeviceSubscriptionDetailInterface::class);
        $capability = self::createStub(CapabilitySubscriptionDetailInterface::class);
        $mode = self::createStub(ModeSubscriptionDetailInterface::class);
        $deviceLifecycle = self::createStub(DeviceLifecycleDetailInterface::class);
        $deviceHealth = self::createStub(DeviceHealthDetailInterface::class);
        $securityArmState = self::createStub(SecurityArmStateDetailInterface::class);
        $hubHealth = self::createStub(HubHealthDetailInterface::class);
        $sceneLifecycle = self::createStub(SceneLifecycleDetailInterface::class);
        $details = self::createStub(SubscriptionDetailsInterface::class);
        $details->method('getDevice')->willReturn($device);
        $details->method('getCapability')->willReturn($capability);
        $details->method('getMode')->willReturn($mode);
        $details->method('getDeviceLifecycle')->willReturn($deviceLifecycle);
        $details->method('getDeviceHealth')->willReturn($deviceHealth);
        $details->method('getSecurityArmState')->willReturn($securityArmState);
        $details->method('getHubHealth')->willReturn($hubHealth);
        $details->method('getSceneLifecycle')->willReturn($sceneLifecycle);

        $data = [SubscriptionTransformerInterface::KEY_ID => 'test-id'] + [SubscriptionTransformerInterface::KEY_DEVICE => []];
        $containerTransformer = self::createMock(SubscriptionDetailsTransformerInterface::class);
        $containerTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($details);

        $transformer = new SubscriptionTransformer($containerTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($device, $actual->getDevice());
        self::assertSame($capability, $actual->getCapability());
        self::assertSame($mode, $actual->getMode());
        self::assertSame($deviceLifecycle, $actual->getDeviceLifecycle());
        self::assertSame($deviceHealth, $actual->getDeviceHealth());
        self::assertSame($securityArmState, $actual->getSecurityArmState());
        self::assertSame($hubHealth, $actual->getHubHealth());
        self::assertSame($sceneLifecycle, $actual->getSceneLifecycle());
    }

    public function testTransformExtendedNestedFieldsAbsent(): void
    {
        $details = self::createStub(SubscriptionDetailsInterface::class);
        $containerTransformer = self::createStub(SubscriptionDetailsTransformerInterface::class);
        $containerTransformer->method('transform')->willReturn($details);

        $transformer = new SubscriptionTransformer($containerTransformer);

        $actual = $transformer->transform([SubscriptionTransformerInterface::KEY_ID => 'test-id'] + [SubscriptionTransformerInterface::KEY_DEVICE => []]);

        self::assertNull($actual->getDevice());
        self::assertNull($actual->getCapability());
        self::assertNull($actual->getMode());
        self::assertNull($actual->getDeviceLifecycle());
        self::assertNull($actual->getDeviceHealth());
        self::assertNull($actual->getSecurityArmState());
        self::assertNull($actual->getHubHealth());
        self::assertNull($actual->getSceneLifecycle());
    }

    public function testTransformExtendedSkipsTheContainerWithoutNestedKeys(): void
    {
        $containerTransformer = self::createMock(SubscriptionDetailsTransformerInterface::class);
        $containerTransformer->expects(self::never())->method('transform');

        $transformer = new SubscriptionTransformer($containerTransformer);

        $actual = $transformer->transform([SubscriptionTransformerInterface::KEY_ID => 'test-id']);

        self::assertNull($actual->getDevice());
        self::assertNull($actual->getCapability());
        self::assertNull($actual->getMode());
        self::assertNull($actual->getDeviceLifecycle());
        self::assertNull($actual->getDeviceHealth());
        self::assertNull($actual->getSecurityArmState());
        self::assertNull($actual->getHubHealth());
        self::assertNull($actual->getSceneLifecycle());
    }
}
