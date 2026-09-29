<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInvitePageInterface;

interface SchemaAppInvitePageTransformerInterface
{
    public const string KEY_ITEMS = 'items';
    public const string KEY_LINKS = 'links';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppInvitePageInterface;
}
