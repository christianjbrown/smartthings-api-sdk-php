<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ListWithAvailableSizeInterface;

interface ListWithAvailableSizeSerializerInterface
{
    public const string KEY_AVAILABLE_SIZES = 'availableSizes';
    public const string KEY_COMMAND = 'command';
    public const string KEY_STATE = 'state';

    /**
     * @return mixed[]
     */
    public function serialize(ListWithAvailableSizeInterface $model): array;
}
