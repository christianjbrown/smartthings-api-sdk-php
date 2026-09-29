<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityPresentationDetailsInterface;

interface CapabilityPresentationDetailsTransformerInterface
{
    public const string KEY_AUTOMATION = 'automation';
    public const string KEY_DASHBOARD = 'dashboard';
    public const string KEY_DETAIL_VIEW = 'detailView';
    public const string KEY_PRESENTATION_SETTINGS = 'presentationSettings';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityPresentationDetailsInterface;
}
