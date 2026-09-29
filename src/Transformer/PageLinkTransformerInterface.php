<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PageLinkInterface;

interface PageLinkTransformerInterface
{
    public const string KEY_HREF = 'href';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PageLinkInterface;
}
