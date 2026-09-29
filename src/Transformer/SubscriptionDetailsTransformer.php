<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SubscriptionDetails;
use ChristianBrown\SmartThings\Model\SubscriptionDetailsInterface;

use function is_array;

final class SubscriptionDetailsTransformer implements SubscriptionDetailsTransformerInterface
{
    private CapabilitySubscriptionDetailTransformerInterface $capabilitySubscriptionDetailTransformer;
    private DeviceHealthDetailTransformerInterface $deviceHealthDetailTransformer;
    private DeviceLifecycleDetailTransformerInterface $deviceLifecycleDetailTransformer;
    private DeviceSubscriptionDetailTransformerInterface $deviceSubscriptionDetailTransformer;
    private HubHealthDetailTransformerInterface $hubHealthDetailTransformer;
    private ModeSubscriptionDetailTransformerInterface $modeSubscriptionDetailTransformer;
    private SceneLifecycleDetailTransformerInterface $sceneLifecycleDetailTransformer;
    private SecurityArmStateDetailTransformerInterface $securityArmStateDetailTransformer;

    public function __construct(DeviceSubscriptionDetailTransformerInterface $deviceSubscriptionDetailTransformer, CapabilitySubscriptionDetailTransformerInterface $capabilitySubscriptionDetailTransformer, ModeSubscriptionDetailTransformerInterface $modeSubscriptionDetailTransformer, DeviceLifecycleDetailTransformerInterface $deviceLifecycleDetailTransformer, DeviceHealthDetailTransformerInterface $deviceHealthDetailTransformer, SecurityArmStateDetailTransformerInterface $securityArmStateDetailTransformer, HubHealthDetailTransformerInterface $hubHealthDetailTransformer, SceneLifecycleDetailTransformerInterface $sceneLifecycleDetailTransformer)
    {
        $this->deviceSubscriptionDetailTransformer = $deviceSubscriptionDetailTransformer;
        $this->capabilitySubscriptionDetailTransformer = $capabilitySubscriptionDetailTransformer;
        $this->modeSubscriptionDetailTransformer = $modeSubscriptionDetailTransformer;
        $this->deviceLifecycleDetailTransformer = $deviceLifecycleDetailTransformer;
        $this->deviceHealthDetailTransformer = $deviceHealthDetailTransformer;
        $this->securityArmStateDetailTransformer = $securityArmStateDetailTransformer;
        $this->hubHealthDetailTransformer = $hubHealthDetailTransformer;
        $this->sceneLifecycleDetailTransformer = $sceneLifecycleDetailTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SubscriptionDetailsInterface
    {
        $model = new SubscriptionDetails();

        $this->applyDevice($model, $data);
        $this->applyCapability($model, $data);
        $this->applyMode($model, $data);
        $this->applyDeviceLifecycle($model, $data);
        $this->applyDeviceHealth($model, $data);
        $this->applySecurityArmState($model, $data);
        $this->applyHubHealth($model, $data);
        $this->applySceneLifecycle($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCapability(SubscriptionDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_CAPABILITY])) {
            return;
        }
        if (!is_array($data[self::KEY_CAPABILITY])) {
            return;
        }
        $model->setCapability($this->capabilitySubscriptionDetailTransformer->transform($data[self::KEY_CAPABILITY]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDevice(SubscriptionDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_DEVICE])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICE])) {
            return;
        }
        $model->setDevice($this->deviceSubscriptionDetailTransformer->transform($data[self::KEY_DEVICE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDeviceHealth(SubscriptionDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_DEVICE_HEALTH])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICE_HEALTH])) {
            return;
        }
        $model->setDeviceHealth($this->deviceHealthDetailTransformer->transform($data[self::KEY_DEVICE_HEALTH]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDeviceLifecycle(SubscriptionDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_DEVICE_LIFECYCLE])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICE_LIFECYCLE])) {
            return;
        }
        $model->setDeviceLifecycle($this->deviceLifecycleDetailTransformer->transform($data[self::KEY_DEVICE_LIFECYCLE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyHubHealth(SubscriptionDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_HUB_HEALTH])) {
            return;
        }
        if (!is_array($data[self::KEY_HUB_HEALTH])) {
            return;
        }
        $model->setHubHealth($this->hubHealthDetailTransformer->transform($data[self::KEY_HUB_HEALTH]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyMode(SubscriptionDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_MODE])) {
            return;
        }
        if (!is_array($data[self::KEY_MODE])) {
            return;
        }
        $model->setMode($this->modeSubscriptionDetailTransformer->transform($data[self::KEY_MODE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySceneLifecycle(SubscriptionDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_SCENE_LIFECYCLE])) {
            return;
        }
        if (!is_array($data[self::KEY_SCENE_LIFECYCLE])) {
            return;
        }
        $model->setSceneLifecycle($this->sceneLifecycleDetailTransformer->transform($data[self::KEY_SCENE_LIFECYCLE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySecurityArmState(SubscriptionDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_SECURITY_ARM_STATE])) {
            return;
        }
        if (!is_array($data[self::KEY_SECURITY_ARM_STATE])) {
            return;
        }
        $model->setSecurityArmState($this->securityArmStateDetailTransformer->transform($data[self::KEY_SECURITY_ARM_STATE]));
    }
}
