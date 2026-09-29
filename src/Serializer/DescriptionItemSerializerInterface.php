<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DescriptionItemInterface;

interface DescriptionItemSerializerInterface
{
    public const string KEY_LABEL = 'label';
    public const string KEY_OPERATOR = 'operator';
    public const string KEY_VISIBLE_CONDITIONS = 'visibleConditions';

    /**
     * @return mixed[]
     */
    public function serialize(DescriptionItemInterface $model): array;
}
