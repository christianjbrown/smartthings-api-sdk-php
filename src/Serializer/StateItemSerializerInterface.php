<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\StateItemInterface;

interface StateItemSerializerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_LABEL = 'label';

    /**
     * @return mixed[]
     */
    public function serialize(StateItemInterface $model): array;
}
