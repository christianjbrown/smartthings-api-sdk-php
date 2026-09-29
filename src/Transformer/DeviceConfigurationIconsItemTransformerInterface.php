<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemInterface;

interface DeviceConfigurationIconsItemTransformerInterface
{
    public const string KEY_BADGE = 'badge';
    public const string KEY_GROUP = 'group';
    public const string KEY_ICON_URL = 'iconUrl';
    public const string KEY_PRODUCT_KEYS = 'productKeys';
    public const string KEY_RUNNING_CONDITIONS = 'runningConditions';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigurationIconsItemInterface;
}
