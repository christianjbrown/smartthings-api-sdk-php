<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemAttributesItemInterface;

interface ExcludedConditionItemIdExcludeItemAttributesItemSerializerInterface
{
    public const string KEY_EXCLUDED_VALUES = 'excludedValues';
    public const string KEY_NAME = 'name';

    /**
     * @return mixed[]
     */
    public function serialize(ExcludedConditionItemIdExcludeItemAttributesItemInterface $model): array;
}
