<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;

/**
 * A JSON request sender whose GET requests follow the `_links.next.href` chain of a
 * paged list and answer with every page's `items` in one response.
 */
interface PagingJsonApiRequestSenderInterface extends JsonApiRequestSenderInterface
{
    public const string KEY_HREF = 'href';
    public const string KEY_ITEMS = 'items';
    public const string KEY_LINKS = '_links';
    public const string KEY_NEXT = 'next';
}
