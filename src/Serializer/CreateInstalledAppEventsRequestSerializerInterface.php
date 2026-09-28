<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CreateInstalledAppEventsRequestInterface;

interface CreateInstalledAppEventsRequestSerializerInterface
{
    public const string KEY_ATTRIBUTES = 'attributes';
    public const string KEY_CARD_ID = 'cardId';
    public const string KEY_LIFECYCLE = 'lifecycle';
    public const string KEY_NAME = 'name';
    public const string KEY_SMART_APP_DASHBOARD_CARD_EVENTS = 'smartAppDashboardCardEvents';
    public const string KEY_SMART_APP_EVENTS = 'smartAppEvents';

    /**
     * @return mixed[]
     */
    public function serialize(CreateInstalledAppEventsRequestInterface $request): array;
}
