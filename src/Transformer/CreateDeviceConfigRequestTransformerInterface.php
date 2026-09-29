<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CreateDeviceConfigRequestInterface;

interface CreateDeviceConfigRequestTransformerInterface
{
    public const string KEY_AUTOMATION = 'automation';
    public const string KEY_DASHBOARD = 'dashboard';
    public const string KEY_DETAIL_VIEW = 'detailView';
    public const string KEY_ICON_URL = 'iconUrl';
    public const string KEY_ICONS = 'icons';
    public const string KEY_TYPE = 'type';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CreateDeviceConfigRequestInterface;
}
