<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityAttributeLocalizationInterface;

interface CapabilityAttributeLocalizationTransformerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_DISPLAY_TEMPLATE = 'displayTemplate';
    public const string KEY_I18N = 'i18n';
    public const string KEY_LABEL = 'label';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityAttributeLocalizationInterface;
}
