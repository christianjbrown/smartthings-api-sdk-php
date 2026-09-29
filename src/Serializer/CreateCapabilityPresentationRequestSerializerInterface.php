<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequestInterface;

interface CreateCapabilityPresentationRequestSerializerInterface
{
    public const string KEY_AUTOMATION = 'automation';
    public const string KEY_DASHBOARD = 'dashboard';
    public const string KEY_DETAIL_VIEW = 'detailView';
    public const string KEY_ID = 'id';
    public const string KEY_PRESENTATION_SETTINGS = 'presentationSettings';
    public const string KEY_VERSION = 'version';

    /**
     * @return mixed[]
     */
    public function serialize(CreateCapabilityPresentationRequestInterface $request): array;
}
