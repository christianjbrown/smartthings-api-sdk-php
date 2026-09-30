<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfig;
use ChristianBrown\SmartThings\Model\DeviceConfigInterface;

final class DeviceConfigTransformer implements DeviceConfigTransformerInterface
{
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader)
    {
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigInterface
    {
        return (new DeviceConfig())
            ->setDeviceId($this->valueReader->string($data, self::KEY_DEVICE_ID))
            ->setComponentId($this->valueReader->string($data, self::KEY_COMPONENT_ID))
            ->setPermissions($this->valueReader->strings($data, self::KEY_PERMISSIONS));
    }
}
