<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\UpdateCapabilityPresentationRequestInterface;

interface UpdateCapabilityPresentationRequestSerializerInterface
{
    public const string KEY_AUTOMATION = 'automation';
    public const string KEY_DASHBOARD = 'dashboard';
    public const string KEY_DETAIL_VIEW = 'detailView';
    public const string KEY_PRESENTATION_SETTINGS = 'presentationSettings';

    /**
     * @return mixed[]
     */
    public function serialize(UpdateCapabilityPresentationRequestInterface $model): array;
}
