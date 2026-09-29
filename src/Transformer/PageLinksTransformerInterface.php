<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PageLinksInterface;

interface PageLinksTransformerInterface
{
    public const string KEY_NEXT = 'next';
    public const string KEY_PREVIOUS = 'previous';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PageLinksInterface;
}
