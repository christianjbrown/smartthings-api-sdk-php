<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PageLink;
use ChristianBrown\SmartThings\Model\PageLinkInterface;

use function is_string;

final class PageLinkTransformer implements PageLinkTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PageLinkInterface
    {
        $model = new PageLink();

        self::applyHref($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHref(PageLink $model, array $data): void
    {
        if (empty($data[self::KEY_HREF])) {
            return;
        }
        if (!is_string($data[self::KEY_HREF])) {
            return;
        }
        $model->setHref($data[self::KEY_HREF]);
    }
}
