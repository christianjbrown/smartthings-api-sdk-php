<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\StateInterface;

interface StateSerializerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_LABEL = 'label';
    public const string KEY_UNIT = 'unit';

    /**
     * @return mixed[]
     */
    public function serialize(StateInterface $model): array;
}
