<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemInterface;

interface VisibleConditionForColorItemSerializerInterface
{
    public const string KEY_OPERAND = 'operand';
    public const string KEY_OPERATOR = 'operator';
    public const string KEY_REFER_TO = 'referTo';

    /**
     * @return mixed[]
     */
    public function serialize(VisibleConditionForColorItemInterface $model): array;
}
