<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemReferToInterface;

interface VisibleConditionForColorItemReferToSerializerInterface
{
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_VALUE = 'value';
    public const string KEY_VALUE_TYPE = 'valueType';
    public const string KEY_VERSION = 'version';

    /**
     * @return mixed[]
     */
    public function serialize(VisibleConditionForColorItemReferToInterface $model): array;
}
