<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\InstalledAppDetailsInterface;

interface InstalledAppDetailsTransformerInterface
{
    public const string KEY_ICON_IMAGE = 'iconImage';
    public const string KEY_NOTICES = 'notices';
    public const string KEY_OWNER = 'owner';
    public const string KEY_UI = 'ui';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstalledAppDetailsInterface;
}
