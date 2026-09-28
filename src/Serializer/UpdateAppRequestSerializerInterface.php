<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\UpdateAppRequestInterface;

interface UpdateAppRequestSerializerInterface
{
    public const string KEY_APP_TYPE = 'appType';
    public const string KEY_CLASSIFICATIONS = 'classifications';
    public const string KEY_DASHBOARD_CARDS_ENABLED = 'dashboardCardsEnabled';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_DISPLAY_NAME = 'displayName';
    public const string KEY_FUNCTIONS = 'functions';
    public const string KEY_ICON_IMAGE = 'iconImage';
    public const string KEY_LAMBDA_SMART_APP = 'lambdaSmartApp';
    public const string KEY_PLUGIN_ID = 'pluginId';
    public const string KEY_PLUGIN_URI = 'pluginUri';
    public const string KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED = 'preInstallDashboardCardsEnabled';
    public const string KEY_SINGLE_INSTANCE = 'singleInstance';
    public const string KEY_TARGET_URL = 'targetUrl';
    public const string KEY_UI = 'ui';
    public const string KEY_URL = 'url';
    public const string KEY_WEBHOOK_SMART_APP = 'webhookSmartApp';

    /**
     * @return mixed[]
     */
    public function serialize(UpdateAppRequestInterface $request): array;
}
