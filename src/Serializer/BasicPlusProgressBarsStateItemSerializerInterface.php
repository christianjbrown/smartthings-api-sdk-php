<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusProgressBarsStateItemInterface;

interface BasicPlusProgressBarsStateItemSerializerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_FORMAT_INFO = 'formatInfo';
    public const string KEY_ICON_URL = 'iconUrl';
    public const string KEY_LABEL = 'label';
    public const string KEY_PLACEMENT = 'placement';
    public const string KEY_VERSION = 'version';

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusProgressBarsStateItemInterface $model): array;
}
