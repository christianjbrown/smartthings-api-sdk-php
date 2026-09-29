<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemInterface;

interface ExcludedConditionItemIdExcludeItemSerializerInterface
{
    public const string KEY_ATTRIBUTES = 'attributes';
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_VERSION = 'version';

    /**
     * @return mixed[]
     */
    public function serialize(ExcludedConditionItemIdExcludeItemInterface $model): array;
}
