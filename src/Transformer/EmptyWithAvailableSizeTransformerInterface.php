<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\EmptyWithAvailableSizeInterface;

interface EmptyWithAvailableSizeTransformerInterface
{
    public const string KEY_AVAILABLE_SIZES = 'availableSizes';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EmptyWithAvailableSizeInterface;
}
