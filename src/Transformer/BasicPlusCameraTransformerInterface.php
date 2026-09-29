<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusCameraInterface;

interface BasicPlusCameraTransformerInterface
{
    public const string KEY_IMAGE = 'image';
    public const string KEY_OVERLAY_ICONS = 'overlayIcons';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusCameraInterface;
}
