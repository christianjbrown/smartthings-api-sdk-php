<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationInterface;

interface DeviceConfigurationSerializerInterface
{
    public const string KEY_AUTOMATION = 'automation';
    public const string KEY_DASHBOARD = 'dashboard';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_DETAIL_VIEW = 'detailView';
    public const string KEY_DP_INFO = 'dpInfo';
    public const string KEY_DP_INFOS = 'dpInfos';
    public const string KEY_ICON_URL = 'iconUrl';
    public const string KEY_ICONS = 'icons';
    public const string KEY_MANUFACTURER_NAME = 'manufacturerName';
    public const string KEY_MNMN = 'mnmn';
    public const string KEY_PRESENTATION_ID = 'presentationId';
    public const string KEY_TYPE = 'type';
    public const string KEY_VERSION = 'version';
    public const string KEY_VID = 'vid';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationInterface $model): array;
}
