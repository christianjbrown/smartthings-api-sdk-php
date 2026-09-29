<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityLocalizationRequestInterface;

interface CapabilityLocalizationRequestSerializerInterface
{
    public const string KEY_ARGUMENTS = 'arguments';
    public const string KEY_ATTRIBUTES = 'attributes';
    public const string KEY_COMMANDS = 'commands';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_DISPLAY_TEMPLATE = 'displayTemplate';
    public const string KEY_I18N = 'i18n';
    public const string KEY_LABEL = 'label';
    public const string KEY_TAG = 'tag';

    /**
     * @return mixed[]
     */
    public function serialize(CapabilityLocalizationRequestInterface $request): array;
}
