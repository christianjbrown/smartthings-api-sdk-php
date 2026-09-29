<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AppDetailsInterface;

interface AppDetailsTransformerInterface
{
    public const string KEY_ICON_IMAGE = 'iconImage';
    public const string KEY_LAMBDA_SMART_APP = 'lambdaSmartApp';
    public const string KEY_OWNER = 'owner';
    public const string KEY_UI = 'ui';
    public const string KEY_WEBHOOK_SMART_APP = 'webhookSmartApp';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppDetailsInterface;
}
