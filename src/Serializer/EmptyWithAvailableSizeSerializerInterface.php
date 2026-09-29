<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\EmptyWithAvailableSizeInterface;

interface EmptyWithAvailableSizeSerializerInterface
{
    public const string KEY_AVAILABLE_SIZES = 'availableSizes';

    /**
     * @return mixed[]
     */
    public function serialize(EmptyWithAvailableSizeInterface $model): array;
}
