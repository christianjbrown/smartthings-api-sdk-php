<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityPresentationInterface;

interface CapabilityPresentationTransformerInterface
{
    public const array DETAIL_KEYS = [self::KEY_DASHBOARD, self::KEY_DETAIL_VIEW, self::KEY_AUTOMATION, self::KEY_PRESENTATION_SETTINGS];
    public const string KEY_AUTOMATION = 'automation';
    public const string KEY_DASHBOARD = 'dashboard';
    public const string KEY_DETAIL_VIEW = 'detailView';
    public const string KEY_ID = 'id';
    public const string KEY_PRESENTATION_SETTINGS = 'presentationSettings';
    public const string KEY_VERSION = 'version';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityPresentationInterface;
}
