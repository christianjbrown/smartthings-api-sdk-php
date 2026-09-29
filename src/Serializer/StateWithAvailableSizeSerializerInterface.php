<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\StateWithAvailableSizeInterface;

interface StateWithAvailableSizeSerializerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_AVAILABLE_SIZES = 'availableSizes';
    public const string KEY_LABEL = 'label';
    public const string KEY_UNIT = 'unit';

    /**
     * @return mixed[]
     */
    public function serialize(StateWithAvailableSizeInterface $model): array;
}
